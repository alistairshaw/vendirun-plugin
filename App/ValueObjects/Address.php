<?php namespace AlistairShaw\Vendirun\App\ValueObjects;

class Address {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $address3;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var int
     */
    private $countryId;

    /**
     * Address constructor.
     * @param        $params
     */
    public function __construct($params)
    {
        foreach ($params as $key => $val)
        {
            if (property_exists($this, $key)) $this->{$key} = $val;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getArray()
    {
        return [
            'id' => $this->id,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'address3' => $this->address3,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'countryId' => $this->countryId,
            'country_id' => $this->countryId, // yes, it's here twice on purpose
        ];
    }

    /**
     * @param Address $address
     * @return bool
     */
    public function isEqualTo(Address $address)
    {
        if ($this->getArray() === $address->getArray()) return true;
        return false;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

}