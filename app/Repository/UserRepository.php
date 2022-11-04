<?php

namespace Reedb\PhpMvc\Repository;

use http\Encoding\Stream;
use Reedb\PhpMvc\Domain\User;

class UserRepository{
    private \PDO $connection;

    public function __construct(\PDO $connection){
        $this->connection = $connection;
    }

    public function save(User $user) : User{
        $statement = $this->connection->prepare("insert into user( username, password , email, contact) values (?, ?, ?, ?)");
        $statement->execute([
             $user->username, $user->password , $user->email , $user->contact
        ]);
        return $user;
    }

    public function findLoginByEmail(string $email) : ?User{
        $statement = $this->connection->prepare("select  password, email from user where email = ?");
        $statement->execute([$email]);

        try{
            if($row = $statement->fetch()){
                $user = new User();
                $user->password = $row['password'];
                $user->email = $row['email'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(string $email): ?User{
        $statement = $this->connection->prepare("select id  , username, password, email, contact from user where email = ?");
        $statement->execute([$email]);

        try{
            if($row = $statement->fetch()){
                $user = new User();
                $user->id = $row['id'];
                $user->username = $row['username'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->contact = $row['contact'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }

    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE from user");
    }
}