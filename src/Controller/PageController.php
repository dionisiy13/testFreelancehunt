<?php

namespace Core\Controller;

class PageController
{
    public function notFound()
    {
        return !require __DIR__.'/../view/404.phtml';
    }

    public function indexAction()
    {
        return !require __DIR__.'/../view/index.phtml';
    }
}
