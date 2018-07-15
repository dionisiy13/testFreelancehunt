<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 13.07.2018
 * Time: 15:03.
 */

namespace Core\Service;

use Core\Repository\Countries;
use Core\Repository\Users;
use Core\Repository\UsersCheckIn;

class ImportCSV
{
    private $file;
    private $resultArray;
    /** @var Geo */
    private $geo;

    public function __construct()
    {
        $this->geo = new Geo();
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function parseFile(): void
    {
        $csv = array_map('str_getcsv', file($this->file));

        $this->resultArray = $csv;
    }

    public function writeToDb(): void
    {
        echo "Start\n";
        $userRepository = new Users();
        $checkInRepository = new UsersCheckIn();
        $array = array_slice($this->resultArray, 1);

        echo 'Total amount for importing - '.sizeof($array)."\n";
        echo "Loading...\n";
        foreach ($array as $item) {
            try {
                [$name, $date, $ip, $rating, $country, $isActive] = $item;

                if (!($userId = $userRepository->findUserByName($name))) {
                    $userId = $userRepository->add(
                        $name,
                        (new Countries())->getCountryIdByName($country),
                        $rating,
                        'Да' == $isActive ? 1 : 0
                    );
                }

                $checkIn = $checkInRepository->add(
                    $userId,
                    $ip,
                    (new Countries())->getCountryIdByCode($this->geo->getCountryCodeByIp($ip)),
                    $date
                );

                echo '.';
            } catch (\Throwable $t) {
                continue;
            }
        }
        echo 'Done!';
    }
}
