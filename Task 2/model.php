<?php
//the first 4 lines of this file belongs more to the controller than the model, but I decided to merge them into a single file to load 1 file instead of 2 tiny files, increasing performances by a little
if(isset($_POST['name'])){
	$name = trim($_POST['name']);
	if(!empty($name) && preg_match("/^[a-z ,.'-]+$/i", $name)){
		$name = '%'.$name.'%';
		$mysqli = new mysqli('localhost', 'root', '', 'toucantech');
		$stmt = $mysqli->prepare('SELECT Firstname, Surname, emailaddress FROM profiles p JOIN emails e ON p.UserRefID = e.UserRefID WHERE p.Firstname LIKE ? AND e.Default = 1');
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$result = $stmt->get_result();
		$mysqli->close();
		echo json_encode($result->fetch_all(MYSQLI_ASSOC));
	}
}