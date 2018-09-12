<?php
require_once('DBConn.php');

class Course {
	public $code;
	public $title;
	public $nPeriod;
	
	public function __construct($code, $title, $nPeriod)
	{
		$this->code = $code;
		$this->title = $title;
		$this->nPeriod = $nPeriod;
	}
	
	public function Parse($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->title = $tokens[0];
		if (1 < $n)
			$this->nPeriod = $tokens[1];
	}
	
	public function mPrint()
	{
		echo $this->code."|".$this->title."|".$this->nPeriod;
	}
}

class CourseList
{
	public $vElem;
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		$i = 0;
		while ($token !== false)
		{
			$crs = new Course(0, "", 0);
			$crs->Parse($token);
			$crs->code = $i;//todo
			$i = $i + 1;
			array_push($this->vElem, $crs);
			$token = strtok("\n");
		}
	}
	
	public function mPrint()
	{
		foreach($this->vElem as $elem)
			echo $elem->mPrint()."<br>";
	}
	
	public function Ins() {
		if(count($this->vElem) == 0)
			return;
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "INSERT INTO lms_course VALUES ";
		foreach($this->vElem as $elem)
			$sql .= "(".$elem->code.",'".$elem->title."',".$elem->nPeriod."),";
		$sql = substr($sql, 0, strlen($sql) - 1);//remove the last comma

		if ($conn->query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}
	
	public function Sel() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT crs_code, crs_title, crs_n_period FROM lms_course";
		$result = $conn->query($sql);
		$this->vElem = array();

		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($this->vElem, new Course($row['crs_code'], $row['crs_title'], $row['crs_n_period']));
	}
	
	public function Del() {
		if(count($this->vElem) == 0)
			return;
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "DELETE FROM lms_course";

		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
	}
}
?>