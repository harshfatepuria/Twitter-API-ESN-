<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>REGISTER</title>
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
</head>




<?php
$pageid=4;
session_start();
if(isset($_SESSION["username"]))
{
	header("Location: user_home.php");
}

$username=$password="";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	
	if(isset($_POST["rpassword"]))
	{
		//REQUEST FROM REGISTER FORM
		
		$name=$_POST["name"];
		$username=$_POST["username"];
		$password=$_POST["password"];
		$rpassword=$_POST["rpassword"];
		
		if(strcmp($username,"")==0 || strcmp($password,"")==0 || strcmp($rpassword,"")==0 || strcmp($name,"")==0)
		{
			echo '<script>
			alert("Please fill up all fields!");</script>';
		}
		else if(strcmp($password,$rpassword)!=0)
		{
			echo '<script>
			alert("Passwords do not match!");</script>';
		}
		else
		{
			$arr=array("@"=>"");
			$username=strtr($username,$arr);
			
			
			$con=mysqli_connect("localhost","root","","chat");
			$query="SELECT * FROM user WHERE username ='$username'";
			if(!mysqli_query($con,$query))
			{
				echo '<script>
				alert("ERROR!! Please try later.");</script>';
   			}
   			else
   			{
   				$result=mysqli_query($con,$query);
   				$num_rows=mysqli_num_rows($result);
   				if($num_rows!=0)
   				{
   					echo '<script>
   					alert("Username already taken! Please choose another.");</script>';
   				}
   				else
   				{
   					//HASHING PASSWORD FOR SECURITY.
		
   					$salt="$2a$";
   					$hash=md5($salt.$password);


   					$query="INSERT INTO user VALUES('$name','$username','$hash')";
   					mysqli_query($con,$query);
   					header("Location: index.php");
   					echo '<script>
   					alert("You have successfully registered. Thank you.");</script>';

        		}
   			}
   			mysqli_close($con);
   		}	
	}
	else
	{
		//REQUEST FROM LOGIN FORM
		
		
		$username = $_POST["username"];
		$password = $_POST["password"];


		//HASHING PASSWORD.
		$salt="$2a$";
		$hash=md5($salt.$password);


		//SETTING UP CONNECTION
		$con=mysqli_connect("localhost","root","","chat");

		$query="SELECT * FROM user WHERE username ='$username' and password ='$hash'";
		if(!mysqli_query($con,$query))
		{
			echo '<script>
			alert("ERROR!! Please try later.");
			</script>';
   		}
   		else
   		{
   			$result=mysqli_query($con,$query);
   			$num_rows=mysqli_num_rows($result);

   			//IF USERNAME AND PASSWORD ARE NOT PRESENT IN THE DATABASE.
   			if($num_rows==0)
   			{
   				echo '<script>
   				alert("Invalid id/password!");
   				</script>';
			}
			else
			{

				//SETTING UP SESSION.
				session_start();
				$_SESSION['username']=$username;
				$_SESSION['pageid']=$pageid;
				header("Location: user_home.php");  //REDIRECTING USER TO HIS HOME PAGE.
			}
   		}
   		mysqli_close($con);
   	}
}
?>




<body>
	
	
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="index.php"><span>$chat</span></a></h1>
		<!--<p>Designed By Decepticons</p>-->
		
		<div class="signin" align="left">
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
				<table class="credential">
				<tr>
				<td><label for="username">Username:</label></td>
				<td><input class="username" name="username"></td>
				</tr>
				<tr>
				<td><label for="password">Password:</label></td>
				<td><input class="password" name="password" type="password"></td>
				</tr>
				</table>
				<div class="credential">
				<input class="submit" value="LOGIN" type="submit">
				<input class="submit" value="RESET" type="reset">
				</div>
			</form>
		</div>
		
	</div>
	<div id="menu">
		<ul id="main">
			<li><a href="index.php">Home</a></li>
			<li><a href="search_post.php">Search Posts</a></li>
			<li><a href="about_us.php">About Us</a></li>
		</ul>
	</div>
</div>
<!-- end header -->




<div id="wrapper">
	<!-- start page -->
	<div id="page">
			
		
		<!-- start content -->
		<div id="content">
			
			<div class="post">
			<div class="entry">
					
			<p>Please fill in these details to register yourself: (All fields are mandatory to fill)</p>
			<div class="register" align="left">
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
				<table class="credential">
				<tr>
				<td><label for="name">Name</label></td>
				<td><input class="name" name="name" size="25" autofocus maxlength="40"></td>
				</tr>
				<tr>
				<td><label for="username">Username</label></td>
				<td><input class="username" name="username" size="25" maxlength="40"></td>
				</tr>
				<tr>
				<td><label for="password">Password</label></td>
				<td><input class="password" name="password" size="25" type=password maxlength="40"></td>
				</tr>
				<tr>
				<td><label for="rpassword">Retype Password</label></td>
				<td><input class="rpassword" name="rpassword" size="25" type=password maxlength="40"></td>
				</tr>
				</table>
				<div>
				<input class="submit" value="SUBMIT" type="submit">
				<input class="submit" value="RESET" type="reset">
				</div>
			</form>
			</div>
		    </div>
			</div>
		</div>
		<!-- end content -->
		
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>





<div id="footer">
	<p class="copyright">Designed by Decepticons</p>
</div>


</body>
</html>
