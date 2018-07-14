<?php

namespace Core\Controller;

use Core\Repository\Countries;
use Core\Repository\Users;
use Core\Service\Database;
use Pecee\Http\Request;
use Pecee\Http\Response;

class PageController {

    public function notFound()
    {
        return ! require(__DIR__ . '/../view/404.phtml');
    }

    public function indexAction()
    {
        return ! require(__DIR__ . '/../view/index.phtml');
    }

}