<?php

require_once __DIR__ . '/helper/Connected.php';

$connection = getConnection();

$username = "admin";
$password = "admin";

$sql = "SELECT * FROM admin WHERE username = ? AND password = ?";

$statement= $connection->prepare($sql);
$statement->execute([$username , $password]);

if($row = $statement->fetch()){
    echo "Success Login " . $row["username"] . PHP_EOL;
} else {
    echo "Failed Login" . PHP_EOL;
}

$sqlCus = "SELECT * FROM customers";
$result = $connection->query($sqlCus);
$customers = $result->fetchAll();

var_dump($customers);

$connection = null;



