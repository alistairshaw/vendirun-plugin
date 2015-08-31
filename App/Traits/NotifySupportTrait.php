<?php namespace AlistairShaw\Vendirun\App\Traits;

use Cache;
use Config;
use Illuminate\Mail\Message;
use Log;
use Mail;

trait NotifySupportTrait {

    /**
     * Sends an alert to Vendirun Support
     * @param     $notice
     * @param     $key
     * @param int $period Amount of time to wait before sending another message
     * @return bool
     */
    protected function alertSupport($notice, $key, $period = 120)
    {
        Log::error($notice, ['key' => $key]);

        // only ever send one of these alerts every 2 hours at most
        if (Cache::has('apiSupportAlert' . $notice)) return true;

        Mail::send('vendirun::emails.failures.invalid-api-response', ['key' => $key, 'notice' => $notice, 'clientId' => Config::get('vendirun.clientId')], function (Message $message)
        {
            $message->from(Config('vendirun.emailsFrom'), Config('vendirun.emailsFromName'));
            $message->to(Config('vendirun.vendirunSupportEmail'), 'Vendirun Support')->subject('Vendirun API Returning Invalid Response');
        });

        Cache::put('apiSupportAlert' . $notice, true, $period);

        return true;
    }

}