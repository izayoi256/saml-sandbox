<?php

$key = file_get_contents(__DIR__ . '/../storage/samlidp/cert.pem');

$pattern = '/^-----BEGIN CERTIFICATE-----([^-]*)^-----END CERTIFICATE-----/m';
$result = preg_match($pattern, $key, $matches);
echo $result
    ? 'success'
    : 'failure';
sleep(0);
