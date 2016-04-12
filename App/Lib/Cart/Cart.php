<?php namespace AlistairShaw\Vendirun\App\Lib\Cart;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Mockery\CountValidator\Exception;
use Session;

class Cart {

    /**
     * @var array
     */
    protected $items;

    /**
     * @var int
     */
    protected $countryId;

    /**
     * @var bool
     */
    protected $priceIncludesTax;

    /**
     * @var bool
     */
    protected $chargeTaxOnShipping;

    /**
     * @var float
     */
    protected $defaultTaxRate;

    /**
     * @var int
     */
    protected $orderShippingCharge;

    /**
     * @var string
     */
    protected $shippingType;

    /**
     * @var array
     */
    protected $availableShippingTypes = [];

    /**
     * Cart constructor.
     * @param array $items
     * @param null  $countryId | Use this to calculate correct shipping and tax rates
     * @param null  $shippingType
     */
    public function __construct($items = [], $countryId = NULL, $shippingType = NULL)
    {
        $this->countryId = $countryId;
        $this->shippingType = $shippingType;

        if (count($items))
        {
            $this->items = $items;
        }
        else
        {
            if (Session::has('shoppingCart'))
            {
                $this->items = Session::get('shoppingCart');
            }
            else
            {
                $this->retrieve();
            }
        }
    }

    /**
     * @param $productVariationId
     */
    public function add($productVariationId)
    {
        $this->items[] = $productVariationId;
        $this->persist();
    }

    /**
     * @param $productVariationId
     */
    public function remove($productVariationId)
    {
        $newItems = [];
        $removed = false;
        foreach ($this->items as $item)
        {
            if ($item !== $productVariationId || $removed)
            {
                $newItems[] = $item;
            }
            else
            {
                $removed = true;
            }
        }
        $this->items = $newItems;
        $this->persist();
    }

    public function clear()
    {
        $this->items = [];
        $this->persist();
    }

    /**
     * Use this function on login or when you want to force
     *    an update to the API
     */
    public function updateApi()
    {
        $this->persist();
    }

    /**
     * @return object
     */
    public function getProducts()
    {
        $finalCart = [
            'totalProducts' => 0,
            'totalQuantity' => count($this->items),
            'items' => [],
            'shipping' => 0,
            'shippingType' => '',
            'availableShippingTypes' => [],
            'countryId' => $this->countryId,
            'subTotal' => 0,
            'tax' => 0,
            'total' => 0
        ];

        if (count($this->items) == 0) return (object)$finalCart;

        $products = VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $this->items)])->getData();
        $finalCart['totalProducts'] = $products->total_rows;

        $totalShipping = 0;

        // todo: fix this monstrosity - make factory classes for products and items and VOs for each
        foreach ($this->getUniqueList() as $productVariationId => $quantity)
        {
            foreach ($products->result as $product)
            {
                $var = $product->variations{0};
                if ($var->id == $productVariationId)
                {
                    $taxRate = $this->calculateTaxRate($product->tax);

                    if ($this->priceIncludesTax)
                    {
                        $itemSubTotal = (int)(round(($var->price * 100 / ($taxRate + 100) * $quantity), 0));
                        $itemTax = ($var->price * $quantity) - $itemSubTotal;
                    }
                    else
                    {
                        $itemSubTotal = $var->price * $quantity;
                        $itemTax = (int)(round(($var->price * $taxRate / 100 * $quantity), 0));
                    }

                    $itemTotal = $itemSubTotal + $itemTax;

                    $itemShipping = $this->shippingForItem($product->shipping, $quantity);
                    if ($itemShipping === NULL) $totalShipping = NULL;
                    if ($totalShipping !== NULL) $totalShipping += $itemShipping;

                    $finalCart['items'][] = (object)[
                        'productVariationId' => $productVariationId,
                        'quantity' => $quantity,
                        'taxRate' => $taxRate,
                        'chargeTaxOnShipping' => $this->chargeTaxOnShipping,
                        'priceIncludesTax' => $this->priceIncludesTax,
                        'productVariation' => $var,
                        'product' => $product,
                        'basePrice' => $var->price,
                        'itemTax' => $itemTax,
                        'itemSubTotal' => $itemSubTotal,
                        'itemTotal' => $itemTotal,
                        'shippingForItem' => $itemShipping
                    ];

                    $finalCart['subTotal'] += $itemSubTotal;
                    $finalCart['tax'] += $itemTax;
                    $finalCart['total'] += $itemTotal;
                }
            }
        }

        if ($totalShipping !== NULL) $totalShipping += $this->orderShippingCharge;

        $finalCart['shipping'] = $totalShipping;
        $finalCart['shippingType'] = $this->shippingType;
        $finalCart['availableShippingTypes'] = $this->availableShippingTypes;

        if ($this->chargeTaxOnShipping) $finalCart['tax'] += (int)($finalCart['shipping'] / 100 * $this->defaultTaxRate);

        return (object)$finalCart;
    }

    private function getUniqueList()
    {
        $final = [];
        foreach ($this->items as $item)
        {
            if (!isset($final[$item])) $final[$item] = 0;
            $final[$item]++;
        }

        return $final;
    }

    private function persist()
    {
        if (Session::has('token'))
        {
            try
            {
                $data = [
                    'token' => Session::get('token'),
                    'ids' => $this->items
                ];
                $this->setCart(VendirunApi::makeRequest('cart/update', $data)->getData());
            }
            catch (Exception $e)
            {
                $this->saveToSession();
            }
        }
        else
        {
            $this->saveToSession();
        }
    }

    private function retrieve()
    {
        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $this->setCart(VendirunApi::makeRequest('cart/fetch', $data)->getData());
        }
        catch (FailResponseException $e)
        {
            $this->items = [];
            $this->saveToSession();
        }
    }

    /**
     * @param $cart
     */
    private function setCart($cart)
    {
        $newItems = [];
        foreach ($cart->items as $item)
        {
            for ($i = 1; $i <= $item->quantity; $i++)
            {
                $newItems[] = $item->product_variation_id;
            }
        }
        $this->items = $newItems;
        $this->saveToSession();
    }

    private function saveToSession()
    {
        Session::put('shoppingCart', $this->items);
        Session::save();
    }

    /**
     * @param $tax
     * @return int
     */
    private function calculateTaxRate($tax)
    {
        $default = 0;
        $defaultIncludesTax = NULL;

        foreach ($tax as $row)
        {
            if (!$this->countryId && !$row->id)
            {
                $this->priceIncludesTax = $row->price_includes_tax;
                $this->chargeTaxOnShipping = $row->charge_tax_on_shipping;
                $this->defaultTaxRate = (float)$row->percentage;

                return (float)$row->percentage;
            }
            if (in_array($this->countryId, (array)$row->countries))
            {
                $this->chargeTaxOnShipping = $row->charge_tax_on_shipping;
                $this->defaultTaxRate = (float)$row->percentage;
                return (float)$row->percentage;
            }
            if ($row->id === NULL)
            {
                $default = (float)$row->percentage;
                $defaultIncludesTax = $row->price_includes_tax;
                $this->defaultTaxRate = (float)$row->percentage;
                $this->chargeTaxOnShipping = $row->charge_tax_on_shipping;
            }
        }

        $this->priceIncludesTax = $defaultIncludesTax;

        return $default;
    }

    /**
     * @param $shipping
     * @param $quantity
     * @return int|null
     */
    private function shippingForItem($shipping, $quantity)
    {
        $this->availableShippingTypes = [];

        $hasPrices = false;
        $price = NULL;

        foreach ($shipping as $sh)
        {
            if (in_array($this->countryId, $sh->countries))
            {
                $this->availableShippingTypes[] = $sh->shipping_type;

                $hasPrices = true;
                if (!$this->shippingType) $this->shippingType = $sh->shipping_type;

                if ($this->shippingType && $this->shippingType == $sh->shipping_type)
                {
                    if ($sh->order_price > $this->orderShippingCharge) $this->orderShippingCharge = $sh->order_price;
                    $price = $sh->product_price;
                }
            }
        }

        if ($hasPrices && $price === NULL && $this->shippingType)
        {
            $this->shippingType = NULL;

            return $this->shippingForItem($shipping, $quantity);
        }

        if ($price !== NULL) $price *= $quantity;

        return $price;
    }

}