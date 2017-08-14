<?php

class Converter
{
    private $pdo;

    public function __construct(DatabasePDO $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }

    public function idByEmail(string $email) : int
    {
        $query = $this->pdo->prepare("SELECT id FROM users WHERE email=:email");
        $query->execute(array('email' => $email));

        return $query->fetchColumn();
    }
}
