<?php $query = "SELECT a.ID, a.ITEM_NAME, b.QTY_ON_HAND, b.ID
                			FROM pantry_items a JOIN user_pantry b ON a.ID = b.ITEM_ID
                			JOIN users c ON b.USERID = c.ID
                			WHERE c.ID = $userID
                			ORDER BY a.ITEM_NAME";
                			
                	    $result = $mysqli->query($query);
                        
                        echo"<div class=\"pre-scrollable \">
                    		<table class=\"table\"  align='center'>
                    		<tr>
                    		<th align='left'>Ingredient</th>
                    		<th align='left'>Quantity</th>
                    		</tr>";
                    
                    	while(list($rowid, $ingredient, $quantity, $userPantryTableID) = $result->fetch_row()) {
                        echo "<tr>
                    		  <td>$ingredient</td>
                    		  <td>$quantity</td>
                    		  </tr>";
                    	}
                    
                    	echo "</table></div>";
                        
?>