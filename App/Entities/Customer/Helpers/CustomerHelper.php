<?php namespace AlistairShaw\Vendirun\App\Entities\Customer\Helpers;

use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Exceptions\CustomerNotFoundException;
use App;
use Config;
use Session;

class CustomerHelper {

    /**
     * @return string|bool
     */
    public static function checkLoggedinCustomer()
    {
        return Session::get('token', false);
    }

    /**
     * @param $customerRepository
     * @return int
     */
    public static function getDefaultCountry(CustomerRepository $customerRepository = null)
    {
        // if country ID is in the GET then obviously, that
        if (isset($_GET['countryId']) && is_numeric($_GET['countryId'])) return (int)$_GET['countryId'];

        if ($customerRepository)
        {
            try
            {
                $customer = $customerRepository->find();

                // get top address
                /* @var $customer Customer */
                $addresses = $customer->getAddresses();
                if (count($addresses) > 0)
                {
                    return $addresses[0]->getCountryId();
                }
            }
            catch (CustomerNotFoundException $e)
            {
                // get company default country
                $clientInfo = Config::get('clientInfo');
                if ($clientInfo->country_id) return $clientInfo->country_id;
            }
        }

        // use UK as super-default if company default not set
        return 79;
    }
}