<?php

require_once __DIR__ . '/../helper/Connected.php';

$connection = getConnection();

$username = "admin'; #";
$password = "admin";

$sql = "SELECT * FROM admin WHERE username = :username AND password = :password";

$statement= $connection->prepare($sql);
$statement->bindParam("username" , $username);
$statement->bindParam("password"  , $password);
$statement->execute();

$success = false;
foreach ($statement as $row){
    $success = true;
}

if($success){
    echo "Success Login" . PHP_EOL;
} else {
    echo "Failed Login" . PHP_EOL;
}

$connection = null;
