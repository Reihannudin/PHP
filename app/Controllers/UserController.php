<?php

namespace Reedb\PhpMvc\Controllers;

use Reedb\PhpMvc\APP\View;
use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Exceptions\ValidationException;
use Reedb\PhpMvc\Model\UserLoginRequest;
use Reedb\PhpMvc\Model\UserPasswordUpdateRequest;
use Reedb\PhpMvc\Model\UserProfileUpdateRequest;
use Reedb\PhpMvc\Model\UserRegisterRequest;
use Reedb\PhpMvc\Repository\SessionRepository;
use Reedb\PhpMvc\Repository\UserRepository;
use Reedb\PhpMvc\Service\SessionService;
use Reedb\PhpMvc\Service\UserService;

class UserController{

    private UserService $userService;
    private SessionService $sessionService;

    public function __construct(){
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository , $userRepository);
    }

    public function register(){
        View::render('User/register' , [
            'title' => 'Register new User'
        ]);
    }

    public function postRegister(){
        $request = new UserRegisterRequest();
//        $request->id = $_POST['id'];
        $request->username = $_POST['username'];
        $request->email = $_POST['email'];
        $request->password = $_POST['password'];
        $request->contact = $_POST['contact'];

        try{
            $this->userService->register($request);
            View::redirect('/users/login');
        } catch (ValidationException $exception){
            View::render('User/register' , [
                'title' => 'Register new user',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login(){
        View::render('User/login' , [
            "title" => "Login User"
        ]);
    }

    public function postLogin(){
        $request = new UserLoginRequest();
        $request->email = $_POST['email'];
        $request->password = $_POST['password'];

        try{
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->email);
            View::redirect('/');
        }catch (ValidationException $exception) {
            View::render('User/login', [
                'title' => 'Login user',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function logout(){
        $this->sessionService->destroy();
        View::redirect("/");
    }
//
//    public function updateProfile(){
//        $user = $this->sessionService->current();
//
//        View::render('User/profile' , [
//            "title" => "Update user profile" ,
//            "user" => [
//                "id" => $user->id,
//                "name" => $user->username
//            ]
//        ]);
//    }
//
//    public function postUpdateProfile(){
//
//        $user = $this->sessionService->current();
//
//        $request = new UserProfileUpdateRequest();
//        $request->email = $user->username;
//        $request->username = $_POST['username'];
//
//        try{
//            $this->userService->updateProfile($request);
//            View::redirect('/');
//        } catch (ValidationException $exception){
//            View::render('User/profile', [
//                "title" => "Update user profile",
//                "error" => $exception->getMessage(),
//                "user" => [
//                    "email" => $user->email,
//                    "username" => $_POST['username']
//                ]
//            ]);
//        }
//
//    }
//
//
//    public function updatePassword()
//    {
//        $user = $this->sessionService->current();
//        View::render('User/password', [
//            "title" => "Update user password",
//            "user" => [
//                "email" => $user->email
//            ]
//        ]);
//    }
//
//    public function postUpdatePassword(){
//        $user = $this->sessionService->current();
//        $request = new UserPasswordUpdateRequest();
//        $request->email = $user->email;
//        $request->oldPassword = $_POST['oldPassword'];
//        $request->newPassword = $_POST['newPassword'];
//
//        try{
//            $this->userService->updatePassword($request);
//            View::redirect('/');
//        } catch (ValidationException $exception){
//            View::render('User/password', [
//                "title" => "Update user password",
//                "error" => $exception->getMessage(),
//                "user" => [
//                    "email" => $user->email
//                ]
//            ]);
//        }
//
//    }

}

