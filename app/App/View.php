<?php

namespace Reedb\PhpMvc\APP;

class View{
    public static function render(string $view , $model){
        require __DIR__ . '/../View/Header.php';
        require __DIR__ . '/../View/' .$view . '.php';
        require __DIR__ . '/../View/Footer.php';
    }

    public static function redirect(string $url){
        header("Location: $url");
        if (getenv("mode") != "test"){
            exit();
        }
    }

}