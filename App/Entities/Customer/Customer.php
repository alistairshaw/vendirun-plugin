<?php namespace AlistairShaw\Vendirun\App\Entities\Customer;

use AlistairShaw\Vendirun\App\ValueObjects\Address;
use AlistairShaw\Vendirun\App\ValueObjects\Name;

class Customer {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $companyName;

    /**
     * @var string
     */
    private $jobRole;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var string
     */
    private $primaryEmail;

    /**
     * @var string
     */
    private $primaryTelephone;

    /**
     * @var string
     */
    private $taxNumber;

    /**
     * @var array
     */
    private $addresses;

    /**
     * Customer constructor.
     * @param null   $id
     * @param Name   $name
     * @param string $primaryEmail
     */
    public function __construct($id = NULL, Name $name = NULL, $primaryEmail = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->primaryEmail = $primaryEmail;
        $this->addresses = [];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getJobRole()
    {
        return $this->jobRole;
    }

    /**
     * @param string $jobRole
     */
    public function setJobRole($jobRole)
    {
        $this->jobRole = $jobRole;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPrimaryEmail()
    {
        return $this->primaryEmail;
    }

    /**
     * @param $email
     */
    public function setPrimaryEmail($email)
    {
        $this->primaryEmail = $email;
    }

    /**
     * @return string
     */
    public function getPrimaryTelephone()
    {
        return $this->primaryTelephone;
    }

    /**
     * @param $telephone
     */
    public function setPrimaryTelephone($telephone)
    {
        $this->primaryTelephone = $telephone;
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return (string)$this->name;
    }

    /**
     * @return string
     */
    public function getTaxNumber()
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     */
    public function setTaxNumber($taxNumber)
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        // if address has an ID, we need to remove the current one and add this new one
        if ($address->getId())
        {
            $final[] = $address;
            foreach ($this->addresses as $currentAddress)
            {
                if (!$address->getId() == $currentAddress->getId()) $final[] = $currentAddress;
            }
            $this->addresses = $final;
        }
        else
        {
            $this->addresses[] = $address;
        }
    }

    /**
     * @param $id
     * @return $this
     */
    public function removeAddress($id)
    {
        $final = [];
        foreach ($this->addresses as $address)
        {
            if ($address->getId() != $id) $final[] = $address;
        }
        $this->addresses = $final;
        return $this;
    }

    /**
     * @return Address
     */
    public function getPrimaryAddress()
    {
        if (count($this->addresses) == 0) return NULL;

        return $this->addresses[0];
    }

    /**
     * @param null $addressId
     * @return Address|mixed
     */
    public function getAddressFromAddressId($addressId = NULL)
    {
        if (count($this->addresses) == 0) return NULL;

        foreach ($this->addresses as $address) if ($address->getId() == $addressId) return $address;

        return $this->getPrimaryAddress();
    }
}