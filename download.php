


<?php

    if(isset($_GET['key']) && $_GET['key'] == 'rahasia'){
        header('Content-Disposition: attachment; filename="kays.jpg"');
        header('Content-Type: image/jpeg ');
        readfile(__DIR__ . '/file/kays.jpg');
        exit();
    } else{
        echo "Invalid keys";
    }