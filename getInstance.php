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
	$driver -> getInstance($data, $db);

	//close db
	mysqli_close($db);
?>
