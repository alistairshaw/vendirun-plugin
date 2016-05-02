<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\NameExploder\NameExploder;
use AlistairShaw\Vendirun\App\ValueObjects\Name;

class CustomerFactory {

    /**
     * @param null   $id
     * @param string $fullName
     * @param string $primaryEmail
     * @return Customer
     */
    public function make($id = null, $fullName = '', $primaryEmail = '')
    {
        $name = Name::fromFullName($fullName);
        return new Customer($id, $name, $primaryEmail);
    }

}