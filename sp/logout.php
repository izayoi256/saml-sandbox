<?php

require_once __DIR__ . '/require.php';

/** @var \OneLogin\Saml2\Auth $auth */
$auth = require __DIR__ . '/auth.php';

$nameId = $_SESSION['samlNameId'] ?? null;
$nameIdFormat = $_SESSION['samlNameIdFormat'] ?? null;
$samlNameIdNameQualifier = $_SESSION['samlNameIdNameQualifier'] ?? null;
$samlNameIdSPNameQualifier = $_SESSION['samlNameIdSPNameQualifier'] ?? null;
$sessionIndex = $_SESSION['samlSessionIndex'] ?? null;

if (isset($_GET['sls'])) {

    if (!isset($_GET['SAMLRequest'])) {
        header('Location: index.php');
        exit;
    }

    if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
        $requestID = $_SESSION['LogoutRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processSLO(false, $requestID);
}

$auth->logout('http://localhost:8400/saml/logout', [], $nameId, $sessionIndex, false, $nameIdFormat, $samlNameIdNameQualifier, $samlNameIdSPNameQualifier);
