<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use Config;

class CartItemFactory {

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * CartItemFactory constructor.
     * @param CartRepository $cartRepository
     * @param null           $countryId
     * @param string         $shippingType
     */
    public function __construct(CartRepository $cartRepository, $countryId = NULL, $shippingType = '')
    {
        $this->cartRepository = $cartRepository;
        $this->countryId = $countryId;
        $this->shippingType = $shippingType;
    }

    /**
     * @param     $product
     * @param     $priceIncludesTax
     * @param int $quantity
     * @return CartItem
     */
    public function make($product, $priceIncludesTax, $quantity = 1)
    {
        $productVariation = $product->variations{0};

        $taxRate = TaxCalculator::calculateProductTaxRate($product->tax, $this->countryId);
        $itemTax = TaxCalculator::calculateItemTax($product->tax, $this->countryId, $productVariation->price, $quantity);
        $basePrice = $productVariation->price * $quantity;
        if ($priceIncludesTax) $basePrice -= $itemTax;

        $shippingPrice = ShippingCalculator::shippingForItem($product->shipping, $quantity, $this->countryId, $this->shippingType);
        $shippingTax = $priceIncludesTax ? TaxCalculator::taxFromTotal($shippingPrice, $taxRate, 1) : TaxCalculator::totalPlusTax($shippingPrice, $taxRate, 1);
        if ($priceIncludesTax) $shippingPrice -= $shippingTax;

        $params = [
            'productVariationId' => $productVariation->id,
            'quantity' => $quantity,
            'taxRate' => $taxRate,
            'productVariation' => $productVariation,
            'product' => $product,
            'basePrice' => $basePrice,
            'itemTax' => $itemTax,
            'shippingPrice' => $shippingPrice,
            'shippingTax' => $shippingTax,
            'priceIncludesTax' => $priceIncludesTax
        ];

        return new CartItem($params);
    }

    /**
     * @param array $productVariationIds
     * @param bool  $priceIncludesTax
     * @return array
     */
    public function makeFromIds($productVariationIds, $priceIncludesTax)
    {
        $products = $this->cartRepository->getProducts($productVariationIds);

        $final = [];
        foreach ($this->getUniqueList($productVariationIds) as $productVariationId => $quantity)
        {
            foreach ($products->result as $product)
            {
                if ($product->variations{0}->id == $productVariationId) $final[] = $this->make($product, $priceIncludesTax, $quantity);
            }
        }

        return $final;
    }

    /**
     * @param $productVariationIds
     * @return array
     */
    private function getUniqueList($productVariationIds)
    {
        $final = [];
        foreach ($productVariationIds as $item)
        {
            if (!isset($final[$item])) $final[$item] = 0;
            $final[$item]++;
        }

        return $final;
    }

}