<?php
        //if the session variables are set
        if (isset($_SESSION['id'])) {
            include_once("connect.php");
            $userID = $_SESSION['id'];
            $username = $_SESSION['username'];
            $now = time();
            $session_valid = true;
        
            //session time check
           if ($now > $_SESSION['expire']) {
                session_destroy();
                echo nl2br("Your session has expired! \n
                Click <a href='index.php'>here</a> to relog");
                $session_valid = false;
            }
        } 
        //send them back to the index page
        //if user didn't login
        else {
            header('Location: ../index.php');
            die();
        }
        
?>

