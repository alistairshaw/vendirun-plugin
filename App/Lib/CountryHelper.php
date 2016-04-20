<?php namespace AlistairShaw\Vendirun\App\Lib;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class CountryHelper {

    /**
     * @return object
     */
    public static function getRegions()
    {
        return VendirunApi::makeRequest('util/countries')->getData();
    }

    /**
     * @param $countryId
     * @return string
     */
    public static function getCountryCode($countryId)
    {
        foreach (static::getRegions() as $region)
        {
            foreach ($region->countries as $country)
            {
                if ($country->id == $countryId) return $country->country_code;
            }
        }

        return '';
    }
    
}