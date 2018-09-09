<?php
class ClassType {
	public $id;
	public $name;
	public $nPeriod;
	
	public function __construct($id, $name, $nPeriod)
	{
		$this->id = $id;
		$this->name = $name;
		$this->nPeriod = $nPeriod;
	}
	
	public function Parse($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->name = $tokens[0];
		if (1 < $n)
			$this->nPeriod = $tokens[1];
	}
	
	public function mPrint()
	{
		echo $this->id."|".$this->name."|".$this->nPeriod;
	}
}

class ClassTypeList
{
	public $vElem;
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		while ($token !== false)
		{
			$classType = new ClassType(0, "", 0);
			$classType->Parse($token);
			array_push($this->vElem, $classType);
			$token = strtok("\n");
		}
	}
	
	public function mPrint()
	{
		foreach($this->vElem as $elem)
			echo $elem->mPrint()."<br>";
	}
	
	public static function DBConn()
	{
		$servername = "localhost";
		$username = "root";
		$password = "1234";
		$dbname = "lms";

		// Create connection
		return new mysqli($servername, $username, $password, $dbname);
	}
	
	public function Ins() {
		if(count($this->vElem) == 0)
			return;
		$conn = ClassTypeList::DBConn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "INSERT INTO lms_class_type(name, n_period) VALUES ";
		foreach($this->vElem as $elem)
			$sql .= "('".$elem->name."',".$elem->nPeriod."),";
		$sql = substr($sql, 0, strlen($sql) - 1);//remove the last comma

		if ($conn->query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}
	
	public function Sel() {
		$conn = ClassTypeList::DBConn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT id, name, n_period FROM lms_class_type";
		$result = $conn->query($sql);
		$this->vElem = array();

		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($this->vElem, new ClassType($row['id'], $row['name'], $row['n_period']));
	}
}
?>