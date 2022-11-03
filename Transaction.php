<?php

require_once __DIR__ . "/helper/Connected.php";

$connection = getConnection();

$connection->beginTransaction();

$connection->exec("insert into comments(email , comment) values ('reedbulls91@gmail.com' , 'Hello React')");
$connection->exec("insert into comments(email , comment) values ('ziyaadsq@gmail.com' , 'Hello Javascript')");
$connection->exec("insert into comments(email , comment) values ('nuttyfrutty@gmail.com' , 'Hello Laravel')");

// commit transaction
//$connection->commit();

//rollback trasaction
$connection->rollBack();

$connection = null;