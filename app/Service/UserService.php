<?php

namespace Reedb\PhpMvc\Service;

use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Domain\User;
use Reedb\PhpMvc\Exceptions\ValidationException;
use Reedb\PhpMvc\Model\UserLoginRequest;
use Reedb\PhpMvc\Model\UserLoginResponse;
use Reedb\PhpMvc\Model\UserPasswordUpdateRequest;
use Reedb\PhpMvc\Model\UserPasswordUpdateResponse;
use Reedb\PhpMvc\Model\UserProfileUpdateRequest;
use Reedb\PhpMvc\Model\UserProfileUpdateResponse;
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


    public function updateProfile(UserProfileUpdateRequest $request) : UserProfileUpdateResponse{
        $this->validateUserProfileUpdateRequest($request);

        try{
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->email);
            if ($user == null){
                throw new ValidationException("User is not found");
            }

            $user->username = $request->username;
            $this->userRepository->update($user);

            Database::commitTransaction();

            $response = new UserProfileUpdateResponse();
            $response->user = $user;
            return $response;

        } catch (\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserProfileUpdateRequest(UserProfileUpdateRequest $request)
    {
        if ($request->email == null || $request->username == null ||
            trim($request->email) == "" || trim($request->username) == "") {
            throw new ValidationException("Email and username can not blank");
        }
    }

    public function updatePassword(UserPasswordUpdateRequest $request) : UserPasswordUpdateResponse
    {

        $this->validateUserPasswordUpdateRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->email);
            if ($user==null){
                throw new ValidationException("User is not found");
            }

            if (!password_verify($request->oldPassword , $user->password)){
                throw new ValidationException("Old password is wrong");
            }

            $user->password = password_hash($request->newPassword , PASSWORD_BCRYPT);
            $this->userRepository->update($user);
            Database::commitTransaction();

            $response = new UserPasswordUpdateResponse();
            $response->user = $user;
            return $response;
        }
        catch (\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }
    }


    private function validateUserPasswordUpdateRequest(UserPasswordUpdateRequest $request)
    {
        if ($request->email == null || $request->oldPassword == null || $request->newPassword == null ||
            trim($request->email) == "" || trim($request->oldPassword) == "" || trim($request->newPassword) == "") {
            throw new ValidationException("Id, Old Password, New Password can not blank");
        }
    }

}