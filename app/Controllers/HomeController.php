<?php

namespace Reedb\PhpMvc\Controllers;

use Reedb\PhpMvc\App\View;
use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Domain\User;
use Reedb\PhpMvc\Repository\SessionRepository;
use Reedb\PhpMvc\Repository\UserRepository;
use Reedb\PhpMvc\Service\SessionService;

class HomeController
{
    private SessionService $sessionService;

    /**
     * @param SessionService $sessionService
     */
    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository , $userRepository);
    }


    function index(): void
    {
        $user = $this->sessionService->current();
        if ($user == null){
            View::render('Home/index' , [
                "title" => "PHP Login Management"
            ]);
        } else {
            View::render('Home/dashboard',[
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->username
                ]
            ]);
        }
    }
}