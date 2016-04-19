<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use AlistairShaw\Vendirun\App\ValueObjects\Name;
use Session;

class ApiCustomerRepository implements CustomerRepository {

    /**
     * @return Customer
     */
    public function find()
    {
        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $apiCustomer = VendirunApi::makeRequest('customer/find', $data)->getData();

            $customerFactory = new CustomerFactory($this);
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
            return false;
        }
    }

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function save(Customer $customer)
    {
        $data = [
            'id' => $customer->getId(),
            'full_name' => $customer->fullName(),
            'job_role' => $customer->getJobRole(),
            'email' => $customer->getPrimaryEmail(),
            'over_write' => true
        ];

        try
        {
            $savedCustomer = VendirunApi::makeRequest('customer/store', $data)->getData();
            $customer->setId($savedCustomer->id);
            return $customer;
        }
        catch (FailResponseException $e)
        {
            return false;
        }
    }

}