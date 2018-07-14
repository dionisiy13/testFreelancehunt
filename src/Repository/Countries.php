<?php

namespace Core\Repository;

use Core\Service\Database;
use PHPUnit\Runner\Exception;

class Countries {

    /** @var  \PDO */
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function getCountryNameByCode(string $code): string
    {
        $sql = "SELECT name FROM countries WHERE code = :code LIMIT 1";

        $query = $this->db->prepare($sql);
        $query->execute(['code'=>$code]);

        $name = $query->fetch();
        $name = is_array($name) ? current($name) : false;

        if (!$name) {
            throw new \Exception("Country do not exist");
        }
        return $name;
    }

    public function getCountryCodeByName(string $name): string
    {
        $sql = "SELECT code FROM countries WHERE name = :name LIMIT 1";

        $query = $this->db->prepare($sql);
        $query->execute(['name'=>$name]);

        $code = $query->fetch();
        $code = is_array($code) ? current($code) : false;

        if (!$code) {
            throw new \Exception("Country do not exist");
        }
        return $code;
    }

    public function getCountryIdByName(string $name): int
    {
        $sql = "SELECT id FROM countries WHERE name = :name LIMIT 1";

        $query = $this->db->prepare($sql);
        $query->execute(['name'=>$name]);

        $id = $query->fetch();
        $id = is_array($id) ? current($id) : false;

        if (!$id) {
            throw new \Exception("Country do not exist");
        }
        return $id;
    }

    public function getCountryIdByCode(string $code): int
    {
        $sql = "SELECT id FROM countries WHERE code = :code LIMIT 1";

        $query = $this->db->prepare($sql);
        $query->execute(['code'=>$code]);

        $id = $query->fetch();
        $id = is_array($id) ? current($id) : false;

        if (!$id) {
            throw new \Exception("Country do not exist");
        }
        return $id;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM countries";

        $query = $this->db->prepare($sql);
        $query->execute();

        return  $query->fetchAll();
    }



}