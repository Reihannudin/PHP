<?php

namespace Reedb\PhpMvc\Repository;

use Reedb\PhpMvc\Domain\Session;

class SessionRepository{

    private \PDO $connection;

    /**
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session){
        $statement = $this->connection->prepare("insert into sessions(id , user_id) values (? , ?)");
        $statement->execute([$session->id , $session->email]);
        return $session;
    }

    public function findById(string $id) : ? Session{
        $statement = $this->connection->prepare("select id , user_id from sessions where id = ?");
        $statement->execute([$id]);

        try{
            if($row = $statement->fetch()){
                $session = new Session();
                $session->id = $row['id'];
                $session->email = $row['user_id'];
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id) : void{
        $statement = $this->connection->prepare("delete from sessions where id = ?");
        $statement->execute([$id]);
    }

    public function deleteAll() : void{
        $this->connection->exec("delete from sessions");
    }

}