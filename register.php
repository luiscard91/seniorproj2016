<?php
    error_reporting(E_ALL & ~E_NOTICE);
    
    //If signup button is pressed
    if ($_POST['signup_btn']) {
        
        $errorMsg = "";
        
        include_once("phpScripts/connect.php");
        
        //Set and Get the variables
        if (isset($_POST['first_name']))	        $first_name = strip_tags($_POST['first_name']);
        if (isset($_POST['last_name']))	            $last_name = strip_tags($_POST['last_name']);
        if (isset($_POST['email']))	                $email = strip_tags($_POST['email']);
        if (isset($_POST['username']))	            $username = strip_tags($_POST['username']);
        if (isset($_POST['password']))	            $password = strip_tags($_POST['password']);
        if (isset($_POST['confirm_password']))	    $confirm_password = strip_tags($_POST['confirm_password']);
        
        //Cleanse input of any random whitespace
        $first_name = str_replace(' ', '', $first_name);
        $last_name = str_replace(' ', '', $last_name);
        $email = str_replace(' ', '', $email);
        $username = str_replace(' ', '', $username);
        $password = str_replace(' ', '', $password);
        $confirm_password = str_replace(' ', '', $confirm_password);
        
        $valid_email = 0;
        $first_name_entered = 0;
        $last_name_entered = 0;
        $valid_username = 0;
        $valid_password = 0;

        //Check if variables are valid, if not display error message
            //First name check
            if($first_name == ""){
                $errorMsg = "First name was not entered \\n";
            } else {
                $first_name_entered = true;
            }
            
            //Last name check
            if($last_name == ""){
               $errorMsg .= "Last name was not entered \\n";
            } else {
                $last_name_entered = true;
            }
            
            //Email check
            if($email == "") {
                $errorMsg .= "Email address was not entered \\n";
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))	{
                $errorMsg .= "Not a valid email address \\n";
            } else {
                $check_email_sql = "SELECT EMAIL FROM users WHERE EMAIL = '$email'";
                $query = mysqli_query($db_connection, $check_email_sql);
                $row = mysqli_fetch_row($query);
                    if ($row){
                        $errorMsg .= "Email address already exists \\n";
                    } else {
                        $valid_email = true;
                    }
            }
            
            //Username check
            if($username == "") {
                $errorMsg .= "Username was not entered \\n";
            } else {
                $check_usernames_sql = "SELECT USER FROM users WHERE USER = '$username'";
                $query = mysqli_query($db_connection, $check_usernames_sql);
                $row = mysqli_fetch_row($query);
                    if ($row){
                        $errorMsg .= "Username already exists \\n";
                    } else {
                        $valid_username = true;
                    }
            }
            
            //Password check
            if($password == "") {
               $errorMsg .= "No password was entered \\n";
            } elseif($password != $confirm_password) {
                $errorMsg .= "Passwords do not match \\n";
            } else {
                $valid_password = true;
            }
            
            //Insert user to database
            if($valid_username && $valid_email && $valid_password && $first_name_entered && $last_name_entered) {
                $insert_sql = "INSERT INTO users(`FIRST`, `LAST`, `USER`, `PASSWORD`, `EMAIL`) 
                    VALUES ('$first_name','$last_name','$username','$password', '$email')";

                $result = mysqli_query($db_connection, $insert_sql);
                
                echo("<script type = 'text/javascript'>
                    alert(\"Login created!\"); 
                    window.location.replace(\"index.php\")
                </script>");
            } else {
                 echo "<script type='text/javascript'>alert('$errorMsg')</script>";
            }
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="css/register.scss">
    </head>
    
    <body>

      <form action="register.php" method="post">
      
        <h1>Sign Up</h1>
        
        <fieldset>
          <label for="fname">First Name*</label>
          <input type="text" name="first_name">
          
          <label for="lname">Last Name*</label>
          <input type="text" name="last_name">
          
          <label for="uname">Username*</label>
          <input type="text" name="username">
          
          <label for="email">Email*</label>
          <input type="email" name="email">
          
          <label for="password">Password*</label>
          <input type="password" name="password">
          
          <label for="cpassword">Confirm Password*</label>
          <input type="password" name="confirm_password" name="user_password">
    
        </fieldset>
        <input type="submit" class="btn btn-default button" name="signup_btn" value = "Signup"/>
        <br></br>
        <p style="color:red">* required field</p>
        <p>Click <a href = "index.php">here</a> to go back to login </p>
      </form>   
    </body>
</html>


<!--
<script type="text/javascript">
    var firstNameRow = document.getElementById('first_name_row');
    var firstNameErrorMsg = document.getElementById('first_name_error_msg');
    var firstNameEntered = <?php echo($first_name_entered) ?>;
    //window.alert(firstNameEntered);
    
    if(!firstNameEntered){
        firstNameRow.className += 'danger';
        firstNameErrorMsg.innerHTML += ' First Name was not entered';
    }
</script>
-->