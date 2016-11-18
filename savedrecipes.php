<?php
/* 
TO DO:

    display only a certain amount recpies at a time

*/


// Program name variable
	$pgm = "savedrecipes.php";
	
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
            
            $insert_sql = "INSERT INTO `shopping_list`(`USERID`, `ITEM_NAME`) VALUES ('$userID', '$item_to_add')";
            $result = mysqli_query($mysqli, $insert_sql);
            $successMsg = "$item_to_add added successfully to the shopping list";

        }
    }



    
//query for geting favorted recipess
    $query =    "SELECT fr.RECIPEID, r.title, r.category, r.ingredients, r.procedures, r.notes 
                FROM `fav_recipes` as fr join recipes as r 
                on fr.RECIPEID = r.id 
                WHERE USERID = $userID";
      
    //print the query, for testing          
    //echo "<br> $query <br>";
                
    $result = $mysqli->query($query); 
    
//main body of the page
    while(list($id, $title, $category, $ingredients, $procedures, $notes) = $result->fetch_row()){
    //for seeing size of divs 
    //style='border: thin solid black' border='1'
    
        $title = str_replace("'", '`', $title);
        $cleanIngredients = str_replace("\n", ' ', $ingredients);
        $cleanIngredients = str_replace("\r", ' ', $cleanIngredients);
        echo utf8_encode(
            "
            <div class='invisible'>.</div>
            <div class='recipe col-sm-offset-2 col-md-offset-2 col-sm-8  col-md-8'>
                <div>
                    
                    <div >
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
            echo "<br>
            </div></div></div>
            <hr class='myHR invisible'>";
            
    }
    
