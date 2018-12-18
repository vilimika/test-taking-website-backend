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

	//add exam
	$driver -> getExam($data, $db);

	//close db conn
	mysqli_close($db);
?>
