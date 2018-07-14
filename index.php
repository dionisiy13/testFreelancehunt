<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/local.config.php';

use Pecee\SimpleRouter\SimpleRouter;

// if request from console
if (PHP_SAPI === 'cli')
{
    if ($argv[1] === "sync") {
        $a = new \Core\Service\ImportCSV();
        $a->setFile(__DIR__ . '/assets/input.csv');
        $a->parseFile();
        $a->writeToDb();
    } else {
        echo "Command was not found :'(  ";
    }
    die();
}
require_once 'src/routes.php';

SimpleRouter::setDefaultNamespace('\Core\Controllers');

SimpleRouter::start();