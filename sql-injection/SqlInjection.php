<?php

require_once __DIR__ . '/../helper/Connected.php';

$connection = getConnection();

$username = "admin';#";
$password = "admin";

$sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password';";

$statement= $connection->query($sql);

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
