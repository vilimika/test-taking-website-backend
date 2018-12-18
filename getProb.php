<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');
	
	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);

	//connect to db
	$driver = new db();
	$db 	= $driver -> connect();
	
	//get problem
	$driver -> getProb($data, $db);

	//close db conn
	mysqli_close($db);
?>
