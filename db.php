<?php 
//Vilius Mikalauskas
//Fall 2018 CS490

class db
{

	private $db_host = "sql1.njit.edu";
	private $db_user = "vm348";
	private $db_pass = "tqtTUeHh";
	private $db_name = "vm348";
	
	//best constructor takes care of crucial things
	function __construct(){}
		
	//
	public function connect()
	{
		$db = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

		if($db -> connect_errno)
		{
			$msg = "Cannot connect to database";
			echo json_encode($msg);
		}
		else
			return $db;
	}

	//get all existing problems from the db
	public function getProblems($db)
	{
		$sql		= "SELECT * FROM problems";

		$result 	= $db -> query($sql);
		
		//for some reason fetch_all doesnt work on afs?!?!?
		//ghetto rig getting all values from db
		$data		= array();
		$i			= 0;
		while($row	= $result->fetch_array()) {$data[$i++] = $row;}

		echo json_encode($data);
	}

	//this function handles login
	public function login($data, $db)
	{
		//build vars for sql
		$username   = $data['user']['username'];
		$password   = md5($data['user']['password']);
		$answer     = array("id" => "none", "instructor" => "none");

		$sql    = "SELECT id, instructor FROM users WHERE username 
				= '$username' and password 
				= '$passwo    rd'";

		//run query
		$result = $db -> query($sql);
		$retval = $result -> fetch_assoc();

		//send message acodring to wether there was a result found
		if($result -> num_rows == 1)
		{
			$answer = array("id" => $retval['id'], "instructor" => $retval['instructor']);	
		}
		else
		{
			$answer = "The username or password you entered was incorrect";
		}

		echo json_encode($answer);
	}

	//add problem to the database
	public function addProblem($data, $db)
	{
	
	
		$type       = $data['question']['topic'];
		$difficulty = $data['question']['difficulty'];
		$question	= $data['question']['question'];
		$funcName	= $data['question']['functionName'];
		$constraint	= $data['question']['constraint'];
		$test_1		= $data['question']['testCase1']['testCase'];
		$test_2		= $data['question']['testCase2']['testCase'];
		$test_3		= $data['question']['testCase3']['testCase'];
		$test_4		= $data['question']['testCase4']['testCase'];
		$test_5		= $data['question']['testCase5']['testCase'];
		$test_6		= $data['question']['testCase6']['testCase'];
		$out_1		= $data['question']['testCase1']['expectedOutput'];
		$out_2		= $data['question']['testCase2']['expectedOutput'];
		$out_3		= $data['question']['testCase3']['expectedOutput'];
		$out_4		= $data['question']['testCase4']['expectedOutput'];
		$out_5		= $data['question']['testCase5']['expectedOutput'];
		$out_6		= $data['question']['testCase6']['expectedOutput'];

		$sql 		= "INSERT INTO problems
		(
			`id`,
			`type`,
			`difficulty`,
			`data`,
			`func_name`,
			`constraint`,
			`test_1`,
			`test_2`,
			`test_3`,
			`test_4`,
			`test_5`,
			`test_6`,
			`out_1`,
			`out_2`,
			`out_3`,
			`out_4`,
			`out_5`,
			`out_6`
		)
		VALUES
		(
		'NULL',
		'$type',
		'$difficulty',
		'$question',
		'$funcName',
		'$constraint',
		'$test_1',
		'$test_2',
		'$test_3',
		'$test_4',
		'$test_5',
		'$test_6',
		'$out_1',
		'$out_2',
		'$out_3',
		'$out_4',
		'$out_5',
		'$out_6'
		)";
		
		$db -> query($sql);
	}

	//delete existing problem from db
	public function delProblem($data, $db)
	{
		$id		= $data['id'];

		$sql	= "DELETE FROM problems WHERE id = '$id'";

		$db 	-> query($sql);
	}
	
    private function processInput($data)
    {
        //build vars
        $ids = "" . $data['exam']['selectedQ'][0]['id'] . "," . $data['exam']['selectedQ'][1]['id'] . "," . $data['exam']['selectedQ'][2]['id'];

        $pts = "" . $data['exam']['selectedQ'][0]['points'] . "," . $data['exam']['selectedQ'][1]['points'] . "," . $data['exam']['selectedQ'][2]['points'];

		//build return array
        $ret = array('exam' => array('examName' => $data['exam']['examName'], 'selectedQ' => $ids, 'points' => $pts));

		//return fixed data
        return $ret;
    }

	//update existing problem
	public function upProblem($data, $db)
	{
		//build vars
		$id			= $data['question']['id'];
		$type		= $data['question']['topic'];
		$difficulty = $data['question']['difficulty'];
		$data       = $data['question']['question'];
	
		//build sql
		$sql		= "UPDATE problems SET
		type		= '$type',
		difficulty	= '$difficulty',
		data		= '$data'
		WHERE id 	= '$id'";

		$db 		-> query($sql);
	}

	//pain in the ass function
	public function getExams($db)
	{
		//buildq sql and get exam
		$sql_exam       = "SELECT * FROM exam";
		$result_exam	= $db -> query($sql_exam);
	
		//build output array
		$data			= array();
		$i				= 0;
		while($row_exam	= $result_exam->fetch_assoc())
		{
	
			$prob = explode(",", $row_exam['selectedQ']);

			//make problem sql
			$sql_problem  	= "SELECT * FROM problems
							WHERE id = '$prob[0]' 
							OR id	 = '$prob[1]'
							OR id	 = '$prob[2]'";
			$result_problem = $db -> query($sql_problem);
			//get problem data and add to output array
			$x 				= 0;

			while($row_problem  = $result_problem -> fetch_assoc())
			{
				$row_exam[$x++]	= $row_problem['data'];
			}
			$data[$i++]			= $row_exam;
		}
		 echo json_encode($data);
	}

	//add new exam to database
	public function addExam($data, $db)
	{
		$data		= $this -> processInput($data);
		
		//build vars
		$selectedQ	= $data['exam']['selectedQ'];
		$name		= $data['exam']['examName'];
		$points		= $data['exam']['points'];

		//build sql
		$sql  = "INSERT INTO exam
		(
			`id`,
			`name`,
			`selectedQ`,
			`points`
		)
		VALUES
		(
		'NULL',
		'$name',
		'$selectedQ',
		'$points'
		)";

		$db -> query($sql);
		$msg = $db -> error;
		echo json_encode($msg);
	}


	//get singel question 
	public function getProb($data, $db)
	{
		$id		= $data['id'];
		$sql	= "SELECT * FROM problems WHERE id = '$id'";

		$result = $db -> query($sql);

		$row 	= $result -> fetch_array(MYSQLI_NUM);

		echo json_encode($row);
	}

	//get single exam by id
	public function getExam($data, $db)
	{
		//build vars
		$id		= $data['id'];

		//build sql
		$sql	= "SELECT * FROM exam WHERE id = '$id'";	

		//query db
		$result	= $db -> query($sql);
		$row 	= $result -> fetch_assoc();

		echo json_encode($row);
	}

	//insert student  answers into user_exam table
	public function addUserExam($data, $db)
	{
		//build vars
		$exam_id	= $data['examId'];
		$student_id	= $data['studentId'];
		$answer_1	= $data['questions'][0]['answer'];
		$answer_2	= $data['questions'][1]['answer'];
		$answer_3	= $data['questions'][2]['answer'];

		//make sql
		$sql		= "INSERT INTO user_exam
		(
			`id`,
			`user_id`,
			`exam_id`,
			`answer_1`,
			`answer_2`,
			`answer_3`,
			`grade_1`,
			`grade_2`,
			`grade_3`,
			`total`,
			`feedback_1`,
			`feedback_2`,
			`feedback_3`,
			`release_exam`,
			`taken`
		)
		VALUES
		(
			'NULL',
			'$student_id',
			'$exam_id',
			'$answer_1',
			'$answer_2',
			'$answer_3',
			'0',
			'0',
			'0',
			'0',
			'NULL',
			'NULL',
			'NULL',
			'0',
			'0'
		)";

		$db -> query($sql);
		$msg = $db -> error;
	
		$f = "output1";
		if(is_writable($f))
		{
			$q = 'hi';
			$fp = fopen($f, 'w') or die();
			fwrite($fp, $msg);
			fwrite($fp, $q);
			fclose($fp);
		}
	}

	public function getInstance($data, $db)
	{
		//build vars
		$student_id		= $data['studentId'];

		//build instance sql
		$sql_instance	= "SELECT exam.*, user_exam.*
							FROM exam LEFT JOIN user_exam ON exam.id = user_exam.exam_id
							WHERE user_exam.user_id = '$student_id'";
		
		//get instance data
		$result_instance	= $db -> query($sql_instance);
		//$row_instance		= $result_instance -> fetch_assoc();
		
		//build output array
		$i					= 0;
		$data				= array();
		while($row_instance = $result_instance->fetch_assoc())
		{
			$prob = explode(",", $row_instance['selectedQ']);

			//make problem sql
			$sql_problem    = "SELECT * FROM problems
								WHERE id = '$prob[0]'
								OR id    = '$prob[1]'
								OR id    = '$prob[2]'";
			$result_problem = $db -> query($sql_problem);
			//get problem data and add to output array
			$x              = 0;
			while($row_problem  = $result_problem -> fetch_assoc())
			{
					$row_instance[$x++] = $row_problem['data'];
			}
			$data[$i++]         = $row_instance;
		}
		echo json_encode($data);
	}


	//get all students from db
	public function getStudents($db)
	{
			//build sq
		$sql	= "SELECT id, fname, lname, username FROM users where instructor = '0'";

		//run query
		$result	= $db -> query($sql);

		//build output array
		$data	= array();
		$i		= 0;
		while($row  = $result->fetch_assoc()) {$data[$i++] = $row;}

		//output data
		echo json_encode($data);
	}

	//update exam instance
	public function updateInstance($data, $db)
	{
		//build vars 
		$grade_1 	= $data['pointsGiven'][0];
		$grade_2    = $data['pointsGiven'][1];
		$grade_3    = $data['pointsGiven'][2];
		$feedback_1	= $data['feedback'][0];
		$feedback_2 = $data['feedback'][1];
		$feedback_3 = $data['feedback'][2];
		$student_id	= $data['studentId'];
		$exam_id	= $data['examId'];
		$total		= $grade_1 + $grade_2 + $grade_3;

		//build sql
		$sql		= "UPDATE user_exam SET
		grade_1		= $grade_1,
		grade_2		= $grade_2,
		grade_3		= $grade_3,
		feedback_1	= '$feedback_1',
		feedback_2	= '$feedback_2',
		feedback_3	= '$feedback_3',
		total		= $total,
		taken		= '1'
		WHERE user_id = $student_id AND exam_id = $exam_id
		";
	
		//run query
		$db			-> query($sql);
		$msg = $db -> error;
		$f = "output";
		if(is_writable($f))
		{
			$fp = fopen($f, 'w') or die();
			fwrite($f, $msg);
			fclose($fp);
		}
	}

	public function updateInstanceProf($data, $db)
	{
		//build vars
		$grade_1	= $data['gradedQuestions'][0]['pointsGiven'];
		$grade_2	= $data['gradedQuestions'][1]['pointsGiven'];
		$grade_3	= $data['gradedQuestions'][2]['pointsGiven'];
		$feedback_1	= $data['gradedQuestions'][0]['feedback'];
		$feedback_2 = $data['gradedQuestions'][1]['feedback'];
		$feedback_3 = $data['gradedQuestions'][2]['feedback'];
		$release	= $data['release'];
		$id			= $data['id'];

		//build sql
		$sql			= "UPDATE user_exam SET
		grade_1 		= $grade_1,
		grade_2 		= $grade_2,
		grade_3 		= $grade_3,
		feedback_1 		= '$feedback_1',
		feedback_2 		= '$feedback_2',
		feedback_3 		= '$feedback_3',
		release_exam 	= $release
		WHERE id 		= $id
		";

		//run query
		$db			-> query($sql);
	}
/*
	public function createInstance($data, $db)
	{
		$student_id	= $data['studentId'];
		$exam_id	= $data['examId'];

		$sql		= "INSERT INTO user_exam
		(
			`id`,
			`user_id`,
			`exam_id`,
			`answer_1`,
			`answer_2`,
			`answer_3`,
			`grade_1`,
			`grade_2`,
			`grade_3`,
			`total`,
			`feedback_1`,
			`feedback_2`,
			`feedback_3`,
			`release_exam`,
			`taken`
		)
		VALUES
		(
			'NULL',
			'$student_id',
			'$exam_id',
			'NULL',
			'NULL',
			'NULL',
			'0',
			'0',
			'0',
			'0',
			'NULL',
			'NULL',
			'NULL',
			'0',
			'0'
		)";

		$db -> query($sql);	

		$m = $db -> error;

		$f = "output";
		if(is_writable($f))
		{
			$fp = fopen($f, 'w') or die();
			fwrite($fp, $m);
		}
	}
*/
}



?>


