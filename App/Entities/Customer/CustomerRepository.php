<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

interface CustomerRepository {

    /**
     * @param string $customerToken
     * @return Customer
     */
    public function find($customerToken);

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function save(Customer $customer);

}