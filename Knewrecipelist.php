<?php

// Program name variable
	$pgm = "Knewrecipelist.php";
	
// Connect and get user id
	include_once("usersrecipe.php");
	$userID = $_SESSION['id'];

// Sort by recipe values
	$categories = array("All", "Appetizers", "Cakes", "Chinese_Foods", "Dessert", "Drinks", "Fish_And_Seafoods", "Japanese_Foods", "Main_Meals", 
					"Meats", "Pasta", "Pies_And_Pastries", "Salad", "Soups", "Special_Filipino_Delicacies", "Vegetables", "Western_Foods");

// Store the amount of recipes returned
	$count = 0;

// Store the number of recipes per page
	$pageCount = 1;
	
// keeps track of index of recipes
	$startIndex = 0;
	
// keeps track of last recipe
	$endIndex = 0;
	
//Error message
	$msg = NULL;
	$color = "black";
	
	
/* NOT NEEDED ANYMORE
	Connect to MySQL and the tender_db Database
    $host = "127.0.0.1";
    $user = "luiscard91";
    $pass = "";
    $db = "tender_db"; 
    $port = 3306;
	$mysqli = new mysqli($host, $user, $pass, $db, $port);
*/

	$mysqli = $db_connection;

// Make sure when first loaded, categories is All
	$cat_in = "All";
	
// Get user input on what category to sort by
	if(isset($_POST['submit']) || $_GET['cat'] || $_POST['addrecipe']) {
		if (isset($_POST['cat_in'])) $cat_in = $_POST['cat_in'];
		if (isset($_GET['cat']))	$cat_in = $_GET['cat'];
		if (isset($_POST['cats'])) $cat_in = $_POST['cats'];
		
		if ($cat_in == "All") {
	    		$filter = NULL;
		} else {
	    	$filter = "WHERE category = '$cat_in'";
		}
}

// Get next/back button tasks
	if (isset($_GET['task']))	{$task = $_GET['task'];}
		elseif (isset($_POST['task'])) {$task = $_POST['task'];}
			else {$task = NULL;}

// Add recipe to saved recipes
	if(isset($_POST['addrecipe'])) {
    	if (isset($_POST['id']))			$addid = $_POST['id'];
    	if (isset($_POST['title']))			$addtitle = $_POST['title'];
		
//CHECK IF RECIPE IS ALREADY ADDED
		$checkRecipe = $mysqli->query("SELECT a.id FROM recipes a JOIN fav_recipes b ON a.ID = b.RECIPEID WHERE id = '$addid' AND b.USERID = '$userID'");
			if ($checkRecipe->num_rows == 0) {
				$queryAdd = "INSERT INTO fav_recipes (USERID, RECIPEID) VALUES
					($userID, $addid)";
				$resultAdd = $mysqli->query($queryAdd); 
				
				echo "<script> 
					alert(\"$addtitle has been added to saved recipes!\")
				</script>";
			}
			else {
				echo "<script>
				alert(\"$addtitle was not added! It already exists in your saved recipes!\")
				</script>";
			}
	}
  
// Query the recipes tables 


	if($task == "next"){
		$startIndex = $_GET['i'] + $pageCount;
		//echo("startIndex <br>" . $startIndex);
		
		$query = "SELECT id, title, category, ingredients
			FROM recipes
			$filter ORDER BY id LIMIT $startIndex , $pageCount";
		$result = $mysqli->query($query);
		//echo("the query: <br>" . $query);
		
		
		$queryCount = mysqli_query($mysqli, "SELECT COUNT(*) AS num FROM recipes $filter");
		$numRows = mysqli_fetch_assoc($queryCount);
		$endIndex = $numRows['num'];
		
		
		//$startIndex = $startIndex + $pageCount;
		
	} elseif($task == "back"){
		$startIndex = $_GET['i'] - $pageCount;
		//echo("startIndex <br>" . $startIndex);
		
		$query = "SELECT id, title, category, ingredients
			FROM recipes
			$filter ORDER BY id LIMIT $startIndex , $pageCount";
		$result = $mysqli->query($query);
		
		$queryCount = mysqli_query($mysqli, "SELECT COUNT(*) AS num FROM recipes $filter");
		$numRows = mysqli_fetch_assoc($queryCount);
		$endIndex = $numRows['num'];
		//echo("the query: <br>" . $query);
		// = $startIndex + $pageCount;
		
	} else {
		$query = "SELECT id, title, category, ingredients
				FROM recipes
				$filter ORDER BY id LIMIT $startIndex , $pageCount";
		$result = $mysqli->query($query);
		
		$queryCount = mysqli_query($mysqli, "SELECT COUNT(*) AS num FROM recipes");
		$numRows = mysqli_fetch_assoc($queryCount);
		$endIndex = $numRows['num'];
		
		//$startIndex = $startIndex + $pageCount;
	}
	
// Sort by Category
	echo "
	<div class =\"container\">
		<div class=\"row\">
			<div class=\"center-me\">
				<form action='$pgm' method='post'>
				<div class=\"form-group\">
				CATEGORY: <select class=\"selectpicker\"  name='cat_in'>";
				foreach ($categories as $cate) {
						if ($cate == $cat_in) $se = "SELECTED";	else $se = NULL;
							echo "<option $se>$cate</option>";
				}
				echo "</select>
					<input class=\"btn btn-default\" type='submit' name='submit' value='Sort'>
					</div>
					</form>
			</div>
		</div>";
		
	echo "<font color='$color'><strong>$msg</strong>";
	

// Gets the queried information and displays it
// Get image from the images folder: <img src='imagerecipes/$id.jpg'>
	while(list($id, $title, $category, $ingredients) = $result->fetch_row()) {
		$count++;
			echo utf8_encode (
			
			"
			<center>
			<div class=\"row \">
					<img class=\"center-me img-responsive\" src='imagerecipes/$id.jpg'/>
			</div>
			</center>
			
			<div class=\"row btn-row\">
				<div class=\"center-me\">
					<button id='back_btn' class='btn btn-default' onclick=\"location.href='$pgm?i=$startIndex&task=back&cat=$cat_in#'\"><img src='btnimages/back.png' height='10' width='10'/></button>
					<button id='next_btn' class='btn btn-default' onclick=\"location.href='$pgm?i=$startIndex&task=next&cat=$cat_in'\"><img src='btnimages/next.png' height='10' width='10'/></button>
				</div>
			</div>
			
			<form action='' method='post'>
			<input type='hidden' name='id' value='$id'/>
			<input type='hidden' name='title' value='$title'/>
			<input type='hidden' name='cats' value='$cat_in'/>
			
			<div class=\"row title-row\">
				<div class=\"center-me\">
				<h2>$title</h2>
					<input class='btn btn-default btn-sm' type='submit' name='addrecipe' value='Add recipe'>
					<button id='$id details_btn' type='button' class='btn btn-default btn-sm' onclick=\"toggleShow($id)\">Details</button>
				</div>
			</div>
			
			<div class=\"row ingredient-row\">
				<div class=\"center-me\">
					<div id=\"$id details\" class=\"hidden\">
						<pre>$ingredients</pre>
					</div>
				</div>
			</div>

		
			</form>
			</div> <!-- container div -->
			");
	}

?>

<!-- ToDo:
		-Fix next button so it won't display entries if there are no more in that category
-->

<script type="text/javascript">
	var backBtn = document.getElementById('back_btn');
	var nextBtn = document.getElementById('next_btn');
	var startIndex = <?php echo($startIndex) ?>;
	var endIndex = <?php echo($endIndex) ?>;
	
	
	if(backBtn){
		if(startIndex == 0)
			backBtn.className += ' hidden';
	}
	if(nextBtn){
		if(startIndex == endIndex-1)
			nextBtn.className += ' hidden';
	}
</script>