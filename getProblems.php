<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//connect to db
	$driver = new db();
	$db 	= $driver -> connect();

	//get all problems from db
	$driver -> getProblems($db);

	//close db conn
	mysqli_close($db);
?>
