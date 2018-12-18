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

	$f = "output";
	if(is_writable($f))
	{
		$fp = fopen($f, 'w') or die();
		fwrite($fp, $request);
	}

	//add problem to db
	$driver -> createInstance($data, $db);

	//verify
	$msg = "Instance created!";
	echo json_encode($msg);

	//close db
	mysqli_close($db);
?>
