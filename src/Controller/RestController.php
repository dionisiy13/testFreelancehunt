<?php

namespace Core\Controller;

use Core\Repository\Countries;
use Core\Repository\Users;
use Core\Service\Database;
use Pecee\Http\Request;
use Pecee\Http\Response;

class RestController
{
    /** @var \PDO */
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function getAllAction()
    {
        $users = (new Users())->getAll();
        $result = [];

        foreach ($users as $user) {
            $result[] = [
                'name' => $user['name'],
                'country' => $user['country'],
                'rating' => $user['rating'],
                'is_active' => $user['is_active'] ? 'Да' : 'Нет',
            ];
        }

        return (new Response(new Request()))->json($result);
    }

    public function getCountriesAction()
    {
        $items = (new Countries())->getAll();
        $result = [];

        foreach ($items as $item) {
            $result[] = [
                'id' => $item['id'],
                'name' => $item['name'],
            ];
        }

        return (new Response(new Request()))->json($result);
    }

    public function getUsersFilteredAction()
    {
        $country = $_GET['country'] ?? false;
        $isActive = $_GET['isActive'] ?? false;

        $users = (new Users())->getBy((int) $country, (int) $isActive);

        foreach ($users as $user) {
            $result[] = [
                'name' => $user['name'],
                'country' => $user['country'],
                'rating' => $user['rating'],
                'is_active' => $user['is_active'] ? 'Да' : 'Нет',
            ];
        }

        return (new Response(new Request()))
            ->json(
                $result ?? []
            );
    }
}
