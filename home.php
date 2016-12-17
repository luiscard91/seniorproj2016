<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8" />
      <title>Chicken Tender</title>
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
        
        
      <link href="css/home.scss" rel="stylesheet">

    
  </head>
  <body>
    <?php
        include_once("phpScripts/connect.php");
        include_once("phpScripts/session_check.php");
        //tests if valid session and displays user info
        if ($session_valid){
            //do stuff here
            $sql = "SELECT * FROM users WHERE ID = '$userID'";
            $query = mysqli_query($db_connection, $sql);
            $row = mysqli_fetch_row($query);
            $welcomeMsg= "$row[1]" . " " . "$row[2]";

            include("objects/nav.php");
        
    ?>
    
<div id="wrapper">
	<div class="section" id="main-content">
	        <div class="container header-container">
    			<div class="headline">
    			    <div class="row">
        			    Chicken Tendr<br>
    			    </div>
    			    <div class="row welcome-msg">
        			    Welcome <?=$welcomeMsg?>!
    			    </div>
    			</div>
			</div>
			
			<div class="container nav-container">
			    <div class = "row">
			        <div class="col-md-4 col-xs-6">
			            <a href="usersdisplay.php"><img class="nav-icons img-fluid" src="homepageicons/pantry.jpg"></a>
			            <p>Pantry</p>
			        </div>
			        <div class="col-md-4 col-xs-6">
			            <a href="usersshoppinglist.php"><img class="nav-icons img-fluid" src="homepageicons/shopping.jpg"></a>
			            <p>Shopping List</p>
			        </div>
			        <div class="col-md-4 col-xs-6">
			            <a href="usersrecipe.php"><img class="nav-icons img-fluid" src="homepageicons/recipes.jpg"></a>
			            <p>Recipes</p>
			        </div>
			        <div class="clearfix visible-sm visible-xs">
			            <div class="col-xs-6">
    			            <a href="usersavedrecipes.php"><img class="nav-icons img-fluid" src="homepageicons/saved.jpg" ></a>
    			            <p>Saved Recipes</p>
    			        </div>
    			        <div class="col-xs-6">
    			            <a href="usersconversion.php"><img class="nav-icons img-fluid" src="homepageicons/simplify-scale.png"></a>
    			            <p>Conversion Chart</p>
    			        </div>
    			        <div class="col-xs-6">
    			            <a href="usersabout.php"><img class="nav-icons img-fluid" src="homepageicons/About-us.png"></a>
    			            <p>About Us</p>
    			        </div>
			        </div>
			     </div>
			     <div class="row clearfix visible-md visible-lg">
			        <div class="col-md-4 col-xs-6">
			            <a href="usersavedrecipes.php"><img class="nav-icons img-fluid" src="homepageicons/saved.jpg" ></a>
			            <p>Saved Recipes</p>
			        </div>
			        <div class="col-md-4 col-xs-6">
			            <a href="usersconversion.php"><img class="nav-icons img-fluid" src="homepageicons/simplify-scale.png"></a>
			            <p>Conversion Chart</p>
			        </div>
			        <div class="col-md-4 col-xs-6">
			            <a href="usersabout.php"><img class="nav-icons img-fluid" src="homepageicons/About-us.png"></a>
			            <p>About Us</p>
			        </div>
			    </div>
			</div>
			
    			
    </div>
</div>

<?php }?> <!--end of session check-->
</body>
</html>