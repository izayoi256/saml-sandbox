<?php

require __DIR__ . '/header.php';

if (isset($_SESSION['samlUserdata'])) {
    echo '<p><a href="mypage.php" >マイページ</a></p>';
} else {
    echo '<p><a href="login.php" >ログイン</a></p>';
}

