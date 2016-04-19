<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

use AlistairShaw\NameExploder\NameExploder;

class Name extends \AlistairShaw\NameExploder\Name\Name{

    /**
     * Name constructor.
     * @param string $fullName
     */
    public function __construct($fullName)
    {
        $nameExploder = new NameExploder();
        $name = $nameExploder->explode($fullName);

        parent::__construct($name->firstName(), $name->middleInitial(), $name->lastName(), $name->title());
    }

}