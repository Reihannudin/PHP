<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Reedb\PhpMvc\App\Router;
use Reedb\PhpMvc\Controllers\HomeController;
use Reedb\PhpMvc\Controllers\ProductController;

Router::add('GET' , '/' , HomeController::class , 'index');
Router::add('GET' , '/product' , ProductController::class , 'showAll');
Router::add('GET' , '/menu' , ProductController::class  ,  'showAllMenu');
//Router::add('GET' , '/product' , ProductController::class , 'showRecommended');

Router::run();