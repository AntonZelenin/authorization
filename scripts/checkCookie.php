<?php

define('ROOT', __DIR__."/..");

require ROOT."/autoload.php";

if (isset($_COOKIE['user_cookie'])) {
    $response = [];

    $pdo = new DatabasePDO;
    $checker = new CookieChecker($pdo);

    $userCookie = $_COOKIE['user_cookie'];

    if ($checker->isValidCookie($userCookie)) {
        $user = new User;
        $user->id = (new CookieParser)->getUserId($userCookie);

        $lastVisit = new LastVisit($pdo);
        $user->lastVisit = $lastVisit->get($user->id);
        $lastVisit->update($user->id);

        $response['status'] = "ok";
        $response['payload'] = $user;

        echo json_encode($response);
        die;
    }
}
