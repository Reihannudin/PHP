<?php

require_once __DIR__ . '/helper/Connected.php';

$connection = getConnection();
////
//$sql = <<<SQL
//    INSERT INTO customers(id, name, email)
//    VALUES ('2403' , 'Reihan' , 'reedbulls91@gmail.com');
//SQL;

$sql = <<<SQL
    INSERT INTO customers(id, name, email)
    VALUES ('khannedy', 'Khannedy', 'khannedy@test.com');
SQL;

$connection->exec($sql);

$connection = null;