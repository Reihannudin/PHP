<?php

namespace Reedb\PhpMvc\Model;

class UserRegisterRequest{
    public ?string $id = null;
    public ?string $username = null;
    public ?string $password =null;
    public ?string $email = null;
    public ?string $contact = null;
}