<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8" />
      <title>Chicken Tender</title>
      
      <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        
        <link href="css/home.css" rel="stylesheet">

    
  </head>
  <body>
   
   <!--session_check.php includes:
        $userID, $username, $now as current time, $session_valid 
        
        -->
    <div class="col-sm-12 col-xs-6 col-md-12">
    <?php
        include_once("phpScripts/connect.php");
        include_once("phpScripts/session_check.php");
        //tests if valid session and displays user info
        if ($session_valid){
            //do stuff here
            $sql = "SELECT * FROM users WHERE ID = '$userID'";
            $query = mysqli_query($db_connection, $sql);
            $row = mysqli_fetch_row($query);
            echo(
            "<h1>Welcome " . $row[1] . " " . $row[2] ."</h1>");
            echo("</div>");
            include("objects/nav.php");
        }
    ?>
    
<div id="wrapper">
	<div id="main-content">
			<div id="logo" align = "center">
			<font size="50">Chicken Tendr</size>
			<br></br>
			<br></br>
			</div>
			<div align = "center">
                <table border="0">
                    <center>
                        <tr>
                            <td><a href="pantrylist.php"><img src="homepageicons/pantry.jpg" height="150" width="150" hspace="75"></a></td>
                            <td><a href=""><img src="homepageicons/shopping.jpg" height="150" width="150" hspace="75"></a></td>
                            <td><a href="Knewrecipelist.php"><img src="homepageicons/recipes.jpg" height="150" width="150" hspace="75"></a></td>
                            <td><a href="usersavedrecipes.php"><img src="homepageicons/saved.jpg" height="150" width="150" hspace="75"></a></td>
                        </tr>
                        <tr>
                            <td align="center">Pantry</td>
                            <td align="center">Shopping List</td>
                            <td align="center">Recipes</td>
                            <td align="center">Saved Recipes</td>
                        </tr>
                    </center>
                </table>
            </div>
    </div>
</div>

    
</body>
</html>