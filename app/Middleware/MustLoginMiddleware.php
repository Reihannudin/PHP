<?php

namespace Reedb\PhpMvc\Middleware;

use Reedb\PhpMvc\APP\View;
use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Repository\SessionRepository;
use Reedb\PhpMvc\Repository\UserRepository;
use Reedb\PhpMvc\Service\SessionService;

class MustLoginMiddleware implements Middleware{

    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository , $userRepository);
    }


    function before(): void
    {
        $user = $this->sessionService->current();
        if($user == null){
            View::redirect('/users/login');
        }
    }
}