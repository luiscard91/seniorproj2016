
<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 
?>


 <!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title></title>
        
        <!-- for mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
       
        <link href="css/global.scss" rel="stylesheet">
        <link href="css/about.scss" rel="stylesheet">
        
</head>

<body>
    
    <div class="container-fluid">

    <!--session_check.php includes:
        $userID, $username, $now as current time, $session_valid -->
        <div class="page-title">
    		<center><b><u>About Us</u></b></center>
		</div>
        <?php
            include("objects/nav_about.php");
            include_once("phpScripts/session_check.php");
            //tests if valid session and displays user info
            if ($session_valid){ ?>

                <?php
                include_once('about.php');
                //include('logout_btn.php');
            }
        ?>

    </div>
</body>

</html>