<?php

namespace Reedb\PhpMvc\Controllers;

use Reedb\PhpMvc\App\View;

class HomeController{

    function index() : void{
        $model = [
            "title" => "Belajar PHP MVC" ,
            "content" => "Selamat Belajar PHP MVC"
        ];

        View::render('Home/index'  , $model);
    }

    function hello(): void
    {
        echo "HomeController.hello()";
    }

    function world(): void
    {
        echo "HomeController.world()";
    }

    function about(): void
    {
        echo "Author : Andrian Raihnnudin";
    }

    function login() : void{
        $request = [
            "username" => $_POST['username'] ,
            "password" => $_POST['password']
        ];

        $user = [

        ];

        $response = [
            "message" => "Login success"
        ];
    }

}
