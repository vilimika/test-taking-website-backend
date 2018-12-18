<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);
	
	//make db conn
	$driver = new db();
	$db = $driver -> connect();

	//delete selected problem
	$driver -> delProblem($data, $db);

	//will need error check later
	echo json_encode("Question successfully deleted!");

	//disconnect from db
	mysqli_close($db);
?>
