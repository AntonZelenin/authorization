<?php

class CookieChecker
{
    private $pdo;

    public function __construct(DatabasePDO $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }

    public function isValidCookie(string $userCookie) : bool
    {
        $cookieParser = new CookieParser;
        $userId = $cookieParser->getUserId($userCookie);
        $userToken = $cookieParser->getUserToken($userCookie);

        $userTokenSha256 = hash('sha256', $userToken);

        $databaseTokensSha256 = $this->getTokensSha256FromDb($userId);

        return $this->tokenExists($userTokenSha256, $databaseTokensSha256);
    }

    private function getTokensSha256FromDb(int $userId)
    {
        $query = $this->pdo->prepare("SELECT token FROM user_cookies WHERE user_id=:user_id");
        $query->execute(array('user_id' => $userId));

        return $query->fetchAll();
    }

    private function tokenExists($userTokenSha256, $databaseTokensSha256) : bool
    {
        foreach ($databaseTokensSha256 as $key => $tokenSha256) {
            if (hash_equals($tokenSha256['token'], $userTokenSha256)) {
                return true;
            }
        }

        return false;
    }

}
