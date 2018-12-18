<?php
//Vilius Mikalauskas
//Fall 2018 CS490 
require_once('config/config.php');


	//connect to db server 
	$db = new mysqli('sql1.njit.edu', 'vm348', 'gravid59', 'vm348');

	//check if connected
	if($db -> connect_errno)
	{
		$msg = "Cannot connect to database";
		echo json_encode($msg);
	}

	//this will need to be changed according to how they structure json
	//build sql query
	$sql	= "SELECT * FROM problems";
	
	//run query
	$result = $db -> query($sql);
	
	$data = array();
	$i = 0;
	while($row = $result->fetch_assoc())
	{
		//print_r($row);
		$data[$i++] = $row;
	}

	echo json_encode($data);

?>
