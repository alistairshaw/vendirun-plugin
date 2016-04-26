<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\ProductFactory;
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

        $shippingPrice = ShippingCalculator::shippingForItem($product->shipping, 1, $this->countryId, $this->shippingType);

        $productFactory = new ProductFactory();

        $params = [
            'productVariationId' => $productVariation->id,
            'quantity' => $quantity,
            'taxRate' => $taxRate,
            'product' => $productFactory->fromApi($product),
            'basePrice' => $productVariation->price,
            'shippingPrice' => $shippingPrice,
            'shippingTaxRate' => $taxRate,
            'priceIncludesTax' => $priceIncludesTax
        ];

        return new CartItem($params);
    }

    /**
     * @param bool  $priceIncludesTax
     * @return array
     */
    public function makeFromIds($priceIncludesTax)
    {
        $products = $this->cartRepository->getProducts();

        $final = [];
        foreach ($this->getUniqueList($this->cartRepository->getCart()) as $productVariationId => $quantity)
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