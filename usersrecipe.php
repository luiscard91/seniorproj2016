
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
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <link href="css/global.scss" rel="stylesheet">
        <link rel="stylesheet" href="css/userrecipe.scss">
            
</head>

<body>
    
    <div class="container-fluid">

    <!--session_check.php includes:
        $userID, $username, $now as current time, $session_valid -->
    
    <div class="page-title">
        <center><b><u>Recipes</u></b></center>
    </div>
    
    <?php
        include("objects/nav_recipe.php");
        include_once("phpScripts/session_check.php");
        //tests if valid session and displays user info
        if ($session_valid){
            include_once('Knewrecipelist.php');
            
    ?>

    </div>
    <?php }?> <!-- End of session check -->
    
</body>
<script>
    function toggleShow(itemID){
        var detailsClassName = document.getElementById(itemID + ' details').className;
        if (detailsClassName == "hidden"){
            document.getElementById(itemID + ' details').className = "";
            document.getElementById(itemID + ' details_btn').textContent = "Hide";
        } else {
            document.getElementById(itemID + ' details').className = "hidden";
            document.getElementById(itemID + ' details_btn').textContent = "Details";
        }
    }
    

</script>
</html>