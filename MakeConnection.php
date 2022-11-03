<?php

    $host = "localhost";
    $port = 3306;
    $database = "trainee-php-db";
    $username = "root";
    $password = "";

//    make validation
    try{
        //make connection
        $connection = new PDO("mysql:host=$host:$port;dbname=$database"  , $username , $password);
        echo "Success conndected to db";

//      closed database
        $connection = null;
    } catch (PDOException $exception){
        echo "Error connected to Database" . $exception->getMessage() . PHP_EOL;
    }
