<?php
require 'model.php';
$model = new Model('localhost', 'root', '', 'toucantech');
//variable used to output datasets
$result;

//part of code that is called to populate the view when the page finished loading
if(isset($_POST['populate'])){
	if($_POST['populate'] == 'schools'){
		$result = $model->populate('id', 'Name');
	}
	else if($_POST['populate'] == 'countries'){
		$result = $model->populate('Country');
	}
}

//part of code that prepares the data for the new member to be stored inside of the DB
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['schools'])){
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$schools = $_POST['schools'];
	
	if(validate('value', $name) && validate('email', $email) && validate('numericArray', $schools)){
		$model->newMember($name, $email, $schools);
		//when the operation went well, the code output 1, otherwise 0, or an error message from the DB
		echo 1;
	}
	else echo 0;
}

//part of code that to search the DB by school or country
if(isset($_POST['type']) && isset($_POST['param'])){
	if(validate('value', $_POST['type']) && validate('value', $_POST['type'])){
		$result = $model->searchBy($_POST['type'], $_POST['param']);
	}
}

//part of code that prepares the report to be formatted and downloaded as a CSV file
if(isset($_GET['getReport'])){
	$filename = 'report.csv';
	//instruction to download the file
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=".$filename);
	header("Content-Type: application/csv;");
	//call the DB to get the data
	$res = $model->getReport();
	$res = $res->fetch_all(MYSQLI_ASSOC);
	//insert the table header inside of the report
	array_unshift($res, array_keys($res[0]));
	$file = fopen($filename,"w");
	foreach($res as $line){
		fputcsv($file, $line);
	}
	fclose($file);
	readfile($filename);
	unlink($filename);
}

//part of code that outputs the dataset to be displayed in the view
if(isset($result)){
	echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

//validating function to filter data passed to the database
function validate($type, $param){
	$passed;
	if(!empty($param)){
		if($type == 'value'){
			$passed = preg_match("/^[a-z0-9 ,.'-]+$/i", $param);
		}
		else if($type == 'email'){
			$passed = preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $param);
		}
		else if($type == 'numericArray'){
			$passed = is_array($param);
			if($passed){
				foreach($param as $p){
					if(!is_numeric($p)){
						$passed = 0;
						break;
					}
				}
			}
		}
	}
	return $passed == 1;
}