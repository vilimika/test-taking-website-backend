<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
include('db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	//get incoming data
	$request    = file_get_contents('php://input');
	$data       = json_decode($request, true);

	//make db conn
	$driver = new db();
	$db = $driver -> connect();

	//add exam
	$driver -> addExam($data, $db);

	//will need an error check later before this
	echo "You successfully added an exam!";

	//close db conn
	mysqli_close($db);
?>
