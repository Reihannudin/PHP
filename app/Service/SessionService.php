<?php

namespace Reedb\PhpMvc\Service;

use Reedb\PhpMvc\Domain\Session;
use Reedb\PhpMvc\Domain\User;
use Reedb\PhpMvc\Repository\SessionRepository;
use Reedb\PhpMvc\Repository\UserRepository;

class SessionService{
    public static string $COOKIE_NAME = "X-REI-SESSION";

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    /**
     * @param SessionRepository $sessionRepository
     * @param UserRepository $userRepository
     */
    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }


    public function create(string $userId) : Session{
        $session = new Session();
        $session->id = uniqid();
        $session->email = $userId;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME , $session->id, time() + (60 * 60 * 24 * 30) , "/");

        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }


    public function current(): ?User{
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? "";

        $session = $this->sessionRepository->findById($sessionId);
        if ($sessionId == null){
            return null;
        }

        return $this->userRepository->findById($session->email);
    }
}