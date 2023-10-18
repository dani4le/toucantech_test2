<?php
class Model{
	//DB connection parameters
    protected string $host;
    protected string $user;
    protected string $password;
    protected string $db;

    public function __construct(string $host, string $user, string $password, string $db) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }
	
	public function connect(){
		return new mysqli($this->host, $this->user, $this->password, $this->db);
	}
	
	//method that gets data to be displayed to list the schools and countries, the number of parameters depends on what's needed
	public function populate(...$params){
	$mysqli = $this->connect();
	$result = $mysqli->query('SELECT '.implode(',', $params).' FROM schools GROUP BY '.$params[0]);
	$mysqli->close();
	return $result;
	}
	
	//method to add a new member, at first it creates the member, than it takes the id just created to store the new membership with every school selected
	public function newMember($name, $email, $schools){
	$mysqli = $this->connect();
	$stmt = $mysqli->prepare('INSERT INTO members (Name, emailaddress) VALUES (?, ?);');
	$stmt->bind_param('ss', $name, $email);
	$stmt->execute();
	$sql = 'INSERT INTO memberships VALUES';
	foreach($schools as $s){
		$sql .= ' (LAST_INSERT_ID(), '.$s.'),';
	}
	$sql = substr($query, 0, -1).';';
	$mysqli->query($sql);
	$mysqli->close();
	}
	
	//method to search the DB by school or country, at the beginning it's needed to define which table field to search
	public function searchBy($type, $param){
		$field;
		if($type == 'schools'){
			$field = 'ms.schoolId';
		}
		else if($type == 'countries'){
			$field = 's.Country';
		}
		if($field){
			$mysqli = $this->connect();
			$result = $mysqli->query('SELECT s.Country, s.Name School, m.Name, emailaddress FROM memberships ms JOIN members m ON m.id = ms.memberId JOIN schools s ON s.id = ms.schoolId WHERE '.$field.' = "'.$param.'";');
			$mysqli->close();
			return $result;
		}
	}
	
	//method that generates the report for the CSV file
	public function getReport(){
		$mysqli = $this->connect();
		$result = $mysqli->query('SELECT m.Name, emailaddress, s.Name School FROM memberships ms JOIN members m ON m.id = ms.memberId JOIN schools s ON s.id = ms.schoolId ORDER BY School');
		$mysqli->close();
		return $result;
	}
}