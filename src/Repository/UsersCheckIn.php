<?php

namespace Core\Repository;

use Core\Service\Database;

class UsersCheckIn {

    /** @var  \PDO */
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function add(int $userId, string $ip, int $country, string  $date): int
    {
        $usersCheckInSQL = 'INSERT INTO users_check_in (user, ip, country, date) VALUES (:user, :ip, :country, :date)';

        $query = $this->db->prepare($usersCheckInSQL);
        $query->execute([
            ':user' =>$userId,
            ':ip' => $ip,
            ':country' => $country,
            ':date' => $date,
        ]);

        return $this->db->lastInsertId();
    }


}