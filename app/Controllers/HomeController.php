<?php

namespace Reedb\PhpMvc\Controllers;

use Reedb\PhpMvc\App\View;

class HomeController
{

    function index(): void
    {
        $model = [
            "title" => "McDonald's",
            "content" => "Welcome to Starter pack McDonald's Web App"
        ];

        View::render('Home/home', $model);
    }

}