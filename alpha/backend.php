<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
	
	//get incoming data
	$request	= file_get_contents('php://input');
    $data		= json_decode($request, true);

	//build vars for sql
	$username = $data['user']['username'];
	$password = $data['user']['password'];

	//connect to db server 
	$db = new mysqli('sql1.njit.edu', 'vm348', 'gravid59', 'vm348');

	//check if connected
	if($db -> connect_errno)
	{
		$msg = "Cannot connect to database";
		echo json_encode($msg);
	}

	//this will need to be changed according to how they structure json
	//build sql query
	$sql	= "SELECT id FROM users WHERE id = '$username' and password = '$password'";
	
	//run query
	$result = $db -> query($sql);

	//send message acodring to wether there was a result found
	if($result -> num_rows == 1)
	{
		$msg = 'our system says iight.';
		echo $msg;
	}

	else	
	{
		$msg = 'our system says nah fool.';
		echo $msg;
	}

?>
