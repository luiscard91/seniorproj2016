<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 

//if the session variables are set
if (isset($_SESSION['id'])) {
    include_once("connect.php");
    $userID = $_SESSION['id'];
    $username = $_SESSION['username'];
    $now = time();
    $session_valid = true;
    
    $sql = "SELECT DISTINCT `ITEM_NAME`, `BRAND`, `TYPE`, `QTY_ON_HAND` 
    FROM `items` WHERE `USERID` = $userID";
    
   //echo "<br /> $sql <br />";
    $query = mysqli_query($db_connection, $sql);
    
    //session time check
   if ($now > $_SESSION['expire']) {
        session_destroy();
        echo nl2br("Your session has expired! \n
        Click <a href='index.php'>here</a> to relog");
        $session_valid = false;
    }
} 
//send them back to the index page
else {
    header('Location: index.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    </head>
    
    <body>
        <?php
            //do stuff you want to while the session is valid in this if statement
            if($session_valid){
            echo "<h1> Welcome $username!</h1>  <br /> <br />";
              
            while ($row = mysqli_fetch_assoc($query)){
                echo 
                    "<tr>
                        <td>" . $row['ITEM_NAME'] . "</td>
                        <td>" . $row['QTY_ON_HAND'] . "</td>"
                        //<td>" . $row['TYPE'] . "</td>
                    ."</tr> <br>";
                // you don't need to assign the row to anything
                
                
            
            
            }  
                
            
            //bottom of page logout    
           // echo    
           //     "<form action='index.php'>
           //         <input type='submit' value = 'Logout'/>
           //     </form>";
                
            }
        ?>
    </body>
</html>
*/