<?php namespace AlistairShaw\Vendirun\App\Lib;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Request;

class LocaleHelper {

    private static $countryCodes = [
        'en-gb' => 'GB',
        'es-es' => 'ES',
        'fr-fr' => 'FR',
        'de' => 'DE',
        'it' => 'IT',
        'en-us' => 'US',
        'ar-sa' => 'SA',
        'bg' => 'BG',
        'cz' => 'CZ',
        'zh' => 'CN',
        'da' => 'DK',
        'et' => 'EE',
        'fi' => 'FI',
        'hi' => 'IN',
        'hr' => 'HR',
        'hu' => 'HU',
        'is' => 'IS',
        'ja' => 'JP',
        'lv' => 'LV',
        'lt' => 'LT',
        'nl' => 'NL',
        'no' => 'NO',
        'pl' => 'PL',
        'ro' => 'RO',
        'ru' => 'RU',
        'sk' => 'SK',
        'sv' => 'SE'
    ];

    /**
     * @return array
     */
    public static function validLocales()
    {
        return [
            'en-gb',
            'es-es',
            'fr-fr',
            'de',
            'it',
            'en-us',
            'ar-sa',
            'bg',
            'cz',
            'zh',
            'da',
            'et',
            'fi',
            'hi',
            'hr',
            'hu',
            'is',
            'ja',
            'lv',
            'lt',
            'nl',
            'no',
            'pl',
            'ro',
            'ru',
            'sk',
            'sv'
        ];
    }
    
    /**
     * @param $locale
     * @return bool
     */
    public static function getCountryCode($locale)
    {
        if (!in_array($locale, static::validLocales()))
        {
            $clientInfo = Config::get('clientInfo');
            return self::$countryCodes[$clientInfo->primary_language->language_code];
        }

        return self::$countryCodes[$locale];
    }

    /**
     * @param $locale
     * @return string
     */
    public static function getLanguageUrlForCurrentPage($locale)
    {
        if (!in_array($locale, static::validLocales())) return false;

        $url = Request::getRequestUri();
        $urlArray = explode('/', $url);

        $clientInfo = Config::get('clientInfo');
        if (in_array($urlArray[1], static::validLocales()))
        {
            if ($clientInfo->primary_language->language_code == $locale)
            {
                return str_replace($urlArray[1] . '/', '', $url);
            }
            else
            {
                return str_replace($urlArray[1], $locale, $url);
            }
        }
        else
        {
            if ($clientInfo->primary_language->language_code == $locale)
            {
                return $url;
            }
            else
            {
                return '/' . $locale . $url;
            }
        }
    }

    /**
     * Empty string prefix if current locale is the primary
     * @param $locale
     * @return string
     */
    public static function localePrefix($locale = '')
    {
        if (!$locale) $locale = App::getLocale();
        return ($locale == ClientHelper::getClientInfo()->primary_language->language_code) ? '' : $locale . '.';
    }
}