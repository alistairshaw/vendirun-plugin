<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;

class Cart {

    /**
     * @var array
     */
    private $ids;

    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @var bool
     */
    private $priceIncludesTax;

    /**
     * @var bool
     */
    private $chargeTaxOnShipping;

    /**
     * @var float
     */
    private $defaultTaxRate;

    /**
     * @var int
     */
    private $orderShippingPrice;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * @var array
     */
    private $availableShippingTypes;

    /**
     * Cart constructor.
     * @param array $params | required: ids,items,defaultTaxRate | optional: priceIncludesTax,chargeTaxOnShipping
     */
    public function __construct($params)
    {
        $this->ids = $params['ids'];
        $this->priceIncludesTax = $params['priceIncludesTax'];
        $this->chargeTaxOnShipping = $params['chargeTaxOnShipping'];
        $this->defaultTaxRate = $params['defaultTaxRate'];

        $this->priceIncludesTax = (isset($params['priceIncludesTax'])) ? $params['priceIncludesTax'] : true;
        $this->chargeTaxOnShipping = (isset($params['chargeTaxOnShipping'])) ? $params['chargeTaxOnShipping'] : true;

        if (isset($params['items']))
        {
            $this->items = $params['items'];
        }
        else
        {
            $this->items = [];
        }
        if (isset($params['countryId'])) $this->countryId = (int)$params['countryId'];
        if (isset($params['shippingType'])) $this->shippingType = $params['shippingType'];

        $this->setShippingPrice();
        $this->setTaxPrice();
    }

    /**
     * @return array
     */
    public function shippingBreakdown()
    {
        $itemShipping = [];
        foreach ($this->items as $item)
        {
            $itemShipping[] = ShippingCalculator::shippingForItem($item->getShipping(), $item->getQuantity(), $this->countryId, $this->shippingType);
        }

        // order shipping
        $shipping = [
            'order' => $this->orderShippingPrice,
            'items' => $itemShipping
        ];

        return $shipping;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->items ? count($this->items) : 0;
    }

    /**
     * @return array
     */
    public function displayItems()
    {
        $final = [];
        if (!$this->items) return $final;
        foreach ($this->items as $item)
        {
            $final[] = $item->display();
        }

        return $final;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @param $countryId
     * @return $this
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
        $this->setShippingPrice();
        $this->setTaxPrice();

        return $this;
    }

    /**
     * @return float
     */
    public function getDefaultTaxRate()
    {
        return $this->defaultTaxRate;
    }

    /**
     * @return array
     */
    public function getAvailableShippingTypes()
    {
        return $this->availableShippingTypes;
    }

    /**
     * @return string
     */
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * @param $shippingType
     * @return $this
     */
    public function setShippingType($shippingType)
    {
        $set = false;
        foreach ($this->availableShippingTypes as $availableType)
        {
            if ($shippingType == $availableType)
            {
                $set = true;
                $this->shippingType = $shippingType;
            }
        }
        if (!$set && count($this->availableShippingTypes) > 0) $this->shippingType = $this->availableShippingTypes[0];

        $this->setShippingPrice();

        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function getPriceIncludesTax()
    {
        return $this->priceIncludesTax;
    }

    /**
     * @return int
     */
    public function totalProducts()
    {
        return count($this->ids);
    }

    /**
     * including price, tax and shipping
     * @return int
     */
    public function total()
    {
        return $this->sum('total') + $this->orderShippingBeforeTax() + $this->orderShippingTax();
    }

    /**
     * including price and tax
     * @return int
     */
    public function totalWithoutShipping()
    {
        return $this->sum('totalWithoutShipping');
    }

    /**
     * price before tax and without shipping
     * @return int
     */
    public function totalBeforeTax()
    {
        $total = $this->sum('displayTotal');
        return $this->priceIncludesTax ? $total - $this->taxWithoutShipping() : $total;
    }

    /**
     * just price without shipping or tax
     * @return int
     */
    public function displayTotal()
    {
        return $this->sum('displayTotal');
    }

    /**
     * order shipping only
     * @return int
     */
    public function displayOrderShipping()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        return $this->orderShippingPrice;
    }

    /**
     * order shipping before tax (not including individual products)
     * @return int
     */
    public function orderShippingBeforeTax()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        return $this->priceIncludesTax ? $this->orderShippingPrice - TaxCalculator::taxFromTotal($this->orderShippingPrice, $this->defaultTaxRate) : $this->orderShippingPrice;
    }

    /**
     * order shipping tax amount (not including individual products)
     * @return int
     */
    public function orderShippingTax()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        return $this->priceIncludesTax ? TaxCalculator::taxFromTotal($this->orderShippingPrice, $this->defaultTaxRate) : TaxCalculator::totalPlusTax($this->orderShippingPrice, $this->defaultTaxRate);
    }

    /**
     * total shipping including tax
     * @return int
     */
    public function shipping()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        return $this->sum('shipping') + $this->orderShippingBeforeTax() + $this->orderShippingTax();
    }

    /**
     * total shipping before tax
     * @return int
     */
    public function shippingBeforeTax()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        return $this->sum('shippingBeforeTax') + $this->orderShippingBeforeTax();
    }

    /**
     * @return int
     */
    public function shippingTax()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        $shippingTotal = $this->sum('rawShipping') + $this->orderShippingPrice;
        return $this->priceIncludesTax ? TaxCalculator::taxFromTotal($shippingTotal, $this->getDefaultTaxRate()) : (int)($shippingTotal / 100 * $this->getDefaultTaxRate());
    }

    /**
     * shipping display value
     * @return int
     */
    public function displayShipping()
    {
        if ($this->orderShippingPrice === NULL) return NULL;

        $shippingPrice = $this->orderShippingPrice;
        foreach ($this->items as $item)
        {
            $shippingPrice += ($item->rawShipping() * $item->getQuantity());
        }
        return $shippingPrice;
    }

    /**
     * total amount of tax including shipping tax
     * @return int
     */
    public function tax()
    {
        return $this->sum('tax') + $this->orderShippingTax();
    }

    /**
     * total amount of tax excluding shipping tax
     * @return int
     */
    public function taxWithoutShipping()
    {
        $basePrice = $this->sum('displayTotal');
        return $this->priceIncludesTax ? TaxCalculator::taxFromTotal($basePrice, $this->getDefaultTaxRate()) : ($basePrice / 100 * $this->getDefaultTaxRate());
    }

    /**
     * @return object
     */
    public function getFormattedTotals()
    {
        return (object)[
            'displayTotal' => CurrencyHelper::formatWithCurrency($this->displayTotal()),
            'tax' => CurrencyHelper::formatWithCurrency($this->tax()),
            'displayShipping' => $this->displayShipping() === NULL ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($this->displayShipping(), false, '0.00'),
            'total' => CurrencyHelper::formatWithCurrency($this->total(), false, '0.00'),
            'totalBeforeTax' => CurrencyHelper::formatWithCurrency($this->totalBeforeTax(), false, '0.00'),
            'shippingBeforeTax' => $this->displayShipping() === NULL ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($this->shippingBeforeTax(), false, '0.00')
        ];
    }

    /**
     * @param CartItem $cartItem
     */
    public function add(CartItem $cartItem)
    {
        // check if cart item already in items
        $found = false;
        foreach ($this->items as $currentItem)
        {
            /* @var $currentItem CartItem */
            if ($currentItem->getVariationId() == $cartItem->getVariationId())
            {
                $found = true;
                $currentItem->setQuantity($currentItem->getQuantity() + $cartItem->getQuantity());
            }
        }

        if (!$found) $this->items[] = $cartItem;
        $this->setShippingPrice();

        $this->checkIdList();
    }

    /**
     * @param     $productVariationId
     * @param int $quantity
     */
    public function remove($productVariationId, $quantity = 1)
    {
        $newItems = [];
        foreach ($this->items as $item)
        {
            /* @var $item CartItem */
            if ($item->getVariationId() !== $productVariationId)
            {
                $newItems[] = $item;
            }
            else
            {
                if (!$item->remove($quantity))
                {
                    $newItems[] = $item;
                }
            }
        }

        $this->items = $newItems;
    }

    /**
     * Empty Cart
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * @param int $productId
     * @return int
     */
    public function countProducts($productId)
    {
        $total = 0;
        foreach ($this->items as $cartItem)
        {
            /* @var $cartItem CartItem */
            if ($cartItem->getProduct()->getId() == $productId) $total += $cartItem->getQuantity();
        }

        return $total;
    }

    /**
     * Remove any items from the id list that are not in the items
     */
    private function checkIdList()
    {
        $newIds = [];
        foreach ($this->ids as $id)
        {
            $found = false;
            foreach ($this->items as $item)
            {
                /* @var $cartItem CartItem */
                if ($item->getVariationId() == $id) $found = true;
            }
            if ($found) $newIds[] = $id;
        }

        $this->ids = $newIds;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $items = [];
        foreach ($this->items as $cartItem)
        {
            /* @var $cartItem CartItem */
            $items[] = $cartItem->display();
        }

        return [
            'totals' => $this->getFormattedTotals(),
            'shippingTypeId' => $this->getShippingType(),
            'countryId' => $this->getCountryId(),
            'availableShippingTypes' => $this->getAvailableShippingTypes(),
            'items' => $items,
            'itemCount' => $this->totalProducts()
        ];
    }

    /**
     * @param $cartItemFunctionName
     * @return int
     */
    private function sum($cartItemFunctionName)
    {
        $total = 0;
        foreach ($this->items as $cartItem)
        {
            if ($cartItem->{$cartItemFunctionName}() === NULL)
            {
                $total = NULL;
            }
            else
            {
                $total += $cartItem->{$cartItemFunctionName}();
            }
        }

        return $total;
    }

    /**
     * Update shipping prices
     */
    private function setShippingPrice()
    {
        if (!$this->countryId) $this->countryId = CustomerHelper::getDefaultCountry();

        $this->availableShippingTypes = ShippingCalculator::availableShippingTypes($this);

        if (!$this->shippingType && count($this->availableShippingTypes) > 0) $this->shippingType = $this->availableShippingTypes[0];
        $this->orderShippingPrice = ShippingCalculator::orderShippingCharge($this);

        foreach ($this->items as $item)
        {
            $item->setCountryId($this->countryId);
            $item->setShippingType($this->shippingType);
        }
    }

    /**
     * Update taxes based on country ID
     */
    private function setTaxPrice()
    {
        foreach ($this->items as $item)
        {
            /* @var $item CartItem */
            $item->setTaxPrice($this->countryId, $this->defaultTaxRate);
        }
    }

}