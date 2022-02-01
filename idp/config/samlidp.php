<?php

$sp1KeyPath = storage_path('samlidp/sp1.cert.pem');
$sp2KeyPath = storage_path('samlidp/sp2.cert.pem');

return [

    /*
    |--------------------------------------------------------------------------
    | SAML idP configuration file
    |--------------------------------------------------------------------------
    |
    | Use this file to configure the service providers you want to use.
    |
     */
    // Outputs data to your laravel.log file for debugging
    'debug' => false,
    // Define the email address field name in the users table
    'email_field' => 'email',
    // The URI to your login page
    'login_uri' => 'login',
    // Log out of the IdP after SLO
    'logout_after_slo' => env('LOGOUT_AFTER_SLO', false),
    // The URI to the saml metadata file, this describes your idP
    'issuer_uri' => 'saml/metadata',
    // Name of the certificate PEM file
    'certname' => 'cert.pem',
    // Name of the certificate key PEM file
    'keyname' => 'key.pem',
    // Encrypt requests and responses
    'encrypt_assertion' => true,
    // Make sure messages are signed
    'messages_signed' => true,
    // Defind what digital algorithm you want to use
    'digest_algorithm' => \RobRichards\XMLSecLibs\XMLSecurityDSig::SHA1,
    // list of all service providers
    'sp' => [
        base64_encode(env('SP1_LOGIN')) => [
            'destination' => env('SP1_LOGIN'),
            'logout' => env('SP1_LOGOUT'),
            'certificate' => file_exists($sp1KeyPath) && is_readable($sp1KeyPath)
                ? file_get_contents($sp1KeyPath)
                : null,
            'query_params' => [
                'sls' => '',
            ],
        ],
        base64_encode(env('SP2_LOGIN')) => [
            'destination' => env('SP2_LOGIN'),
            'logout' => env('SP2_LOGOUT'),
            'certificate' => file_exists($sp2KeyPath) && is_readable($sp2KeyPath)
                ? file_get_contents($sp2KeyPath)
                : null,
            'query_params' => [
                'sls' => '',
            ],
        ],
        // Base64 encoded ACS URL
        // 'aHR0cHM6Ly9teWZhY2Vib29rd29ya3BsYWNlLmZhY2Vib29rLmNvbS93b3JrL3NhbWwucGhw' => [
        //     // Your destination is the ACS URL of the Service Provider
        //     'destination' => 'https://myfacebookworkplace.facebook.com/work/saml.php',
        //     'logout' => 'https://myfacebookworkplace.facebook.com/work/sls.php',
        //     'certificate' => '',
        //     'query_params' => false
        // ]
    ],

    // If you need to redirect after SLO depending on SLO initiator
    // key is beginning of HTTP_REFERER value from SERVER, value is redirect path
    'sp_slo_redirects' => [
        env('SP1_HTTP_REFERER') => env('SP1_APP_URL'),
        env('SP2_HTTP_REFERER') => env('SP2_APP_URL'),
        // 'https://example.com' => 'https://example.com',
    ],

    // All of the Laravel SAML IdP event / listener mappings.
    'events' => [
        'CodeGreenCreative\SamlIdp\Events\Assertion' => [
            \App\Listeners\SamlAssertionAttributes::class,
        ],
        'Illuminate\Auth\Events\Logout' => [
            'CodeGreenCreative\SamlIdp\Listeners\SamlLogout',
        ],
        'Illuminate\Auth\Events\Authenticated' => [
            'CodeGreenCreative\SamlIdp\Listeners\SamlAuthenticated',
        ],
        'Illuminate\Auth\Events\Login' => [
            'CodeGreenCreative\SamlIdp\Listeners\SamlLogin',
        ],
    ],

    // List of guards saml idp will catch Authenticated, Login and Logout events
    'guards' => ['web']
];
