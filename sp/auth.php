<?php

$appUrl = $_ENV['APP_URL'];
$idpAppUrl = $_ENV['IDP_APP_URL'];

$spCertPath = __DIR__ . "/../.certs/cert.pem";
$spKeyPath = __DIR__ . "/../.certs/key.pem";
$idpCertPath = __DIR__ . '/../.certs/idp.cert.pem';

return new \OneLogin\Saml2\Auth([
    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them to be signed or encrypted.
    // Also it will reject the messages if the SAML standard is not strictly
    // followed: Destination, NameId, Conditions ... are validated too.
    'strict' => true,

    // Enable debug mode (to print errors).
    'debug' => true,

    // Set a BaseURL to be used instead of try to guess
    // the BaseURL of the view that process the SAML Message.
    // Ex http://sp.example.com/
    //    http://example.com/sp/
    'baseurl' => null,

    // Service Provider Data that we are deploying.
    'sp' => [
        // Identifier of the SP entity  (must be a URI)
        'entityId' => $appUrl,
        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => [
            // URL Location where the <Response> from the IdP will be returned
            'url' => "{$appUrl}login.php?acs",
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports this endpoint for the
            // HTTP-POST binding only.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
        // If you need to specify requested attributes, set a
        // attributeConsumingService. nameFormat, attributeValue and
        // friendlyName can be omitted
        "attributeConsumingService"=> [
            "serviceName" => "SP test",
            "serviceDescription" => "Test Service",
            "requestedAttributes" => [
                [
                    "name" => "",
                    "isRequired" => false,
                    "nameFormat" => "",
                    "friendlyName" => "",
                    "attributeValue" => []
                ]
            ]
        ],
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => [
            // URL Location where the <Response> from the IdP will be returned
            'url' => "{$appUrl}/logout.php?acs",
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        // Specifies the constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported.
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => file_exists($spCertPath) && is_readable($spCertPath)
            ? file_get_contents($spCertPath)
            : null,
        'privateKey' => file_exists($spKeyPath) && is_readable($spKeyPath)
            ? file_get_contents($spKeyPath)
            : null,

        /*
         * Key rollover
         * If you plan to update the SP x509cert and privateKey
         * you can define here the new x509cert and it will be
         * published on the SP metadata so Identity Providers can
         * read them and get ready for rollover.
         */
        // 'x509certNew' => '',
    ],

    // Identity Provider Data that we want connected with our SP.
    'idp' => [
        // Identifier of the IdP entity  (must be a URI)
        'entityId' => "{$idpAppUrl}saml/metadata",
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => [
            // URL Target of the IdP where the Authentication Request Message
            // will be sent.
            'url' => "{$idpAppUrl}login",
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        // SLO endpoint info of the IdP.
        'singleLogoutService' => [
            // URL Location of the IdP where SLO Request will be sent.
            'url' => "{$idpAppUrl}saml/logout",
            // URL location of the IdP where the SP will send the SLO Response (ResponseLocation)
            // if not set, url for the SLO Request will be used
            'responseUrl' => "{$idpAppUrl}saml/logout",
            // SAML protocol binding to be used when returning the <Response>
            // message. OneLogin Toolkit supports the HTTP-Redirect binding
            // only for this endpoint.
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        // Public x509 certificate of the IdP
        'x509cert' => file_exists($idpCertPath) && is_readable($idpCertPath)
            ? file_get_contents($idpCertPath)
            : null,
    ],
]);

