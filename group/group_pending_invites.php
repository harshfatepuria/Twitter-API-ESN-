<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>GROUPS</title>
<link href="../default.css" rel="stylesheet" type="text/css" media="screen" />
<link href="../login.css" rel="stylesheet" type="text/css" media="screen" />
<link href="group.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<?php
$pageid=8;
	
session_start();
if(isset($_SESSION['username']))
{
	$username=$_SESSION['username'];
	$frompage=$_SESSION['pageid'];	
	$_SESSION['pageid']=$pageid;
	
	switch($frompage)
	{
		//LIST OF PAGES FROM WHERE IT CAN BE REDIRECTED HERE
		case '5': break;
		case '6': break;
		case '7': break;
		case '8': break;
		case '9': break;
		case '10': break;
		
	
		default: header("Location: ../index.php");
	}
}
else
{
	header("Location: ../index.php");
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
			<a href="../logout.php">Logout</a>
		</div>
		
	</div>
	<div id="menu">
		<ul id="main">
			<li><a href="../user_home.php">Home</a></li>
			<li><a href="../search_post_byUser.php">Search Posts</a></li>
			<li class="current_page_item"><a>Groups</a></li>
		</ul>
	</div>
</div>
<!-- end header -->




<div id="wrapper">
	<!-- start page -->
	<div id="page">
		


		<div id="sidebar1" class="sidebar">
			<ul>
				<li>
					<ul>
						<li><a href="group_home.php">Home</a></li>
						<li class="current_page_item"><a>Pending Invites</a></li>
						<li><a href="group_create.php">Create Group</a></li>
						<li><a href="group_manage.php">Manage Group</a></li>
						
					</ul>
				</li>
				<!-- can add more <li> like above to create different sections here-->
			</ul>
		</div>




		<!-- start content -->
		<div id="content">
			<div class="post">
				<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<label for="tag">ENTER $ TAG</label>
				<input class="tag" name="tag" type="text"><br/>
				<input value="SEARCH" type="submit">
				<input value="RESET" type="reset">
				</form>
			</div>
			
			
			
			
<?php			
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$tag=trim($_REQUEST['tag']);
		$tag=strtolower($tag);
		if(stripos($tag,"$")!==0)
				$tag="$".$tag;
		
		
		
		$con=mysqli_connect("localhost","root","","chat");
		$query="(SELECT * FROM  taglist t join posts p ON t.postid=p.postid WHERE t.tag ='$tag') ORDER BY t.tstamp DESC";				
		$result=mysqli_query($con,$query);
		$num_rows=mysqli_num_rows($result);


		if($num_rows==0)
		{
			echo '<div class="post">
				<h1 class="title">No posts available for the tag: '.$tag.'</h1>
				<p class="byline"></p>
				<div class="entry" id="entry">';
		}			
		else
		{
			echo '<div class="post">
				<h1 class="title">Search Results For Tag: '.$tag.'</h1>
				<p class="byline"></p>
				<div class="entry" id="entry">';
				while(($row=mysqli_fetch_array($result)))
				{
					//DISPLAYING THE POST.
					echo '<div class="boxlist">
					<div class="ngo_list">
					<div>
					<h2>@'.$row['username'].'</h2>
					</div>
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
}			
else
{
	echo '<div class="post">
				<div class="entry" id="entry">';
}			
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