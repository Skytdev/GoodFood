<?php
// api/src/Controller/ArticleAccesController.php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;


class MenuAccesController
{
    private $bookPublishingHandler;


    public function __invoke(Menu $data): Menu
    {
        
        $this->article->handle($data);

        return $data;
    }
}