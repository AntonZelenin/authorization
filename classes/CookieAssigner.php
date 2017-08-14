<?php

class CookieAssigner
{

    private  $pdo;

    public function __construct(DatabasePDO $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }

    public function setCookie(UserCookie $userCookie)
    {
        setcookie('user_cookie', $userCookie->getCookie(), $userCookie->getExpiresTimestamp(), '/');
    }

    public function addCookieToDb(UserCookie $cookie)
    {
        $query = $this->pdo->prepare('INSERT INTO user_cookies (user_id, token, expires) VALUES (:user_id, :token, FROM_UNIXTIME(:expires))');
        $query->execute(array('user_id' => $cookie->getUserId(), 'token' => $cookie->getTokenSha256(), 'expires' => $cookie->getExpiresTimestamp()));
    }

    public function removeCookieFromDb(string $cookie)
    {
        $cookieParser = new CookieParser;
        $userId = $cookieParser->getUserId($cookie);
        $token = $cookieParser->getUserToken($cookie);
        $tokenSha256 = hash('sha256', $token);

        $query = $this->pdo->prepare("DELETE FROM user_cookies WHERE user_id=:user_id AND token=:token");
        $query->execute(array('user_id' => $userId, ':token' => $tokenSha256));
    }

}
