<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

class Size {

    /**
     * @var string
     */
    private $name;


    /**
     * Color constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
    public function __toString()
    {
        return $this->name;
    }

}