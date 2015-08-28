<?php

return [

    /**
     * The endpoint for the Vendirun system
     */
	'apiEndPoint' => env('VENDIRUN_ENDPOINT', 'http://app.vendirun.local/api/v1/'),

    /**
     * You can get the API key and client ID by logging into your
     * Vendirun and going to Business Setup -> Settings -> API
     */
	'apiKey' => env('VENDIRUN_API_KEY', 'RSDQ0cDTJDJlStMc'),
    'clientId' => env('VENDIRUN_CLIENT_ID', '3'),

    /**
     * The from address that all emails are from. You set the
     * SMTP details in the environment variables for the site
     */
    'emailsFrom' => 'support@vendirun.com',
    'emailsFromName' => 'Vendirun Website',

    /**
     * This email address is used when we are unable to communicate
     * with Vendirun, to send form submission details and other
     * collected data to the owner
     */
    'backupEmail' => 'alistairshaw@gmail.com',

    /**
     * Vendirun Support email address - used when something breaks to
     * email the support team and/or copy them on error messages where
     * appropriate - You don't need to change this unless you no longer
     * wish for us to receive these notifications
     */
    'vendirunSupportEmail' => 'support@vendirun.com'

];