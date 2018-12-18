<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);

	//open db conn
	$driver = new db();
	$db = $driver -> connect();

	//add problem to db
	$driver -> addProblem($data, $db);

	//will need an error check before this in the future!!
	echo "You successfully added a question!";

	//close db
	mysqli_close($db);
?>
