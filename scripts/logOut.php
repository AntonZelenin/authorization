<?php

define('ROOT', __DIR__."/..");

require ROOT."/autoload.php";

if (isset($_COOKIE['user_cookie'])) {
    $cookie = $_COOKIE['user_cookie'];

    $cookieAssigner = new CookieAssigner(new DatabasePDO);
    $cookieAssigner->removeCookieFromDb($cookie);

    setcookie('user_cookie', '', time() - 3600, '/');
}
