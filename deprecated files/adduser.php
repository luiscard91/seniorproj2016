<?php // adduser.php
// Project Part 1
// Author: Eugenia Gioles
// Date:  4/17/2016


require_once 'login.php';
$connection = new mysqli($hn,$un,$pw,$db);

$first = ' ';
$last = ' ';
$user = ' ';
$pass = ' ';
$out = ' ';


  if (isset($_POST['first'])) $first = sanitizeString($_POST['first']);  
  if (isset($_POST['last'])) $last = sanitizeString($_POST['last']);
  if (isset($_POST['bdate'])) $bdate = date('Y-m-d', strtotime($_POST['bdate'])) ;
  if (isset($_POST['user'])) $user = sanitizeString($_POST['user']);
  if (isset($_POST['pass'])) $pass = sanitizeString($_POST['pass']);
  if (isset($_POST['email'])) $email = sanitizeString($_POST['email']);

    
  $salt1 = "e@g1";
  $token = hash('ripemd128',"$salt1$pass");
       
  add_user($connection,$first,$last,$bdate,$user,$token,$email);
  

  echo <<<_END
<html>
  <head>
    <title>User Entry</title>
  </head>
  <body>
    <pre>
    Add a New User        
   
    <form method="post" action="adduser.php">
	First Name <input type="text" name="first"  required "required">
	 Last Name <input type="text" name="last"  required "required">
	 Birthdate <input type="date" name="bdate"  required "required">	
	  Username <input type="text" name="user"  required "required">
	  Password <input type="text" name="pass"  required "required">
     Email address <input type="text" name="email" required "required">	
<b></b>	
			<input type="submit" value="AddUser">
			
		
 </form>
    </pre>
  </body>
</html>
_END;

$connection->close();

  function sanitizeString($var)
  {
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
  }
  function add_user($connection,$fn,$ln,$bd,$usr,$tkn,$em)
  {
    $query = "INSERT INTO users VALUES( '$fn','$ln','$bd','$usr','$tkn','$em')";
	$result = $connection->query($query);
	if (!result) die($connection->error);
	//else echo " Record inserted ";
  }
?>