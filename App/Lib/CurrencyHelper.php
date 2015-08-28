<?php namespace AlistairShaw\Vendirun\App\Lib;

use Config;

class CurrencyHelper {

    /**
     * @param int        $amount
     * @param bool|false $noDecimals
     * @return string
     */
    public static function formatWithCurrency($amount, $noDecimals = false)
    {
        $clientInfo = Config::get('clientInfo');
        $currency = $clientInfo->currency;

        if (count($currency) == 0) return number_format($amount / 100, 2);
        $decimals = 0;
        if ($currency->decimals)
        {
            $amount = $amount / 100;
            $decimals = ($noDecimals) ? 0 : 2;
        }

        $final = '';
        if ($currency->position == 'Prepend') $final .= $currency->html;
        $final .= number_format($amount, $decimals);
        if ($currency->position == 'Append') $final .= $currency->html;

        return $final;
    }
}