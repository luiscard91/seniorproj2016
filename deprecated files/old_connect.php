<?php
//https://seniorproject-luiscard91.c9users.io/phpmyadmin/
    $host = "127.0.0.1";
    $user = "luiscard91";
    $pass = "";
    $db = "tender_db"; 
    $port = 3306;
    $db_connection = mysqli_connect($host, $user, $pass, $db, $port);
    

    // query to grabs all the user
    /*
    $sql = "SELECT ID, USER FROM users";
    
    $query = mysqli_query($db_connection, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        //The nl2br() function inserts HTML line breaks (<br> or <br />) in front of \n
        echo nl2br("The ID is: " . $row['ID'] . " and the Username is: " . $row['USER'] ."\n");

    }
    */
    
    if(mysqli_connect_errno()){
        echo"failed to connect: " . mysqli_connect_error();
    } 
 
    
   
?>