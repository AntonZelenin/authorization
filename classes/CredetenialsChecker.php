<?php

class CredetenialsChecker
{

    private $pdo;
    private $blockTime = 180;

    public function __construct(DatabasePDO $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }

    public function isBlocked(string $email)
    {
        $query = $this->pdo->prepare("SELECT UNIX_TIMESTAMP(last_attempt) AS last_attempt, attempts_count FROM users WHERE email=:email");
        $query->execute(array('email' => $email));

        $result = $query->fetch();
        $currentTime = time();

        if (($result['attempts_count'] >= 2) && ($currentTime - $result['last_attempt'] <= 180)) {
            return $this->blockTime - ($currentTime - $result['last_attempt']);
        } elseif ($currentTime - $result['last_attempt'] > 180) {
            return false;
        }
    }

    public function updateLastAttempt(string $email)
    {
        $currentTime = time();

        $query = $this->pdo->prepare("UPDATE users SET attempts_count = attempts_count + 1, last_attempt = FROM_UNIXTIME(:currentTime) WHERE email=:email");
        $query->execute(array('currentTime' => $currentTime, 'email' => $email));
    }

    public function unsetAttemptsCount(string $email)
    {
        $query = $this->pdo->prepare("UPDATE users SET attempts_count = 0 WHERE email=:email");
        $query->execute(array('email' => $email));
    }

    public function getPasswordHashFromDb($email)
    {
        $query = $this->pdo->prepare("SELECT password FROM users WHERE email=:email");
        $query->execute(array('email' => $email));

        return $query->fetchColumn();
    }

    public function isEmailPasswordValid(string $email, string $password) : bool
    {
        $passwordHash = $this->getPasswordHashFromDb($email);

        return password_verify($password, $passwordHash);
    }

}
