<?php

if (isset($_SESSION['samlUserdata'])) {
    echo '<p><a href="mypage.php" >mypage</a></p>';
} else {
    echo '<p><a href="login.php" >login</a></p>';
}

