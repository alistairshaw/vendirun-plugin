<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Name;
use Session;

class ApiCustomerRepository implements CustomerRepository {

    /**
     * @param string $customerToken
     * @return Customer
     */
    public function find($customerToken)
    {
        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $apiCustomer = VendirunApi::makeRequest('customer/find', $data)->getData();
            
            $name = new Name($apiCustomer->title, $apiCustomer->first_name, '', $apiCustomer->last_name);
            $customer = new Customer($apiCustomer->id, $name, $apiCustomer->primary_email);
            $customer->setCompanyName($apiCustomer->organisation_name);
            $customer->setJobRole($apiCustomer->job_role);
            return $customer;
        }
        catch (FailResponseException $e)
        {
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