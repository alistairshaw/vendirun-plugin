<?php namespace AlistairShaw\Vendirun\App\Lib\Cart;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
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
     * Cart constructor.
     * @param array $items
     * @param null  $countryId | Use this to calculate correct shipping and tax rates
     */
    public function __construct($items = [], $countryId = null)
    {
        $this->countryId = $countryId;

        if (count($items))
        {
            $this->items = $items;
        }
        else
        {
            $this->items = Session::get('shoppingCart', []);
        }
    }

    /**
     * @param $productVariationId
     */
    public function add($productVariationId)
    {
        $this->items[] = $productVariationId;
        var_dump($this->items);
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
     * @return object
     */
    public function getProducts()
    {
        $finalCart = [
            'totalProducts' => 0,
            'totalQuantity' => count($this->items),
            'products' => [],
            'subTotal' => 0,
            'tax' => 0,
            'total' => 0
        ];

        if (count($this->items) == 0) return (object)$finalCart;

        $products = VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $this->items)])->getData();
        $finalCart['totalProducts'] = $products->total_rows;

        // todo: fix this monstrosity
        foreach ($this->getUniqueList() as $productVariationId => $quantity)
        {
            foreach ($products->result as $product)
            {
                foreach ($product->variations as $var)
                {
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
                            'itemTotal' => $itemTotal
                        ];

                        $finalCart['subTotal'] += $itemSubTotal;
                        $finalCart['tax'] += $itemTax;
                        $finalCart['total'] += $itemTotal;
                    }
                }
            }
        }

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
        Session::put('shoppingCart', $this->items);
        Session::save();
    }

    /**
     * @param $tax
     * @return mixed
     */
    private function calculateTaxRate($tax)
    {
        foreach ($tax as $row)
        {
            if (!$this->countryId && !$row->id)
            {
                $this->priceIncludesTax = $row->price_includes_tax;
                $this->chargeTaxOnShipping = $row->charge_tax_on_shipping;
                return (float)$row->percentage;
            }
            foreach ($row->countries as $country_id)
            {
                if ($this->countryId == $country_id) return (float)$row->percentage;
            }
        }

        return 0;
    }

}