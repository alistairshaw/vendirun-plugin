<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesTransformer;
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
     * @var bool
     */
    private $freeShipping = false;

    /**
     * Cart constructor.
     * @param array $params | required: ids,items,defaultTaxRate | optional: priceIncludesTax,chargeTaxOnShipping
     */
    public function __construct($params)
    {
        $this->priceIncludesTax = $params['priceIncludesTax'];
        $this->chargeTaxOnShipping = $params['chargeTaxOnShipping'];
        $this->defaultTaxRate = $params['defaultTaxRate'];

        $this->priceIncludesTax = (isset($params['priceIncludesTax'])) ? $params['priceIncludesTax'] : true;
        $this->chargeTaxOnShipping = (isset($params['chargeTaxOnShipping'])) ? $params['chargeTaxOnShipping'] : true;

        if (isset($params['countryId'])) $this->countryId = (int)$params['countryId'];
        if (isset($params['shippingType'])) $this->shippingType = $params['shippingType'];
        if (isset($params['freeShipping'])) $this->freeShipping = $params['freeShipping'];

        $this->items = [];
        $this->ids = [];

        $this->setShippingPrice();
        $this->setTaxPrice();
    }

    /**
     * @param CartValuesTransformer $transformer
     * @return mixed
     */
    public function getValues(CartValuesTransformer $transformer)
    {
        return $transformer->getValues($this->orderShippingPrice, $this->chargeTaxOnShipping, $this->freeShipping, $this->defaultTaxRate, $this->items);
    }

    /**
     * @param $transformer
     * @return mixed
     */
    public function getFormattedValues($transformer)
    {
        $values = $this->getValues($transformer);
        foreach ($values as $key => $value)
        {
            $values[$key] = CurrencyHelper::formatWithCurrency($value, false, '');
        }

        return $values;
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
        $total = 0;
        foreach ($this->items as $cartItem)
        {
            /* @var $cartItem CartItem */
            $total += $cartItem->getQuantity();
        }

        return $total;
    }

    /**
     * @param CartItem $cartItem
     */
    public function add(CartItem $cartItem)
    {
        $this->ids[] = $cartItem->getVariationId();

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
    public function checkIdList()
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
     * @param CartValuesTransformer $transformer
     * @param $freeShippingMinimumOrder
     * @param $freeShippingCountries
     * @return $this
     */
    public function updateForFreeShipping(CartValuesTransformer $transformer, $freeShippingMinimumOrder, $freeShippingCountries)
    {
        $values = $this->getValues($transformer);

        if (!in_array($this->countryId, explode(",", $freeShippingCountries))) return $this;

        if ($values['displayTotal'] < $freeShippingMinimumOrder) return $this;

        $shippingType = trans('vendirun::checkout.freeShipping');

        $this->freeShipping = true;
        $this->orderShippingPrice = 0;
        $this->shippingType = $shippingType;
        $newItems = [];
        foreach ($this->getItems() as $item)
        {
            /* @var $item CartItem */
            $item = $item->freeShipping($shippingType);
            $newItems[] = $item;
        }
        $this->items = $newItems;

        return $this;
    }

    /**
     * @param CartValuesTransformer $cartValuesTransformer
     * @return array
     */
    public function toArray(CartValuesTransformer $cartValuesTransformer = null)
    {
        $items = [];
        foreach ($this->items as $cartItem)
        {
            /* @var $cartItem CartItem */
            $items[] = $cartItem->display();
        }

        $totals = [];
        $displayTotals = [];
        if ($cartValuesTransformer)
        {
            $totals = $this->getValues($cartValuesTransformer);
            $displayTotals = array_map(function($item) {
                return CurrencyHelper::formatWithCurrency($item, false, '');
            }, $totals);

            if ($this->orderShippingPrice === null) $displayTotals['displayShipping'] = 'NOT AVAILABLE';
        }

        return [
            'shippingTypeId' => $this->getShippingType(),
            'countryId' => $this->getCountryId(),
            'availableShippingTypes' => $this->getAvailableShippingTypes(),
            'items' => $items,
            'itemCount' => $this->totalProducts(),
            'totals' => $totals,
            'displayTotals' => $displayTotals
        ];
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