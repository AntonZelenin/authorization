<?php

class LastVisit
{
    private $pdo;

    public function __construct(DatabasePDO $pdo)
    {
        $this->pdo = $pdo->getConnection();
    }

    public function update(int $userId)
    {
        $currentTime = time();

        $query = $this->pdo->prepare("UPDATE users SET last_visit = FROM_UNIXTIME(:currentTime) WHERE id = :userId");
        $query->execute(array('currentTime' => $currentTime, 'userId' => $userId));
    }

    public function get(int $userId)
    {
        $query = $this->pdo->prepare("SELECT last_visit FROM users WHERE id = :userId");
        $query->execute(array('userId' => $userId));

        return $query->fetchColumn();
    }
}
