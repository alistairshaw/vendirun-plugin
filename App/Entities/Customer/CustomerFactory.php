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

    /**
     * @param $data
     * @return Customer
     */
    public function makeFromCheckoutForm($data)
    {
        $name = new Name($data['fullName']);
        $email = $data['emailAddress'];
        if ($customer = $this->customerRepository->find())
        {
            $customer->setName($name);
            $customer->setPrimaryEmail($email);
            $this->customerRepository->save($customer);
            return $customer;
        }
        else
        {
            return $this->make(NULL, $data['fullName'], $data['emailAddress']);
        }
    }

}