
<html>

    <style>
      .signup {
        border: 1px solid #999999;
      font:   normal 14px helvetica; color:#444444;
      }
    </style>
    <head>
        <meta charset="UTF-8">
        <title>login</title>
    </head>
    <body  >
            <?php
            ob_start();
   
            session_start();



// points to server
$serverName = "127.0.0.1\tender_db"; //serverName\instanceName

//credentials

$servername = "127.0.0.1";
$database = "tender_db";
$username = "luiscard91";
$password = " ";
$error=" ";

// used pdo because mysqli wouldnt work
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tender_db', 'harry', 'baron92');

// subits the infrmation
if (isset($_POST['submit'])){
$username = $_POST['Username'];
$password = $_POST['Password'];
$sql = $pdo->query( "SELECT password FROM signup Where username='$username'");
$row = $sql->fetch(PDO::FETCH_ASSOC);
$temp=$row['password'];

// checks password
if($temp==$password)
    {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $username;
        header("Location: home.php");
    }
    else 
    {
    $error = "You have entered a incorrect password or username";
    }
}
?>
<!--
syle for html login
-->
        <div><p style="font-size:400%;font-weight: bold;padding-top: 50px;padding-left: 120px">Login<p>
        <form method="post" action="login.php" onsubmit="return validate(this)">
        <input  type="text" name="Username" placeholder=" Username" style="width:120px;height:30px;color:grey;font-weight: bold;text-align: center;position:relative;top:-140px;left:300px"><br>
        <br> <input method="post" type="text" name="Password" placeholder=" Password" style="width:120px;height:30px;color:grey;font-weight: bold;text-align: center;position:relative;top:-140px;left:300px">
        <span class="errorMsg" style='position: relative; top:-105px;left:100px;color:red;font-weight:bolder' id="validation">
        <?php echo $error;?></span><br><button style='position: relative; top:-100px;left:350px' type="submit" value="login" name="submit">login</button></form></div>
        <center><a href='adduser.php'>New User Sign Up Here</a></center><br>
        

    </body>
</html>