<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\NameExploder\NameExploder;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
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

    /**
     * @param $form
     * @return Customer
     */
    public function fromRegistration($form)
    {
        $name = isset($form['full_name']) ? Name::fromFullName($form['full_name']) : null;
        $customer = new Customer(null, $name, $form['email']);

        if (isset($form['telephone']) && $form['telephone']) $customer->setPrimaryTelephone($form['telephone']);

        return $customer;
    }

    /**
     * @param $apiCustomer
     * @return Customer
     */
    public function fromApi($apiCustomer)
    {
        $customer = $this->make($apiCustomer->id, $apiCustomer->fullname, $apiCustomer->primary_email);
        if ($apiCustomer->organisation) $customer->setCompanyName($apiCustomer->organisation);
        if ($apiCustomer->job_role) $customer->setJobRole($apiCustomer->job_role);

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
}