<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductFactory;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;

class CartItemFactory
{

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
     * @param Cart $cart
     * @internal param null $countryId
     * @internal param string $shippingType
     */
    public function __construct(CartRepository $cartRepository, Cart $cart = null)
    {
        $this->cartRepository = $cartRepository;
        if ($cart)
        {
            $this->updateShippingAndTax($cart);
        }
    }

    /**
     * @param Product $product
     * @param bool $priceIncludesTax
     * @param int $quantity
     * @return CartItem
     */
    public function make(Product $product, $priceIncludesTax, $quantity = 1)
    {
        $variations = $product->getVariations();
        $productVariation = $variations[0];

        /* @var $productVariation ProductVariation */
        $params = [
            'productVariationId' => $productVariation->getId(),
            'quantity' => $quantity,
            'product' => $product,
            'basePrice' => $productVariation->getPrice(),
            'priceIncludesTax' => $priceIncludesTax,
            'shippingType' => $this->shippingType,
            'countryId' => $this->countryId
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
     * @param Cart $cart
     */
    public function updateShippingAndTax(Cart $cart)
    {
        $this->countryId = $cart->getCountryId();
        $this->shippingType = $cart->getShippingType();
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