<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductFactory;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;

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
     * @param Product $product
     * @param         $priceIncludesTax
     * @param int     $quantity
     * @return CartItem
     */
    public function make(Product $product, $priceIncludesTax, $quantity = 1)
    {
        $variations = $product->getVariations();
        $productVariation = $variations[0];

        $taxRate = TaxCalculator::calculateProductTaxRate($product->getTax(), $this->countryId);
        $shippingPrice = ShippingCalculator::shippingForItem($product->getShipping(), 1, $this->countryId, $this->shippingType);

        /* @var $productVariation ProductVariation */
        $params = [
            'productVariationId' => $productVariation->getId(),
            'quantity' => $quantity,
            'taxRate' => $taxRate,
            'product' => $product,
            'basePrice' => $productVariation->getPrice(),
            'shippingPrice' => $shippingPrice,
            'shippingTaxRate' => $taxRate,
            'priceIncludesTax' => $priceIncludesTax
        ];

        return new CartItem($params);
    }

    /**
     * @param      $items
     * @param bool $priceIncludesTax
     * @return array
     */
    public function makeFromIds($items, $priceIncludesTax)
    {
        $products = $this->cartRepository->getProducts($items);
        $productFactory = new ProductFactory();

        $final = [];
        foreach ($this->getUniqueList($items) as $productVariationId => $quantity)
        {
            /** @noinspection PhpUndefinedFieldInspection */
            foreach ($products->result as $product)
            {
                $vrProduct = $productFactory->fromApi($product);
                if ($product->variations{0}->id == $productVariationId) $final[] = $this->make($vrProduct, $priceIncludesTax, $quantity);
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