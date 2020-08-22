<?php
require_once 'db.php'; //database connectss
$error=false;
if(!(mysqli_query($con, "SELECT * FROM users")))
{$sql="CREATE TABLE users
    (id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(256),email VARCHAR(256),pass VARCHAR(256))";
mysqli_query($con, $sql);
$sql="CREATE TABLE cinema_select
    (id INT(11) AUTO_INCREMENT PRIMARY KEY,
    seat_selected VARCHAR(256))";
mysqli_query($con, $sql);
$sql="CREATE TABLE cinemaAndMovie_select
    (id INT(11) AUTO_INCREMENT PRIMARY KEY,
    selected VARCHAR(256))";
mysqli_query($con, $sql);
}
if(isset($_POST['register_btn'])){    
    $username=mysqli_real_escape_string($con,$_POST['username']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    $confirm_pass=mysqli_real_escape_string($con,$_POST['confirm_pass']);
    //check if username email and pass text not empty
    if(empty($username)){$error=true; echo "Username is required";}
    if(empty($email)){$error=true; echo "Email  is required";}
    if(empty($password)){$error=true; echo "Password  is required";}
    //check if pass container 6 num or more
    if(strlen($password)<5){$error=true; echo "Password required 6 num or more";}
    $sql="SELECT * FROM users";
    $result=mysqli_query($con, $sql);
    while($row=mysqli_fetch_array($result)){
        //check if username alrady exist
          if($row['username']==$username&&!($error)){
              $error=true; 
              echo "Username is alrady exist";
        }
    }   
    if($password==$confirm_pass&& !($error)){  //password confirm create user
      //  $password=md5($password); //Secures the password
        //adding table user new acount
        $sql="INSERT INTO users(username,email,pass) VALUES('$username','$email','$password')";//add user
        mysqli_query($con, $sql);
        header("location:HomePage.php");
    }
 }
 //close mysql
 mysqli_close($con);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Register </title>
<link rel="stylesheet" type="text/css" href="main.css">
<body>
	<form action="SingUp.php" method="post">
	<table id="table">
	<tr>
		<td>UserName:</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><input type="email" name="email"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td>Confirm Password:</td>
		<td><input type="password" name="confirm_pass"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="register_btn" value="Register"></td>
	</tr>
	
	</table>
	</form> 
</body>
</html>
