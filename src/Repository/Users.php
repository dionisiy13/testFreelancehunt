<?php

namespace Core\Repository;

use Core\Service\Database;

class Users {

    /** @var  \PDO */
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function add(string $name, int $homeCountry, int $rating = 0, int $isActive = 0): int
    {
        $usersSQL = "INSERT INTO users (name, home_country, rating, is_active) VALUES (:name_val, :home_country, :rating, :is_active)";
        $query = $this->db->prepare($usersSQL);

        $query->execute([
            ':name_val' => $name,
            ':home_country' => $homeCountry,
            ':rating' => $rating,
            ':is_active' =>  $isActive,
        ]);

        return $this->db->lastInsertId();
    }

    public function findUserByName(string $name): ?int
    {
        $sql = "SELECT id FROM users WHERE name = :name LIMIT 1";

        $query = $this->db->prepare($sql);
        $query->execute(['name'=>$name]);

        $id = $query->fetch();
        $id = is_array($id) ? current($id) : null;

        return $id;
    }

    public function getAll(): array
    {
        $sql = "SELECT u.*, c.name as country FROM users_check_in as uci JOIN users as u ON u.id = uci.user JOIN countries as c ON c.id = uci.country";

        $sql .= " GROUP BY uci.id";
        $query = $this->db->prepare($sql);
        $query->execute();

        return  $query->fetchAll();
    }


    public function getBy(int $country, int $isActive): array
    {
        $where = "";
        $params = [];
        if ($country) {
            $where .= "uci.country = :country";
            $params[':country'] = $country;
        }
        if ($isActive) {
            if (!empty($where)) {
                $where .= " AND ";
            }
            $where .= "u.is_active = :is_active";
            $params[':is_active'] = $isActive - 1;
        }

        $sql = "SELECT u.*, c.name as country FROM users_check_in as uci JOIN users as u ON u.id = uci.user JOIN countries as c ON c.id = uci.country WHERE ";
        $sql .= $where." GROUP BY uci.id";

        $query = $this->db->prepare($sql);
        $query->execute($params);

        return  $query->fetchAll();


    }


}