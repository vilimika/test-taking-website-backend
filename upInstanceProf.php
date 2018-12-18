<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);
	
	//open db conn
	$driver = new db();
	$db		= $driver -> connect();

	//get exam instance data
	$driver -> updateInstanceProf($data, $db);

	$msg = "successfully released an exam!";
	echo json_encode($msg);

	//close db
	mysqli_close($db);
?>
