<?php
return array(
    'client_id' => 'AT0JRcaC_hvf6lPzB2tPcCyb93owZotMDdOI0BqijNN6r2vq99c6bp7qBCjO-G-DSY5uo2Ua9SyXZG1U',
    'secret' => 'ED2yZDWMi3aMJpNq3Ii6M2SzXtb3ZQ9sp0d1uDIT8Vv9USHgci3cPQeEH8HbtE8imgXfH1-qyIW3X1AM',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 120,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
