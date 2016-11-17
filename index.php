<?php 
error_reporting(E_ALL & ~E_NOTICE);

session_start(); 

//if login is pressed
if ($_POST['login_btn']){
    
//Time in seconds the session stays valid for
$sessionTime = 600000;

// query to grabs all the user
    
    include_once("phpScripts/connect.php"); //connect to db
    $username = strip_tags($_POST['username']); 
    $password = strip_tags($_POST['password']);
    
    //prints the username and password entered by user
    //echo nl2br("The username = " . $username . "\n");
    //echo nl2br("the Password = " . $password . "\n");

    $sql = "SELECT ID, USER, PASSWORD
            FROM users 
            WHERE USER = '$username' LIMIT 1";
    
    //prints sql statment used 
    //echo nl2br("sql statement = " . $sql . "\n");
      
    //query that returns info of the coresponding username
    $query = mysqli_query($db_connection, $sql);
    
    
    //get the username and pass from the returning query
    if ($query){
        $row = mysqli_fetch_row($query);
        $userID = $row[0];
        $db_username = $row[1];
        $db_password = $row[2];
    }
    
    //prints the id, username and pass returned from the previous query
    //echo nl2br("db id = " . $userID . "\n");
    //echo nl2br("the db_username = " . $db_username . "\n");
    //echo nl2br("the db_password = " . $db_password . "\n");
    
    //setting session variables if credentials match up
    if ($username == $db_username && $password == $db_password && $username != ""){
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $userID;
        $_SESSION['start'] = time(); // session start time
        $_SESSION['expire'] = $_SESSION['start'] + ($sessionTime); //time that session expires in seconds
        
        
        header('Location: home.php');
    } else {
        //ToDo: warn user they entered incorrect username or password
        echo "<script type='text/javascript'>alert('Incorrect username or password.');</script>";
    }
    
}

if ($_POST['signup_btn']){
    
    header('Location: register.php');
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Chicken Tendr</title>
        <link rel="stylesheet" href="css/register.css">
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        
    </head>
    
    <body>
        <form action="index.php" method="post">
      
        <h1>Chicken Tendr</h1>
        
        <fieldset>
            <input type="text" placeholder="Username" name="username"/>
            <input type="password" placeholder="Password" name="password"/>
        </fieldset>
            <tr>
                <input type="submit" class="btn btn-default" name="login_btn" value = "Login"/>
                <input type="submit" class="btn btn-default" name="signup_btn" value = "Signup"/>
            </tr>
      </form> 
    </body>
</html>