<?php

return [

    /**
     * The endpoint for the Vendirun system
     */
    'apiEndPoint' => env('VENDIRUN_ENDPOINT', ''),

    /**
     * You can get the API key and client ID by logging into your
     * Vendirun and going to Business Setup -> Settings -> API
     */
    'apiKey' => env('VENDIRUN_API_KEY', ''),
    'clientId' => env('VENDIRUN_CLIENT_ID', ''),

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
    'vendirunSupportEmail' => 'support@vendirun.com',

    /**
     * By default, how to sort property search results
     */
    'propertyDefaultSortBy' => 'price',
    'propertyDefaultSortOrder' => 'DESC',

    /**
     * Which listings view to use as a default,
     * there are currently 2 options: type1 and type2
     */
    'propertyListingsView' => 'type1',

    /**
     * Which property information view to use as a default,
     * there are currently 2 options: type1 and type2
     */
    'propertyInfoView' => 'type1',

    /**
     * Can be light or dark
     */
    'socialType' => 'light',

    /**
     * By default, how to sort product search results
     */
    'productDefaultSortBy' => 'price',
    'productDefaultSortOrder' => 'ASC'

];