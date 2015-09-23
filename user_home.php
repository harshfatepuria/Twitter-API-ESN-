<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>USER</title>
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link href="login.css" rel="stylesheet" type="text/css" media="screen" />
</head>


<?php
$pageid=5;
	
session_start();
if(isset($_SESSION['username']))
{
	$username=$_SESSION['username'];
	$frompage=$_SESSION['pageid'];	
	$_SESSION['pageid']=$pageid;
	switch($frompage)
	{
		//LIST OF PAGES FROM WHERE IT CAN BE REDIRECTED HERE
		case '1': break;
		case '2': break;
		case '3': break;
		case '4': break;
		case '5': break;
		case '6': break;
		case '7': break;
		case '8': break;
		case '9': break;
		case '10': break;
	
		default: header("Location: index.php");
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$con=mysqli_connect("localhost","root","","chat");
		$message=trim($_REQUEST['postByUser']);
		if(strcmp($message, "")==0)
		{
			echo '<script>alert("Please write something!");</script>';
		}
		else
		{
			$postid=date('Y').date('m').date('d').date('H').date('i').date('s').$username.rand(1,20);
			$query="INSERT INTO posts (username,message,postid) VALUES ('$username','$message','$postid')";
			mysqli_query($con,$query);
			
			
			
			//EXTRACTING TAGS AND INSERTING THEM IN TAGLIST ENTITY
			$tkn=strtok($message, " ,.!;:/'\n");
			while($tkn!==false)
			{
				if(strlen($tkn)==1)
				{
					$tkn=strtok(" ,.!;:/'\n");
					continue;
				}
					
				if(stripos($tkn,"$")===0)
				{
					$arr=array("."=>"","_"=>"","!"=>"",","=>"",";"=>"",":"=>"");
					$tkn=strtr($tkn,$arr);
					$query="INSERT INTO taglist (tag,postid) VALUES ('$tkn','$postid')";
					mysqli_query($con,$query);
				}
				$tkn=strtok(" ,.!;:/'\n");
			}
			
			
			
			
			
			
		}
		mysqli_close($con);
	}
}
else
{
	header("Location: index.php");
}	
?>









<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a><span>$chat</span></a></h1>
		<!--<p>Designed By Decepticons</p>-->
		
		<div class="register" align="right">
			<span class="welcome">Welcome, <?php echo $username;?>!</span><br><br>
			<a href="logout.php">Logout</a>
		</div>
		
	</div>
	<div id="menu">
		<ul id="main">
			<li class="current_page_item"><a>Home</a></li>
			<li><a href="search_post_byUser.php">Search Posts</a></li>
			<li><a href="group/group_home.php">Groups</a></li>
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
				<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<textarea class="postByUser" name="postByUser" rows="3" cols="50" placeholder="Write your message here." autofocus></textarea>
				<div>
					<input class="ngo_approval" value="POST" type="submit">
					<input class="ngo_approval" value="RESET" type="reset">
				</div>
				</form>
			</div>
			
			
			
<?php
	$con=mysqli_connect("localhost","root","","chat");
	$query="SELECT * FROM  posts WHERE username ='$username' ORDER BY tstamp DESC";				
	$result=mysqli_query($con,$query);
	$num_rows=mysqli_num_rows($result);


	if($num_rows==0)
	{
		echo '<div class="post">
				<h1 class="title">No posts available.</h1>
				<p class="byline"></p>
				<div class="entry" id="entry">';
	}			
	else
	{
		echo '<div class="post">
				<h1 class="title">Your Recent Posts</h1>
				<p class="byline"></p>
				<div class="entry" id="entry">';
		while(($row=mysqli_fetch_array($result)))
		{
			//DISPLAYING THE POST.
			echo '<div class="boxlist">
					<div class="ngo_list">
					<div>
						<span>'.$row['tstamp'].'</span>
					</div>
					<div>
						<span>'.$row['message'].'</span>
					</div>
					</div>
					</div>
				';
		}	
	}
	mysqli_close($con);
?>							

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