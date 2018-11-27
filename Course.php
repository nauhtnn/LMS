<?php
require_once('AList.php');

class Course {
	public $code;
	public $title;
	public $nPeriod;
	
	public static function NewWith($code, $title, $nPeriod)
	{
		$it = new self();
		$it->code = $code;
		$it->title = $title;
		$it->nPeriod = $nPeriod;
		return $it;
	}
	
	public function Parse1($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->code = $tokens[0];
		if (1 < $n)
			$this->title = $tokens[1];
		if (2 < $n)
			$this->nPeriod = $tokens[2];
	}
	
	public function mPrint1()
	{
		echo $this->code."|".$this->title."|".$this->nPeriod;
	}
}

class CourseList extends AList
{
	protected function CreateElem()
	{
		return new Course();
	}
	
	protected function MkInsQry() {
		$sql = "INSERT INTO lms_course VALUES ";
		foreach($this->vElem as $elem)
			$sql .= "(".$elem->code.",'".$elem->title."',".$elem->nPeriod."),";
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	
	protected function MkSelQry() {
		return "SELECT crs_code, crs_title, crs_n_period FROM lms_course";
	}
	
	protected function ProcSelQry($result) {
		$this->vElem = array();
		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($this->vElem, Course::NewWith($row['crs_code'], $row['crs_title'], $row['crs_n_period']));
	}
}
?>