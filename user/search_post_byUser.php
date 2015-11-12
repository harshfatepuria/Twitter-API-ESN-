<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>SEARCH POSTS</title>
<link href="../default.css" rel="stylesheet" type="text/css" media="screen" />
<link href="../login.css" rel="stylesheet" type="text/css" media="screen" />
</head>



<?php
session_start();
include_once("config.php");
include_once("inc/twitteroauth.php");

if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
{
	$screenname=$_SESSION['screenname'];
	$twitterid=$_SESSION['twitterid'];
	$oauth_token=$_SESSION['oauth_token'];
	$oauth_token_secret=$_SESSION['oauth_token_secret'];
	
	
	
}
else
{
	header("Location: ../index.php");
}

	require_once('../TwitterAPIExchange.php');
	ini_set('display_errors', 1);
	$settings = array(
    'oauth_access_token' => $oauth_token,
    'oauth_access_token_secret' => $oauth_token_secret,
    'consumer_key' => "<your twitter application consumer key>",
    'consumer_secret' => "<your twitter application consumer secret>"
	);

?>




<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a><span>Twitter Network</span></a></h1>
		
		<div class="register" align="right">
			<span class="welcome">Welcome, <?php echo $screenname;?>!</span><br><br>
			<a href="logout.php">Logout</a>
		</div>
		
	</div>
	<div id="menu">
		<ul id="main">
			<li><a  href="user_home.php">Home</a></li>
			<li class="current_page_item"><a>Search Posts</a></li>
			<li><a href="../group/group_create.php">Group</a></li>
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
				<label for="tag">ENTER # TAG</label>
				<input class="tag" name="tag" type="text" autofocus><br/>
				<input value="SEARCH" type="submit">
				<input value="RESET" type="reset">
				</form>
			</div>
			
			
<?php			
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST['tag']))
	{
		
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?result_type=recent&count=20&q=';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);



		$tag=trim($_REQUEST['tag']);
		$tag=strtolower($tag);
		if(stripos($tag,"#")!==0)
				$tag="#".$tag;
		

		$getfield=$getfield.$tag;
		$res=$twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
		$result=json_decode($res);
		$num_rows=count($result->statuses);
		
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
				for ($i=0; $i<count($result->statuses); $i++)
				{
					echo '<div class="boxlist">
					<div class="ngo_list">
					<div>
					<h2>'.$result->statuses[$i]->user->name.' <span><small>@'.$result->statuses[$i]->user->screen_name.'</small></span></h2>
					</div>
					<div>
						<span>'.$result->statuses[$i]->created_at.'</span>
					</div>
					<div>
						<span>'.$result->statuses[$i]->text.'</span>
					</div>
					</div>
					</div>
					';

				}
		}
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
	<p class="copyright">Created by Harsh Fatepuria</p>
</div>


</body>
</html>