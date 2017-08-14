<?php

class UserCookie
{
    private $userId;
    private $token;
    private $expiresTimestamp;
    private $cookie;

    public function __construct(int $userId)
    {
        $this->userId = $userId;

        $oneDayInSeconds = 60 * 60 * 24;
        $this->expiresTimestamp = time() + $oneDayInSeconds;
    }

    public function createCookie()
    {
        $this->token = $this->generateToken();
        $this->cookie = $this->generateCookie();
    }

    private function generateToken(int $length = 20) : string
    {
        return bin2hex(random_bytes($length));
    }

    private function generateCookie() : string
    {
        return "sel{$this->userId}"."token{$this->token}";
    }

    public function getUserId() : int
    {
        return $this->userId;
    }

    public function getTokenSha256() : string
    {
        return hash('sha256', $this->token);
    }

    public function getCookie() : string
    {
        return $this->cookie;
    }

    public function getExpiresTimestamp() : int
    {
        return $this->expiresTimestamp;
    }

    public function setExpiresIn($period)
    {
        $this->expires = time() + $period;
    }

}
