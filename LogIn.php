<?php
require_once 'db.php'; //database connectss
if(isset($_POST['sing_up'])){
    header("location:SingUp.php");
}
if(isset($_POST['log_in'])){
    $username=mysqli_real_escape_string($con,$_POST['username']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    if(empty($username)){$error=true; echo "Username is required<br>";}
    if(empty($password)){$error=true; echo "Password  is required";}
    $sql="SELECT * FROM users";
    $result=mysqli_query($con, $sql);
    if($result){
        while($row=mysqli_fetch_array($result)){            
            //check if user name and pass already exists
            if($row['username']==$username && $row['pass']==$password){
                if($username=="master"&& $password=="master")
                    header("location:UpdateHomePage.php");                  
                //go to the home page
                else
                  header("location:HomePage.php");
            }
        }
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
	<form action="LogIn.php" method="post">
	<table id="table">
	<tr>
		<td>UserName:</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="log_in" value="log in"></td>
	</tr>
	<tr>
		<td>craete account: </td>
		<td><input type="submit" name="sing_up" value="Sing Up">
	</tr>
	</table>
	</form> 
</body>
</html>
