<?php namespace AlistairShaw\Vendirun\App\Lib;

use Config;

class UnitHelper {

    /**
     * @param int        $amount
     * @return string
     */
    public static function formatArea($amount)
    {
        $clientInfo = Config::get('clientInfo');
        $area_unit = $clientInfo->area_unit;

        return number_format($amount) . $area_unit->html;
    }

    /**
     * @param int        $amount
     * @return string
     */
    public static function formatDistance($amount)
    {
        $clientInfo = Config::get('clientInfo');
        $distance_unit = $clientInfo->distance_unit;

        return number_format($amount) . $distance_unit->html;
    }

    /**
     * @param int        $amount
     * @return string
     */
    public static function formatWeight($amount)
    {
        $clientInfo = Config::get('clientInfo');
        $weight_unit = $clientInfo->weight_unit;

        return number_format($amount) . $weight_unit->html;
    }
}