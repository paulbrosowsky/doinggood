<?php
return [

    'administrators' => explode(";", env('DGC_ADMINS')),

    'wp_api' =>[
        'url' => env('WP_API_URL'),
        'token' => env('WP_API_TOKEN')
    ] ,
    
];