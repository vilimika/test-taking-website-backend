<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);

	//connect to db
	$driver = new db();
	$db		= $driver -> connect();
	
	//update existing problem
	$driver	-> addProblem($data, $db);

	//will want an error check before this in the future
	$msg	= "You successfully updated a question!";
	echo json_encode($msg);

	//close db conn
	mysqli_close($db);
?>
