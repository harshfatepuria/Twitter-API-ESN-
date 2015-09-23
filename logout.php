<?php
session_start();
if(isset($_SESSION['username']))
{
	//DESTROYING SESSION AND SESSION VARIABLES.
	unset($_SESSION['username']);
	session_destroy();
}
header("Location: index.php");
?>