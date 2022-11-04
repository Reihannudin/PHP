<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Reedb\PhpMvc\APP\Router;
use Reedb\PhpMvc\Controllers\HomeController;
use Reedb\PhpMvc\Controllers\UserController;
use Reedb\PhpMvc\Middleware\MustLoginMiddleware;
use Reedb\PhpMvc\Middleware\MustNotLoginMiddleware;


Router::add('GET' , '/' , HomeController::class , 'index' , []);
Router::add('GET' , '/users/register' , UserController::class , 'register' , [MustNotLoginMiddleware::class]);
Router::add('POST' , '/users/register' , UserController::class , 'postRegister' , [MustNotLoginMiddleware::class]);
Router::add('GET' , '/users/login' , UserController::class , 'login' , [MustNotLoginMiddleware::class]);
Router::add('POST' , '/users/login' , UserController::class , 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET' , '/users/logout' , UserController::class , 'logout', [MustLoginMiddleware::class]);

Router::run();