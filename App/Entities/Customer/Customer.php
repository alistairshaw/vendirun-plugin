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
        $this->addresses[] = $address;
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