<?php
	$pgm = "pantrylist.php";
	
	include_once("usersdisplay.php");
	$userID = $_SESSION['id'];

	if (isset($_GET['task']))	{$task = $_GET['task'];}
		elseif (isset($_POST['task'])) {$task = $_POST['task'];}
			else {$task = NULL;}

	$msg = NULL;
	$color = "black";

	if (($task == "Add")) {
		if (isset($_POST['ingredientAdd']))	$ingredientAdd = $_POST['ingredientAdd'];
		if (isset($_POST['quantityAdd']))	$quantityAdd = $_POST['quantityAdd'];

		if ($ingredientAdd == NULL)	{
			$msg = "Ingredient is missing";
		}
		if ($quantityAdd == NULL) {
			$msg = "Quantity is missing";
		}
		if ($ingredientAdd == NULL AND $quantityAdd == NULL) {
			$msg = "Both ingredient and quantity are missing";
		}
	}
	if ($msg != NULL)		$task = "Error";

	/*kevin if you include connect.php here it should do all this for you
    $host = "127.0.0.1";
    $user = "luiscard91";
    $pass = "";
    $db = "tender_db"; 
    $port = 3306;
	$mysqli = new mysqli($host, $user, $pass, $db, $port);
	*/
	
	//actually since userdisplay includes connect.php
	//you dont even need this
	//include_once("phpScripts/connect.php");
	
	
	$mysqli = $db_connection;	
	
	

	switch($task) {
		case "Increase":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['quantity']))		$quantity = $_GET['quantity'];
							if (isset($_GET['userPantryTableID']))		$userPantryTableID = $_GET['userPantryTableID'];
							$query = "UPDATE user_pantry SET
								QTY_ON_HAND = ($quantity + 1)
								WHERE ID = '$userPantryTableID'";
							$result = $mysqli->query($query);
							break;
		case "Decrease":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['quantity']))		$quantity = $_GET['quantity'];
							if (isset($_GET['userPantryTableID']))		$userPantryTableID = $_GET['userPantryTableID'];
							if ($quantity == 1){ 
							?>
							
							<script type="text/javascript">
								var ingredient = "<?php echo $ingredient; ?>";
								document.getElementById("msg").textContent = ingredient + " quantity at zero, added to shopping list";
									/*<?php
									$query = "DELETE FROM user_pantry WHERE ID = '$userPantryTableID'";
									$mysqli->query($query);
									$query = "INSERT INTO `shopping_list`(`USERID`, `ITEM_NAME`) VALUES ($userID, '$ingredient')";
									$mysqli->query($query);
									?>*/
									
							</script>
							
							<?php
							}
							else if ($quantity < 1) {
							
							}
							else {
							$query = "UPDATE user_pantry SET
								QTY_ON_HAND = ($quantity - 1)
								WHERE ID = '$userPantryTableID'";
							$result = $mysqli->query($query);
							}
							break;
		case "Add":
							if (isset($_POST['ingredientAdd']))	$ingredientAdd = $_POST['ingredientAdd'];
							if (isset($_POST['quantityAdd']))	$quantityAdd = $_POST['quantityAdd'];
							$sCheck = $ingredientAdd . "s";
							$checkIngredient = $mysqli->query("SELECT a.ITEM_NAME FROM pantry_items a JOIN user_pantry b ON a.ID = b.ITEM_ID WHERE ITEM_NAME = '$ingredientAdd' OR ITEM_NAME = '$sCheck' AND b.USERID = '$userID'");
							if ($checkIngredient->num_rows == 0) {
							$query = "INSERT INTO pantry_items (ITEM_NAME) VALUES
								('$ingredientAdd')";
							$result = $mysqli->query($query);
							$query1 = "SELECT ID FROM pantry_items
									WHERE ITEM_NAME = '$ingredientAdd'";
							$result1 = $mysqli->query($query1);
							$newItemID = $result1->fetch_assoc();
							$newItemIDS = $newItemID["ID"];
							$query2 = "INSERT INTO user_pantry (ITEM_ID, USERID, QTY_ON_HAND) VALUES
									($newItemIDS, $userID, $quantityAdd)";
							$result2 = $mysqli->query($query2); 
							
							//user feedback saying ingredient has been added to db
							echo "
								<script>
										document.getElementById('msg').className += \" success\";
								        document.getElementById('msg').textContent = '\"$ingredientAdd\" has been added!';
								</script>
								";}
							else {
								echo "
									<script>
								        document.getElementById('msg').className += \" fail\";
								    	document.getElementById('msg').textContent = '\"$ingredientAdd\" already exists in your pantry!';
								    </script>
									";
								
							}
							break;
		case "Delete":
							if (isset($_GET['r']))				$rowid = $_GET['r'];
							if (isset($_GET['ingredient']))		$ingredient = $_GET['ingredient'];
							if (isset($_GET['userPantryTableID']))		$userPantryTableID = $_GET['userPantryTableID'];
							$query = "DELETE FROM user_pantry WHERE ID = '$userPantryTableID'";
							$result = $mysqli->query($query);
							if ($query) {
								echo "<script>
									document.getElementById('msg').textContent = '\"$ingredient\" has been deleted from your pantry!';
								</script>";
							}
							break;
		case "Error": $color = "red"; break;
		default:	break;
		}

	$query = "SELECT a.ID, a.ITEM_NAME, b.QTY_ON_HAND, b.ID
			FROM pantry_items a JOIN user_pantry b ON a.ID = b.ITEM_ID
			JOIN users c ON b.USERID = c.ID
			WHERE c.ID = $userID
			ORDER BY a.ITEM_NAME";
	$result = $mysqli->query($query);


	
	echo"
		<div class=\"container\">
		<div class=\"row\">
		<div class=\"col-md-offset-2 col-md-8\">
		<div class=\"pre-scrollable user-pantry \">
		<table class=\"table\" >
		<tr>
		<th width='15%' align='left'>Ingredient</th>
		<th width='15%' align='left'>Quantity</th>
		<th width='1%'>&nbsp;</th>
		<th width='1%'>&nbsp;</th>
		<th width='1%'>&nbsp;</th>
		</tr>";

	while(list($rowid, $ingredient, $quantity, $userPantryTableID) = $result->fetch_row()) {
    echo "<tr>
		  <td>$ingredient</td>
		  <td>$quantity</td>
		  <td><a href='pantrylist.php?r=$rowid&task=Increase&ingredient=$ingredient&quantity=$quantity&userPantryTableID=$userPantryTableID'><button class='btn btn-default'><img src='btnimages/increase.png' height='10' width='10'/></button></a></td>
		  <td><a href='pantrylist.php?r=$rowid&task=Decrease&ingredient=$ingredient&quantity=$quantity&userPantryTableID=$userPantryTableID'><button class='btn btn-default'><img src='btnimages/decrease.png' height='2' width='10'/></button></a></td>
		  <td><a href='pantrylist.php?r=$rowid&task=Delete&ingredient=$ingredient&quantity=$quantity&userPantryTableID=$userPantryTableID'><button class='btn btn-default'><img src='btnimages/remove.png' height='10' width='10'/></button></a></td>
		  </tr>";
	}

	echo "</table></div></div></div><div><table width='1024' align='center'>
		  <br></br>
		  <tr><td width='20%'><b>Add Ingredient</b><td></tr>";

	echo "<form action='$pgm' method='post'>
		  <table width='1024' align='center'>
		  <tr><td width='5%'>Ingredient&nbsp;&nbsp;</td><td width='20%'><input type='text' name='ingredientAdd' 	value='$ingredient'    size='15'></td>
		  <td width='5%'>Quantity&nbsp;&nbsp;</td><td width='10%'><input type='text' name='quantityAdd' 		value='$quantity'      size='4'></td>
		  <td><input class='btn btn-default btn-sm' type='submit' name='task' value='Add'></td></tr></table></form>
		  <table width='1024' align='center'>
		  <br></br>
		  <tr><td width='10%'></td><td width='90%'><font color='$color'><strong>$msg</strong></font></td></tr></table>";
	
	/*	  
	echo "<form action='index.php' align = 'center'>
    	 <input type='submit' value = 'Logout'/>
		 </form>"
		 */
?>
