<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');
	
	//connect to db
	$driver = new db();
	$db 	= $driver -> connect();
	
	//get problem
	$driver -> getStudents($db);

	//close db conn
	mysqli_close($db);
?>
