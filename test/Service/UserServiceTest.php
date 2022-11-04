<?php

namespace Reedb\PhpMvc\Service;

use PHPUnit\Framework\TestCase;
use Reedb\PhpMvc\Config\Database;
use Reedb\PhpMvc\Domain\User;
use Reedb\PhpMvc\Exceptions\ValidationException;
use Reedb\PhpMvc\Model\UserRegisterRequest;
use Reedb\PhpMvc\Repository\UserRepository;

class UserServiceTest extends TestCase
{

    private UserService $userService;

    protected function setUp():void
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

        $this->userRepository->deleteAll();
    }

    /**
     * @throws ValidationException
     */
    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->id = "2403";
        $request->username = "Reihan";
        $request->password = "rahasia";
        $request->email = "reedbulls91@gmail.com";
        $request->contact = "087773301182";

        $response = $this->userService->register($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->username, $response->user->username);
        self::assertNotEquals($request->password, $response->user->password);

        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "";
        $request->username= "";
        $request->password = "";
        $request->email = "";
        $request->contact = "" ;

        $this->userService->register($request);
    }


    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = "2403";
        $user->username = "Reihan";
        $user->password = "rahasia";
        $user->email = "reedbulls91@gmail.com";
        $user->contact = "087773301182";


        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "2403";
        $request->username = "Reihan";
        $request->password = "rahasia";
        $request->email = "reedbulls91@gmail.com";
        $request->contact = "087773301182";

        $this->userService->register($request);
    }

}