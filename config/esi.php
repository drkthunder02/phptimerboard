<?php

    return [
        'client_id' => env('EVEONLINE_CLIENT_ID'),
        'secret' => env('EVEONLINE_CLIENT_SECRET'),
        'callback' => env('EVEONLINE_REDIRECT'),
        'useragent' => env('EVEONLINE_USER_AGENT'),
        'primary' => env('EVEONLINE_PRIMARY_CHAR'),
    ];

?>