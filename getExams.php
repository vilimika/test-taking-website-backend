<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');

	//get db conn
	$driver = new db();
	$db 	= $driver -> connect();

	//get all existing exams
	$driver -> getExams($db);

	//close db conn
	mysqli_close($db);
?>
