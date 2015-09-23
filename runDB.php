<?php
	$con=mysqli_connect("localhost","root","","chat");
	$query="CREATE TABLE IF NOT EXISTS `grouplist` (
  `groupname` varchar(50) NOT NULL,
  `groupmember` varchar(50) NOT NULL,
  `admin` varchar(10) NOT NULL,
  `accepted` varchar(10) NOT NULL
);";
   echo mysqli_query($con,$query);
   
	
	
	
	
?>