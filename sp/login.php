<?php

require_once __DIR__ . '/require.php';

/** @var \OneLogin\Saml2\Auth $auth */
$auth = require __DIR__ . '/auth.php';

if (isset($_GET['acs'])) {

    if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
        $requestID = $_SESSION['AuthNRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processResponse($requestID);

    $errors = $auth->getErrors();

    if (!empty($errors)) {
        echo '<p>',implode(', ', $errors),'</p>';
        if ($auth->getSettings()->isDebugActive()) {
            echo '<p>'.htmlentities($auth->getLastErrorReason()).'</p>';
        }
    }

    if (!$auth->isAuthenticated()) {
        echo "<p>Not authenticated</p>";
        exit();
    }

    $_SESSION['samlUserdata'] = $auth->getAttributes();
    $_SESSION['samlNameId'] = $auth->getNameId();
    $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
    $_SESSION['samlNameIdNameQualifier'] = $auth->getNameIdNameQualifier();
    $_SESSION['samlNameIdSPNameQualifier'] = $auth->getNameIdSPNameQualifier();
    $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
    unset($_SESSION['AuthNRequestID']);
    if (isset($_POST['RelayState']) && 'http://localhost:8500/login.php' != $_POST['RelayState']) {
        // To avoid 'Open Redirect' attacks, before execute the
        // redirection confirm the value of $_POST['RelayState'] is a // trusted URL.
        $auth->redirectTo($_POST['RelayState']);
    }
}

if (isset($_SESSION['samlUserdata'])) {
    header('Location: mypage.php');
    exit;
}

$auth->login();
