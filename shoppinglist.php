<?php

	$pgm = "shoppinglist.php";
	
	include_once("usersshoppinglist.php");
	$userID = $_SESSION['id'];

	if (isset($_GET['task']))	{$task = $_GET['task'];}
		elseif (isset($_POST['task'])) {$task = $_POST['task'];}
			else {$task = NULL;}

	$msg = NULL;
	$color = "black";
	
	$mysqli = $db_connection;
	
	if (($task == "Add")) {
		if (isset($_POST['ingredientAdd']))	$ingredientAdd = $_POST['ingredientAdd'];

		if ($ingredientAdd == NULL)	{
			$msg = "Ingredient is missing";
		}
	}
	if ($msg != NULL)		$task = "Error";
	
	switch($task) {
		case "Increase":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['quantity']))		$quantity = $_GET['quantity'];
							$query = "UPDATE shopping_list SET
								QTY = ($quantity + 1)
								WHERE ITEMID = '$rowid'";
							$result = $mysqli->query($query);
							break;
		case "Decrease":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['quantity']))		$quantity = $_GET['quantity'];
							if ($quantity < 1) {
								
							}
							else {
							$query = "UPDATE shopping_list SET
								QTY = ($quantity -1 )
								WHERE ITEMID = '$rowid'";
							$result = $mysqli->query($query);
							}
							break;
		case "Add":
							if (isset($_POST['ingredientAdd']))	$ingredientAdd = $_POST['ingredientAdd'];
					        $check_dbpantry_query = "SELECT ITEM_NAME FROM pantry_items WHERE ITEM_NAME = '$ingredientAdd'";
					        $result = mysqli_query($mysqli, $check_dbpantry_query);
					        $row = mysqli_fetch_row($result);
        					if(!$row){
								$insert_sql = "INSERT INTO pantry_items (ITEM_NAME) VALUES ('$ingredientAdd')";
								$result = mysqli_query($mysqli, $insert_sql);
    						}
							$checkIngredient = $mysqli->query("SELECT ITEM_NAME FROM shopping_list WHERE ITEM_NAME = '$ingredientAdd' AND USERID = '$userID'");

							if ($checkIngredient->num_rows == 0) {
							$query = "INSERT INTO shopping_list (ITEM_NAME, USERID) VALUES
								('$ingredientAdd', '$userID')";
							$result = $mysqli->query($query);
							
							echo "<script>
										document.getElementById('msg').className += \" success\";
								        document.getElementById('msg').textContent = '\"$ingredientAdd\" has been added!';
								</script>";}
							else {
								echo "<script>
								        document.getElementById('msg').className += \" fail\";
								    	document.getElementById('msg').textContent = '\"$ingredientAdd\" already exists in your Shopping List!!';
								    </script>";
							}
							break;
		case "AddAllToPantry":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['quantity']))		$quantity = $_GET['quantity'];
					        $check_dbpantry_query = "SELECT * FROM pantry_items WHERE ITEM_NAME = '$ingredient'";
					        $result = mysqli_query($mysqli, $check_dbpantry_query);
					        $row = mysqli_fetch_row($result);
        					if(!$row){
								$insert_sql = "INSERT INTO pantry_items (ITEM_NAME) VALUES ('$ingredientAdd')";
								$result = mysqli_query($mysqli, $insert_sql);
    						}
					        $check_vwpantry_query = "SELECT * FROM vw_user_pantry_desc WHERE userID = $userID AND item_name = '$ingredient'";
					        $result = mysqli_query($mysqli, $check_vwpantry_query);
					        $row = mysqli_fetch_row($result);
					        if(!$row){
					            $not_in_vwpantry = true;
					        } else {
					        }
							
							if ($quantity != 0) {
								$getid_pantry_query = "SELECT ID FROM pantry_items where ITEM_NAME = '$ingredient'";
								$result = mysqli_query($mysqli, $getid_pantry_query); 
								$row = mysqli_fetch_row($result);
								$tempID = $row[0];
								
								if ($not_in_vwpantry) {
									$insert_pantry_query = "INSERT INTO user_pantry (ITEM_ID, QTY_ON_HAND, USERID) VALUES
										('$tempID', '$quantity', '$userID')";
									$result = $mysqli->query($insert_pantry_query);
									
									$delete_pantry_query = "DELETE FROM shopping_list WHERE ITEMID = '$rowid'";
									$result = $mysqli->query($delete_pantry_query);
									
									if ($insert_pantry_query) {
										echo "
										<script>
												document.getElementById('msg').className += \" success\";
										        document.getElementById('msg').textContent = 'Purchased ingredient \"$ingredient\" was added to your pantry!';
										</script>";
									}
								} else {
									$getqty_pantry_query = "SELECT QTY_ON_HAND FROM user_pantry where ITEM_ID = '$tempID' AND USERID = '$userID'";
									$result = mysqli_query($mysqli, $getqty_pantry_query); 
									$row = mysqli_fetch_row($result);
									$tempQTY = $row[0];

									$update_pantry_query = "UPDATE user_pantry SET QTY_ON_HAND = ($tempQTY + $quantity)
										WHERE ITEM_ID = '$tempID' AND USERID = '$userID'";
									$result = $mysqli->query($update_pantry_query);
									
									$delete_pantry_query = "DELETE FROM shopping_list WHERE ITEMID = '$rowid'";
									$result = $mysqli->query($delete_pantry_query);
									
									if ($update_pantry_query) {
										echo "<script>
												document.getElementById('msg').className += \" success\";
										        document.getElementById('msg').textContent = 'Purchased ingredient \"$ingredient\" was added to your pantry!';
										</script>";
									}
								}
							} else {
								echo "
								<script>
										document.getElementById('msg').className += \" fail\";
								        document.getElementById('msg').textContent = 'No quantity selected for \"$ingredient\"';
								</script>";
							}
							
							break;
		case "Delete":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							$query = "DELETE FROM shopping_list WHERE ITEMID = '$rowid'";
							$result = $mysqli->query($query);
							if ($query) {
								echo "
								<script>
										document.getElementById('msg').className += \" success\";
								        document.getElementById('msg').textContent = '\"$ingredient\" has been deleted from your shopping list!';
								</script>";
							}
							break;
		case "Error": $color = "red"; break;
		default:	break;
		}

	$query = "SELECT ITEMID, ITEM_NAME, QTY
			FROM shopping_list
			WHERE USERID = $userID
			ORDER BY ITEM_NAME";
	$result = $mysqli->query($query);

	
		
	echo"
		
		<div class=\"container\">
		<div class=\"row\">
		<div class=\"col-md-offset-2 col-md-8\">
		<div class=\"user-pantry pre-scrollable\">
		<table class=\"table\"  align='center'>
		
		<tr>
		<th width='15%' align='left'>Ingredient</th>
		<th width='15%' align='left'>Quantity</th>
		<th width='3%'>&nbsp;</th>
		<th width='3%'>&nbsp;</th>
		<th width='5%'>&nbsp;</th>
		<th width='5%'>&nbsp;</th>
		</tr>";

	while(list($rowid, $ingredient, $quantity) = $result->fetch_row()) {
    echo "<tr>
		  <td>$ingredient</td>
		  <td>$quantity</td>
		  <td><a href='shoppinglist.php?r=$rowid&task=Increase&ingredient=$ingredient&quantity=$quantity'><button class='btn btn-default'><img src='btnimages/increase.png' height='10' width='10'/></button></a></td>
		  <td><a href='shoppinglist.php?r=$rowid&task=Decrease&ingredient=$ingredient&quantity=$quantity'><button class='btn btn-default'><img src='btnimages/decrease.png' height='2' width='10'/></button></a></td>
		  <td><a href='shoppinglist.php?r=$rowid&task=AddAllToPantry&ingredient=$ingredient&quantity=$quantity'><button class='btn btn-default' width='50'>Purchased</button></a></td>
		  <td><a href='shoppinglist.php?r=$rowid&task=Delete&ingredient=$ingredient'><button class='btn btn-default'><img src='btnimages/remove.png' height='10' width='10'/></button></a></td>
		  </tr>";
	}
	
	echo "</table></div></div></div></div><table width='1024' align='center'>
		  <br></br>
		  <tr><td width='30%'><b>Add Ingredient</b></td></tr>";

	echo "<form action='$pgm' method='post'>
		  <table width='1024' align='center'>
		  <tr><td width='5%'>Ingredient&nbsp;&nbsp;</td><td width='20%'><input type='text' name='ingredientAdd' 	value='$ingredient'    size='15'></td>
		  <td><input class='btn btn-default btn-sm' type='submit' name='task' value='Add'></td></tr></table></form>
		  <table width='1024' align='center'>
		  <br></br>
		  <tr><td width='10%'></td><td width='90%'><font color='$color'><strong>$msg</strong></font></td></tr></table>";
?>
