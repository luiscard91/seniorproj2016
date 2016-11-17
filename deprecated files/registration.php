<?php // registration.php
// User Registration Script
// Author: Eugenia Gioles
// Date:  10/2/2016

//http://www.html-form-guide.com/php-form/php-registration-form.html
//http://www.w3schools.com/php/php_form_url_email.asp

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
	
	<!--...-->
   <!-- Add a New User       --> 
   <!--
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
  --> 
	<form id='register' action='registration.php' method='post'
    accept-charset='UTF-8'>
		<fieldset >
		<legend>Register</legend>
		<input type='hidden' name='submitted' id='submitted' value='1'/>
		<label >*required fields</label>
		<b></b>	
		<label for='first' >First Name*: </label>
		<input type='text' name='first' id='first' value = 'John' maxlength="50" required 'required' />
		<b></b>	
		<label for='last' >Last Name*: </label>
		<input type='text' name='last' id='last' value = 'Doe' maxlength="50" required 'required' />
		<b></b>	
		<label for='last' >Date of Birth*: </label>
		<input type='date' name='bdate' id='bdate' required 'required' />
		<b></b>	
		<label for='email' >Email Address*:</label>
		<input type='email' name='email' id='email' value = 'jdoe@gmail.com' maxlength="50" required 'required'/> 
		<b></b>	
		<label for='user' >UserName*:</label>
		<input type='text' name='user' id='user' value = 'jdoe123' maxlength="50" required 'required'/> 
		<b></b>	
		<label for='pass' >Password*:</label>
		<input type='pass' name='pass' id='pass' value = '*********' maxlength="50" required 'required' />
		<b></b>	
		<input type='submit' name='Submit' value='Submit' />
		 
		</fieldset>
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
  
  function SendUserConfirmationEmail(&$formvars)
{
    $mailer = new PHPMailer();
     
    $mailer->CharSet = 'utf-8';
     
    $mailer->AddAddress($formvars['email'],$formvars['name']);
     
    $mailer->Subject = "Your registration with ".$this->sitename;
 
    $mailer->From = $this->GetFromAddress();        
     
    $confirmcode = urlencode($this->MakeConfirmationMd5($formvars['email']));
     
    $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
     
    $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
    "Thanks for your registration with ".$this->sitename."\r\n".
    "Please click the link below to confirm your registration.\r\n".
    "$confirm_url\r\n".
    "\r\n".
    "Regards,\r\n".
    "Webmaster\r\n".
    $this->sitename;
 
    if(!$mailer->Send())
    {
        $this->HandleError("Failed sending registration confirmation email.");
        return false;
    }
    return true;
}
?>