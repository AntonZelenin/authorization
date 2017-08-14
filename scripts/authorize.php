<?php

define('ROOT', __DIR__."/..");

require_once ROOT.'/autoload.php';

$response = [];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = $_POST['password'];
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $remember = ($_POST['remember'] === 'true') ? true : false;

    $pdo = new DatabasePDO;

    $credetenialsChecker = new CredetenialsChecker($pdo);

    $isBlocked = $credetenialsChecker->isBlocked($email);

    if ($isBlocked) {
        $response['status'] = "blocked";
        $response['payload'] = $isBlocked;

        echo json_encode($response);

        die;
    }

    $isValid = $credetenialsChecker->isEmailPasswordValid($email, $password);

    if ($isValid) {
        $credetenialsChecker->unsetAttemptsCount($email);

        $user = new User;
        $user->id = (new Converter($pdo))->idByEmail($email);

        if ($remember) {
            $userCookie = new UserCookie($user->id);
            $userCookie->createCookie();

            $cookieAssigner = new CookieAssigner($pdo);
            $cookieAssigner->setCookie($userCookie);
            $cookieAssigner->addCookieToDb($userCookie);
        }

        $lastVisit = new LastVisit($pdo);

        $user->lastVisit = $lastVisit->get($user->id);
        $lastVisit->update($user->id);

        $response['status'] = "ok";
        $response['payload'] = $user;

        echo json_encode($response);

        die;
    } else {
        $credetenialsChecker->updateLastAttempt($email);

        $respone['status'] = "denied";

        echo json_encode($response);

        die;
    }
} else {
    $respone['status'] = "denied";

    echo json_encode($response);

    die;
}
