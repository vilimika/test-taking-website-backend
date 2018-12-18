<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	
	$db = new mysqli('sql1.njit.edu', 'vm348', 'gravid59', 'vm348');

	//check if connected
	if($db -> connect_errno)
	{
		$msg = "Cannot connect to database";
		echo $msg;
	}

	//this will need to be changed according to how they structure json
	//build sql query

	$pswrd = md5("fake");

	$sql	= "UPDATE users SET password = '$pswrd' WHERE password = 'fake'";
	
	//run query
	$result = $db -> query($sql);


?>
