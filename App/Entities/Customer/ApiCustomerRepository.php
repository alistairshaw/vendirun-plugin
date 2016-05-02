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
            $customer = $customerFactory->make($apiCustomer->id, $apiCustomer->fullname, $apiCustomer->primary_email);
            $customer->setCompanyName($apiCustomer->organisation_name);
            $customer->setJobRole($apiCustomer->jobrole);

            foreach ($apiCustomer->addresses as $address)
            {
                $customer->addAddress(new Address([
                    'id' => $address->id,
                    'address1' => $address->address1,
                    'address2' => $address->address2,
                    'address3' => $address->address3,
                    'city' => $address->city,
                    'state' => $address->state,
                    'postcode' => $address->postcode,
                    'countryId' => $address->country_id
                ]));
            }

            return $customer;
        }
        catch (FailResponseException $e)
        {
            Session::remove('token');
            throw new CustomerNotFoundException('Customer is not logged in');
        }
    }

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function save(Customer $customer)
    {
        $data = [
            'full_name' => $customer->fullName(),
            'job_role' => $customer->getJobRole(),
            'email' => $customer->getPrimaryEmail()
        ];

        if ($customer->getId()) return $this->update($data, $customer->getId());

        $savedCustomer = VendirunApi::makeRequest('customer/store', $data)->getData();
        $customer->setId($savedCustomer->id);
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
}