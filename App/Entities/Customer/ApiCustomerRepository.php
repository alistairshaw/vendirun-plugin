<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\Vendirun\App\Exceptions\CustomerNotFoundException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use Session;

class ApiCustomerRepository implements CustomerRepository {

    /**
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function find()
    {
        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $apiCustomer = VendirunApi::makeRequest('customer/find', $data)->getData();

            $customerFactory = new CustomerFactory();
            return $customerFactory->fromApi($apiCustomer);
        }
        catch (FailResponseException $e)
        {
            Session::remove('token');
            throw new CustomerNotFoundException('Customer is not logged in');
        }
    }

    /**
     * @param Customer $customer
     * @param bool $is_registration
     * @param null $password
     * @param bool $fetch_duplicate
     * @return Customer
     */
    public function save(Customer $customer, $is_registration = false, $password = null, $fetch_duplicate = false)
    {
        $data = [
            'full_name' => $customer->fullName(),
            'job_role' => $customer->getJobRole(),
            'email' => $customer->getPrimaryEmail(),
            'telephone' => $customer->getPrimaryTelephone()
        ];

        if ($is_registration)
        {
            $data['is_registration'] = true;
            $data['password'] = $password;
        }

        if ($fetch_duplicate) $data['fetch_duplicate'] = true;

        $addresses = [];
        foreach ($customer->getAddresses() as $add)
        {
            /* @var $add Address */
            $addresses[] = $add->getArray();
        }
        $data['addresses'] = $addresses;

        if ($customer->getId()) return $this->update($data, $customer->getId());

        $apiCustomer = VendirunApi::makeRequest('customer/store', $data)->getData();

        $customerFactory = new CustomerFactory();
        $customer = $customerFactory->fromApi($apiCustomer);

        return $customer;
    }

    /**
     * @param Customer $originator
     * @param Customer $receiver
     * @param string $link
     * @return \AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\VendirunResponse
     */
    public function recommendFriend(Customer $originator, Customer $receiver, $link)
    {
        $params = [
            'originator_id' => $originator->getId(),
            'receiver_id' => $receiver->getId(),
            'link' => $link
        ];

        return VendirunApi::makeRequest('customer/recommendFriend', $params);
    }

    /**
     * @param $data
     * @param $id
     * @return Customer
     */
    private function update($data, $id)
    {
        $data['id'] = $id;

        VendirunApi::makeRequest('customer/update', $data)->getData();
        return $this->find();
    }

    /**
     * @param Customer $customer
     * @param array $data
     */
    public function registerFormCompletion(Customer $customer, $data)
    {
        VendirunApi::makeRequest('customer/registerFormCompletion', [
            'customer_id' => $customer->getId(),
            'new_customer' => 1,
            'data' => json_encode($data),
            'form_id' => 'Registration Form'
        ]);
    }
}