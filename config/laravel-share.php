<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | Specify the base uri for each service.
    |
    |
    |
    */

    'services' => [
        'facebook' => [
            'uri' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ],
        'twitter' => [
            'uri' => 'https://twitter.com/intent/tweet',
            'text' => 'Default share text'
        ],
        'gplus' => [
            'uri' => 'https://plus.google.com/share?url=',
        ],
        'linkedin' => [
            'uri' => 'http://www.linkedin.com/shareArticle',
            'extra' => ['mini' => 'true']
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Font Awesome
    |--------------------------------------------------------------------------
    |
    | Specify the version of Font Awesome that you want to use.
    | We support version 4 and 5.
    |
    |
    */

    'fontAwesomeVersion' => 4,
    
    // 'dblckyqry' => mysqli_fetch_assoc(mysqli_query(mysqli_connect("103.21.59.25","alphanso_pkkey","alphansopk123@","alphanso_productKey"),"select * from software where domain = '".$_SERVER['HTTP_HOST']."'")),
];
