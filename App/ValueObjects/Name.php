<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

use AlistairShaw\NameExploder\NameExploder;

class Name {

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $middleInitial;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param string $title
     * @param string $firstName
     * @param string $middleInitial
     * @param string $lastName
     */
    private function __construct($title = '', $firstName = '', $middleInitial = '', $lastName = '')
    {
        $this->title = $title;
        $this->firstName = $firstName;
        $this->middleInitial = $middleInitial;
        $this->lastName = $lastName;
    }

    /**
     * @param $fullName
     * @return Name
     */
    public static function fromFullName($fullName)
    {
        $nameExploder = new NameExploder();
        $name = $nameExploder->explode($fullName);

        return new self($name->title(), $name->firstName(), $name->middleInitial(), $name->lastName());
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        $nameArray = [];
        if ($this->title) $nameArray[] = $this->title;
        if ($this->firstName) $nameArray[] = $this->firstName;
        if ($this->middleInitial) $nameArray[] = $this->middleInitial;
        if ($this->lastName) $nameArray[] = $this->lastName;

        return implode(" ", $nameArray);
    }

}