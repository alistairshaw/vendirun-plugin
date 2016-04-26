<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductVariation;

use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\ValueObjects\Color;
use AlistairShaw\Vendirun\App\ValueObjects\Size;
use AlistairShaw\Vendirun\App\ValueObjects\Type;

class ProductVariation {

    /**
     * @var string
     */
    private $id;

    /**
     * @var Color
     */
    private $color;

    /**
     * @var Size
     */
    private $size;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var int
     */
    private $stockLevel;

    /**
     * @param $params | required: id, name, price, sku
     * @throws \Exception
     */
    public function __construct($params)
    {
        if (!isset($params['id']) || !isset($params['name']) || !isset($params['price']) || !isset($params['sku']))
            throw new \Exception('Unable to create Entity, missing parameters');

        $this->id = $params['id'];
        $this->name = $params['name'];
        $this->price = (int)$params['price'];
        $this->sku = $params['sku'];

        $this->stockLevel = (isset($params['stockLevel'])) ? $params['stockLevel'] : 99999;
        if (isset($params['color']) && $params['color'] instanceof Color) $this->color = $params['color'];
        if (isset($params['size']) && $params['size'] instanceof Size) $this->size = $params['size'];
        if (isset($params['type']) && $params['type'] instanceof Type) $this->type = $params['type'];
    }

    /**
     * @return array
     */
    public function display()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => CurrencyHelper::formatWithCurrency($this->price),
            'sku' => $this->sku,
            'stockLevel' => $this->stockLevel,
            'color' => $this->color ? $this->color->getName() : '',
            'colorHex' => $this->color ? $this->color->getHex() : '',
            'size' => $this->size ? $this->size->getName() : '',
            'type' => $this->type ? $this->type->getName() : ''
        ];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

}