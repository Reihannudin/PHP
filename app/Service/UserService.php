<?php

namespace Reedb\PhpMvc\Service;

use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Domain\User;
use Reedb\PhpMvc\Exceptions\ValidationException;
use Reedb\PhpMvc\Model\UserLoginRequest;
use Reedb\PhpMvc\Model\UserLoginResponse;
use Reedb\PhpMvc\Model\UserRegisterRequest;
use Reedb\PhpMvc\Model\UserRegisterResponse;
use Reedb\PhpMvc\Repository\UserRepository;

class UserService{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request) : UserRegisterResponse{
//        define validate
        $this->validateUserRegistrationRequest($request);

        try{
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->email);
            if ($user != null){
                throw new ValidationException("Email already exists");
            }

            $user = new User();
//            $user->id = $request->id;
            $user->username = $request->username;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->email = $request->email;
            $user->contact = $request->contact;

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
    }

//     make validation for register function

    /**
     * @throws ValidationException
     */
    private function validateUserRegistrationRequest(UserRegisterRequest $request): void
    {
        if ($request->username == null || $request->password == null ||
            $request->email ==  null || $request->contact == null ||
            trim($request->username) == "" ||  trim($request->password) == "" ||
            trim($request->email) == "" ||  trim($request->contact) == ""
        ){
            throw new ValidationException("column cannot blank");
        }
    }

    /**
     * @throws ValidationException
     */
    public function login(UserLoginRequest $request) : UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findLoginByEmail($request->email);

        if ($user == null) {
            throw new ValidationException("Email or password is wrong");
        }

        if (password_verify($request->password , $user->password)) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("Password is wrong");
        }
    }

    /**
     * @throws ValidationException
     */
    public function validateUserLoginRequest(UserLoginRequest $request): void
    {
        if($request->email == null &&  $request->password == null ||
            trim($request->email) == "" && trim($request->password) == "") {
            throw new ValidationException("Column cannot blank");
        } else if ($request->email == null ||  trim($request->email) == "" ){
            throw new ValidationException("Email cannot blank");
        } else if($request->password == null || trim($request->password) == ""){
            throw new ValidationException("Password cannot blank");
        }
    }

}