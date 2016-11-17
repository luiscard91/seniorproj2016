
<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 
?>


 <!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title></title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        
            
</head>

<body>
    
    <div class="container-fluid">

    <!--session_check.php includes:
        $userID, $username, $now as current time, $session_valid -->
    
		<center><b><u>Refrigerator and Pantry</u></b></center><br><br>
        <?php
            include("objects/nav_pantry.php");
            include_once("phpScripts/session_check.php");
            //tests if valid session and displays user info
            if ($session_valid){
                include_once('pantrylist.php');
                //include('logout_btn.php');
            }
        ?>

    </div>
</body>

</html>