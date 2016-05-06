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

    /**
     * @param Customer $originator
     * @param Customer $receiver
     * @param string $link
     * @return mixed
     */
    public function recommendFriend(Customer $originator, Customer $receiver, $link);

}