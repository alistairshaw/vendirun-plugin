<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

interface CustomerRepository {

    /**
     * @return Customer
     */
    public function find();

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function save(Customer $customer);

}