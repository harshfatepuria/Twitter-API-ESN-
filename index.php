<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>$CHAT APPLICATION</title>
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
</head>


<?php
$pageid=1;
session_start();
if(isset($_SESSION["username"]))
{
	header("Location: user_home.php");
}

$username=$password="";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
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
mysqli_close($con); //TERMINATING CONNECTION.
}
?>




<body>
	
	
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="#"><span>$chat</span></a></h1>
		<!--<p>Designed By Decepticons</p>-->
		
		<div class="signin" align="left">
			<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
				<table class="credential">
				<tr>
				<td><label for="username">Username:</label></td>
				<td><input class="username" name="username" required="required" maxlength="40"></td>
				</tr>
				<tr>
				<td><label for="password">Password:</label></td>
				<td><input class="password" name="password" type="password" required="required" maxlength="40"></td>
				</tr>
				</table>
				<div class="credential">
				<input value="LOGIN" type="submit">
				<input value="RESET" type="reset">
				<a href="register.php">REGISTER</a>
				</div>
			</form>
		</div>
		
	</div>
	<div id="menu">
		<ul id="main">
			<li class="current_page_item"><a>Home</a></li>
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
				<h1 class="title">Welcome to $chat!</h1>
				<p class="byline"></p>
				<div class="entry">
					
					<p>It is a new chat system in which you can login and post your views, create groups, fetch posts based on the $ tag.</p>
					<p>You can write words beginning with $ sign to indicate it as a keyword in the post.</p>
					<!--<p class="links"><a href="#" class="more">&laquo;&laquo;&nbsp;&nbsp;Read More&nbsp;&nbsp;&raquo;&raquo;</a></p>-->
				</div>
			</div>
		</div>
			
			
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>





<div id="footer">
	<p class="copyright">Designed by Decepticons</p>
</div>


</body>
</html>
