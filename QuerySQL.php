<?php

require_once __DIR__ . '/helper/Connected.php';

$connection = getConnection();

$sql = "select * from customers";
$result = $connection->query($sql);

foreach ($result as $row){
    var_dump($row);
}

$connection = null;