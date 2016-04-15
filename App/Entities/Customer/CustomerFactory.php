<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\NameExploder\NameExploder;
use AlistairShaw\Vendirun\App\ValueObjects\Name;

class CustomerFactory {

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerFactory constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param null   $id
     * @param string $fullName
     * @param string $primaryEmail
     * @return Customer
     */
    public function make($id = null, $fullName = '', $primaryEmail = '')
    {
        $name = new Name($fullName);
        return new Customer($id, $name, $primaryEmail);
    }

}