<?php
    $say = "Hello " . htmlspecialchars($_GET['name']);
?>

<html>
    <body>
        <h3><?= $say ?></h3>
    </body>
</html>
