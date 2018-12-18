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

	//add problem to db
	$driver -> addUserExam($data, $db);

	//will need an error check before this in the future!!
	$msg 	= "Exam has been submitted!";
	echo json_encode($msg);

	//close db
	mysqli_close($db);
?>
