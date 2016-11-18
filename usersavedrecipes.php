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
        
        
        <link href="css/savedrecipe.css" rel="stylesheet">
        
            
</head>

<body>
    
    <div class="container-fluid">
    
    
    <!--session_check.php includes:
        $userID, $username, $now as current time, $session_valid -->
    
    <center><b><u>Saved Recipes</u></b></center><br><br>
    <?php
    include("objects/nav_savedrecipe.php");
        include_once("phpScripts/session_check.php");
        //tests if valid session and displays user info
        if ($session_valid){
            echo"<span id='msg'></span>";
            include_once("savedrecipes.php");
            //include('logout_btn.php');
        }
    ?> 
    </div>
    
    
    <!-- The Modal -->
    <div id="myModal" class="modal">
    
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times</span>
                <h2 id="recipeTitle">Modal Header</h2>
            </div>
            <div class="modal-body">
                <div id='leftColumn' class='col-sm-4  col-md-4 col-xs-4'>
                    <h3>Ingredients</h3>
                    <pre id="ingredients"></pre>
                </div>
                
                <div id='middleColumn' class='col-sm-4  col-md-4 col-xs-4'>
                    <h3>Pantry</h3>
                    <?php include("phpScripts/modal_userpantry.php") ?>
                </div>
                
                <div id='rightColumn' class='col-sm-4  col-md-4 col-xs-4'>
                    <h3>Add to shopping list</h3>
                    <form id="addItem_Form" name="addItem_Form">
                        <div class="form-group">
                        <label class="control-label">Ingredient To Add</label>
                            <input type="text" name="ingredient" id="add_ingredient_txtbox" class="form-control">
                            <button type="button" id="add_ingredient_btn" class="btn btn-default" onclick="addIngredient()">Add</button>
                            <span id="errorMsg"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer col-sm-12  col-md-12 col-xs-12">
                <h3>Modal Footer</h3>
            </div>
        </div>
    
    </div>
    
</body>
<script>
    //fix this at some point
    var errorMsg = "<?php echo"$errorMsg" ?>";
    var successMsg = "<?php echo"$successMsg"?>";
    
    if( errorMsg != ""){
        document.getElementById("msg").textContent = errorMsg;
    }
    
    if(successMsg != ""){
        document.getElementById("msg").textContent = successMsg;
    }
    //end the fix
    
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
    function confirmRemove(id, recipe){
        if(confirm("Are you sure you want to remove " + recipe + "?") == true){
            window.location.assign("usersavedrecipes.php?task=remove&rID="+id);
            
        }
    }
    

    
//modal stuff
    // Get the modal
    var modal = document.getElementById('myModal');
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    

    
    function getModal(id, title, ingredients){
        modal.style.display = "block";
        
        document.getElementById("recipeTitle").textContent = title;
        document.getElementById("ingredients").innerHTML = document.getElementById(ingredients).innerHTML;
        
   
        
            // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
            
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
                
            }
        }
    }
    
//Add item
    function addIngredient(){
        var itemToAdd = document.forms["addItem_Form"]["ingredient"].value;
        var addTextBox = document.getElementById("add_ingredient_txtbox");
        var errorMsg = document.getElementById("errorMsg");
        
        if(itemToAdd == ""){
            addTextBox.className += " errorAdd";
            errorMsg.textContent = "Enter an ingredient";
        }
        else {
            window.location.assign("usersavedrecipes.php?ingredient=" + itemToAdd + "&task=add")
            addTextBox.className += "form-control";
            errorMsg.textContent = "";
            
        }
    }
    
</script>
</html>