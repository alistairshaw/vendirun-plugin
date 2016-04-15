<?php namespace AlistairShaw\Vendirun\App\Lib;

use Config;

class CurrencyHelper {

    /**
     * @param int        $amount
     * @param bool|false $noDecimals
     * @param string     $replaceZero
     * @return string
     */
    public static function formatWithCurrency($amount, $noDecimals = false, $replaceZero = 'vendirun::standard.priceOnRequest')
    {
        if ($amount == 0 && $replaceZero !== '') return trans($replaceZero);

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
        if ($currency->position == 'Prepend' || !$currency->position) $final .= $currency->html;
        $final .= number_format($amount, $decimals);
        if ($currency->position == 'Append') $final .= $currency->html;

        return $final;
    }
}