<?php
/* 
TO DO:

    display only a certain amount recpies at a time

*/


// Program name variable
	$pgm = "savedrecipes.php";
	
// number of recipes per page
    $pageCount = 5;

// recipe index
    $index = 0;

// number of recipes stored
    $count = 0;
	
// Connect and get user id
	include_once("usersavedrecipes.php");
	include_once("phpScripts/connect.php");
	$userID = $_SESSION['id'];
    
// Sort by recipe values
	$categories = array("All", "Appetizers", "Cakes", "Chinese_Foods", "Dessert", "Drinks", "Fish_And_Seafoods", "Japanese_Foods", "Main_Meals", 
					"Meats", "Pasta", "Pies_And_Pastries", "Salad", "Soups", "Special_Filipino_Delicacies", "Vegetables", "Western_Foods");

//Error message
	$msg = NULL;
	$color = "black";

	
//db variables and queries
    $mysqli = $db_connection;
    
//check if task is to remove a recipe
    if(isset($_GET['task']) && $_GET['task'] == 'remove'){

        $recipe_to_remove = $_GET['rID'];
        $delQuery = "DELETE FROM fav_recipes WHERE USERID = $userID AND RECIPEID = $recipe_to_remove";
        $mysqli->query($delQuery);
    } elseif (isset($_GET['task']) && $_GET['task'] == 'add'){  
    //check if task is to add item to shopping list
        $item_to_add = $_GET['ingredient'];
        $not_in_shoppinglist = 0;
        $not_in_pantry = 0;
        
        
        // Check if item exists in main pantry table, if not add into the table
		$check_dbpantry_query = "SELECT * FROM pantry_items WHERE ITEM_NAME = '$item_to_add'";
					        $result = mysqli_query($mysqli, $check_dbpantry_query);
					        $row = mysqli_fetch_row($result);
        					if(!$row){
								$insert_sql = "INSERT INTO pantry_items (ITEM_NAME) VALUES ('$item_to_add')";
								$result = mysqli_query($mysqli, $insert_sql);
    						}
      
        //check item and userid don't exist in shopping list
        //check item isn't already in pantry
        $check_SL_query = "SELECT * FROM `shopping_list` WHERE `USERID` = $userID AND `ITEM_NAME` = '$item_to_add'";
        $result = mysqli_query($mysqli, $check_SL_query);
        $row = mysqli_fetch_row($result);
        if(!$row){
            $not_in_shoppinglist = true;
        } else {
            $errorMsg = "$item_to_add already exist in your shopping list";
        }
        $check_pantry_query = "SELECT * FROM `vw_user_pantry_desc` WHERE `userID` = $userID AND `item_name` = '$item_to_add'";
        $result = mysqli_query($mysqli, $check_pantry_query);
        $row = mysqli_fetch_row($result);
        if(!$row){
            $not_in_pantry = true;
        } else {
            $errorMsg = "$item_to_add already exist in your pantry";
        }
        //store item in shopping list
        if($not_in_shoppinglist && $not_in_pantry) {
            
			$getid_pantry_query = "SELECT ID FROM pantry_items where ITEM_NAME = '$item_to_add'";
			$result = mysqli_query($mysqli, $getid_pantry_query); 
			$row = mysqli_fetch_row($result);
			$tempID = $row[0];
			
            $insert_sql = "INSERT INTO `shopping_list`(`USERID`, `ITEMID`, `ITEM_NAME`) VALUES ('$userID', '$tempID', '$item_to_add')";
            $result = mysqli_query($mysqli, $insert_sql);
            $successMsg = "$item_to_add added successfully to the shopping list";

        }
    } elseif (isset($_GET['task']) && $_GET['task'] == 'next'){
        $index = $_GET['index'] + $pageCount;
        $count = $index;
    } elseif (isset($_GET['task']) && $_GET['task'] == 'back'){
        $index = $_GET['index'] - $pageCount;
        $count = $index;
    } 
    //query for geting favorted recipess
        $query =    "SELECT fr.RECIPEID, r.title, r.category, r.ingredients, r.procedures, r.notes 
                    FROM `fav_recipes` as fr join recipes as r 
                    on fr.RECIPEID = r.id 
                    WHERE USERID = $userID
                    LIMIT $index, $pageCount";
        $result = $mysqli->query($query); 
    //for getting total count of user saved recipes
        $queryCount = mysqli_query($mysqli, "SELECT COUNT(*) as count FROM `fav_recipes` WHERE `USERID` = $userID");
		$countResults = mysqli_fetch_assoc($queryCount);
		$totalCount = $countResults['count'];
        
        

    
//main body of the page
    while(list($id, $title, $category, $ingredients, $procedures, $notes) = $result->fetch_row()){
    //for seeing size of divs 
    //style='border: thin solid black' border='1'
        $count++;
        $title = str_replace("'", '`', $title);
        $cleanIngredients = str_replace("\n", ' ', $ingredients);
        $cleanIngredients = str_replace("\r", ' ', $cleanIngredients);
        echo utf8_encode(
            "
            <div class='invisible'>.</div>
            <div class='row'>
                <div class='recipe col-sm-offset-2 col-md-offset-2 col-sm-8  col-md-8'>
                    <div>
                        
                        <div>
                            <b>$title 
                            <br> Category:</b> $category 
                            <br><img src='imagerecipes/$id.jpg' height='150' width:150px/><br>
                        </div>
                        <div class='divButtons'>
    
                            <button id='$id details_btn' type='button' class='btn btn-default btn-sm' onclick=\"toggleShow($id)\">Details</button>
                            <button type='button' class='btn btn-default btn-sm' onclick=\"getModal($id, '$title', '$id ingredient')\">Check Ingredients</button>
                            <button type='button' class='btn btn-default btn-sm' onclick=\"confirmRemove($id, '$title')\">Remove Recipe</button>
    
                        </div>
                        
                    </div>
                    <div>
                        <div id=\"$id details\" class='hidden'>
            
                            
                            
                            <b>Ingredients</b>
                            <pre id='$id ingredient'>$ingredients </pre>
                            
                            <br> <b>Procedure</b>
                            <pre>$procedures</pre>");
                            
                            if($notes != ""){
                                echo utf8_encode("<br><b> Notes</b>
                                                    <br><pre>$notes </pre>");
                            }
                echo "
                        </div>
                    </div>
                </div>
            </div>";
    }
    
    ?>

    <div class="row nav-btns">
        <div class="col-sm-offset-2 col-sm-8">
            <button id="back" type="button" class="btn btn-default btn-sm back-btn" onclick="back()">Back</button>
            <button id="next" type="button" class="btn btn-default btn-sm next-btn" onclick="next()">Next</button>
        </div>
    </div>