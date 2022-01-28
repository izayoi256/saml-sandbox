<?php

require_once __DIR__ . '/require.php';

if (!isset($_SESSION['samlUserdata'])) {
    header('Location: login.php');
    exit;
}

if (!empty($_SESSION['samlUserdata'])) {
    $attributes = $_SESSION['samlUserdata'];
    echo 'You have the following attributes:<br>';
    echo '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
    foreach ($attributes as $attributeName => $attributeValues) {
        echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
        foreach ($attributeValues as $attributeValue) {
            echo '<li>' . htmlentities($attributeValue) . '</li>';
        }
        echo '</ul></td></tr>';
    }
    echo '</tbody></table>';
} else {
    echo "<p>You don't have any attribute</p>";
}

echo '<p><a href="logout.php" >Logout</a></p>';
