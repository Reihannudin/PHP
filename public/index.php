<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Reedb\PhpMvc\App\Router;
use Reedb\PhpMvc\Controllers\HomeController;


Router::add('GET' , '/' , HomeController::class , 'index');

Router::run();