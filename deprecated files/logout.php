<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 
session_destroy();

?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <a href="index.php">Click here to relog</a>
    </body>
</html>