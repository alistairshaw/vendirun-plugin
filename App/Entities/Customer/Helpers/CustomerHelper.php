<?php namespace AlistairShaw\Vendirun\App\Entities\Customer\Helpers;

use App;
use Config;
use Request;
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
     * @return int
     */
    public static function getDefaultCountry()
    {
        // if country ID is in the GET then obviously, that
        if (Request::has('countryId')) return Request::get('countryId');

        $customerRepository = App::make('AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository');
        if ($customer = $customerRepository->find())
        {
            // get top address
            $addresses = $customer->getAddresses();
            if (count($addresses) > 0)
            {
                /* @var $addresses[0] Address */
                return $addresses[0]->getCountryId();
            }
        }

        // get company default country
        $clientInfo = Config::get('clientInfo');
        if ($clientInfo->country_id) return $clientInfo->country_id;

        // use UK as super-default if company default not set
        return 79;
    }
}