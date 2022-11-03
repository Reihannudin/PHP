








<?php
//    single query parameter
//    $say = "Hello " . $_GET['name'];

//    multiple query parameter
    $sayFull = "Hello " . $_GET['firstname'] . " " . $_GET['lastname'];

//    array query parameter
    $numbers = $_GET['numbers'];
    $total = 0;

    foreach ($numbers as $number){
        $total += $number;
    }

?>

<html>
    <body>
        <h2>
            <?= $sayFull ?>
        </h2>
        <h3>
            <?= "Total = $total"?>
        </h3>
    </body>
</html>
