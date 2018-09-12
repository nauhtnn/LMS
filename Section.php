<?php
require_once('DBConn.php');
require_once('Student.php');

class Course {
	public $year;
	public $minor_id;
	public $course_type;
	public $teac_name;
	public $start_date;
	public $end_date;
	public $vStudent;
	
	public function __construct($year, $m_id, $c_type, $t_name, $s_d, $e_d)
	{
		 $this->year = $year;
		 $this->minor_id = $m_id;
		 $this->course_type = $c_type;
		 $this->teac_name = $t_name;
		 $this->start_date = $s_d;
		 $this->end_date = $e_d;
		 $this->vStudent = new StudentList();
	}
	
	public function ParseCourseInfo($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->year = $tokens[0];
		if (1 < $n)
			$this->minor_id = $tokens[1];
		if (2 < $n)
			$this->course_type = $tokens[2];
		if (3 < $n)
			$this->teac_name = $tokens[3];
		if (4 < $n)
			$this->start_date = $tokens[4];
		if (5 < $n)
			$this->end_date = $tokens[5];
	}
	
	public function Parse($s)
	{
		$tokens = preg_split("/\n/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->ParseCourseInfo($tokens[0]);
		$this->vStudent->Prep1();
		for($i = 1; $i < $n; $i = $i + 1)
			$this->vStudent->Parse1($tokens[$i]);
	}
	
	public function mPrint()
	{
		echo $this->year."|".$this->minor_id."|".$this->course_type."|".$this->teac_name."|".$this->start_date."|".$this->end_date."<br>";
		$this->vStudent->mPrint();
	}
	
	public function InsCourseInfo() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = "INSERT INTO lms_course VALUES (".$this->year.",".$this->minor_id.",".$this->course_type.",'".
			$this->teac_name."','".$this->start_date."','".$this->end_date."')";

		if ($conn->query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}
	
	public function Ins() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = 'INSERT INTO lms_course VALUES ('.$this->year.','.$this->minor_id.','.$this->type_id.
			",'".$this->teac_name."','".$this->start_date."','".$this->end_date."')";

		if ($conn->query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
		
		$this->vStudent->Ins();
	}
}

class CourseList
{
	public $vElem;
	
	public function Sel() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = "SELECT * FROM lms_course";
		$result = $conn->query($sql);
		$this->vElem = array();

		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($this->vElem, new Course($row['year'], $row['minor_id'],
					$row['type_id'], $row['teac_name'], $row['start'], $row['end`']));
	}
	
	public function mPrint()
	{
		foreach($this->vElem as $elem)
			echo $elem->mPrint()."<br>";
	}
}
?>