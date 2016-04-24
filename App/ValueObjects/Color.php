<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

class Color {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $hex;

    /**
     * Color constructor.
     * @param $name
     * @param $hex
     */
    public function __construct($name, $hex)
    {
        $this->name = $name;
        $this->hex = $hex;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->hex;
    }

}