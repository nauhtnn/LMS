<?php
require_once('SecStudent.php');
class Section extends AList {
	private $sec_year;
	private $crs_code;
	private $sec_id;
	private $sec_cur_rev;
	private $ins_id;
	private $sec_start;
	private $sec_end;
	private $usr_id;
	private $usr_dt;
	private $usr_comment;
	
	public static function NewWith($sec_year, $crs_code, $sec_id) {
		$it = new self();
		$it->sec_year = $sec_year;
		$it->crs_code = $crs_code;
		$it->sec_id = $sec_id;
		$it->vElem = array();
		return $it;
	}
	public function RtrvSecCont() {
		//qry
		$this->ins_id = $row['ins_id'];
		$this->sec_start = $row['sec_start'];
		$this->sec_end = $row['sec_end'];
		$this->usr_id = $row['usr_id'];
		$this->usr_dt = $row['usr_dt'];
		$this->usr_comment = $row['usr_comment'];
	}
	public function SetUsr($usr_id, $usr_dt, $usr_comment) {
		$this->usr_id = $usr_id;
		$this->usr_dt = $usr_dt;
		$this->usr_comment = $usr_comment;
	}
	public function MatchStu() {
		//todo
	}
	public function BuildStuID() {
		/*crs_code + sec_year + sec_id + #stu = 3 digits + 2 digits + 2 digits + 3 digits*/
		$i = 0;
		foreach($vElem as $elem)
			if(!$elem->IsNew()) {
				$elem->SetID($i + 1000*$this->sec_id + 100000*($this->sec_year % 100) + 10000000*$this->crs_code);
				$i = $i + 1;
			}
	}
	protected function MkNewStuInsQry() {
		$qry = "INSERT INTO lms_student(stu_id) VALUES ";
		foreach($this->vElem as $elem)
			$qry = $qry.'('.$elem->ID().'),';
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	public function BuildStuContRevision() {
		foreach($this->vElem as $elem)
			$elem->revision = 0;//todo
	}
	protected function MkStuContInsQry() {
		$qry = "INSERT INTO lms_student_content(stu_id) VALUES ";
		foreach($this->vElem as $elem)
			$qry = $qry.'('.$elem->ID().'),';
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	private function SecStuRevision($stu_id)
	{
		return 0;//todo
	}
	public function BuildSecStuRevision() {
		foreach($this->vElem as $elem)
			$elem->revision = 0;//todo
	}
	public function MkInsSecStuQry() {
		$qry = "INSERT INTO lms_sec_stu_content VALUES ";
		$prefix = '('.$this->sec_year.','.$this->crs_code.','.$this->sec_id.',';
		$postfix = "',".$this->usr_id.",'".$this->usr_dt."','".$this->usr_comment."'),";
		foreach($this->vElem as $elem)
			$qry = $qry.$prefix.$elem->ID().','.$this->Revision($elem->GetID())."'2018-01-01','2018-12-31','false".$postfix;
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	public function MkInsSecQry() {
		return 'INSERT INTO lms_section VALUES ('.$this->sec_year.','.$this->crs_code.','.$this->sec_id.')';
	}
	public function Parse1($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->sec_year = $tokens[0];
		if (1 < $n)
			$this->crs_code = $tokens[1];
		if (2 < $n)
			$this->sec_id = $tokens[2];
		if (3 < $n)
			$this->ins_id = $tokens[5];
		if (4 < $n)
			$this->sec_start = $tokens[3];
		if (5 < $n)
			$this->sec_end = $tokens[4];
		if (6 < $n)
			$this->ins_id = $tokens[5];
		if (7 < $n)
			$this->usr_id = $tokens[6];
		if (8 < $n)
			$this->usr_dt = $tokens[7];
		if (9< $n)
			$this->usr_comment = $tokens[8];
	}
	protected function CreateElem() {
		return new SecStudent();
	}
	public function mPrint1()
	{
		echo $this->sec_year."|".$this->crs_code."|".$this->sec_id."|".$this->ins_id."|".
			$this->sec_start."|".$this->sec_end."|".$this->usr_id."|".$this->usr_dt."|".$this->usr_comment."<br>";
		$this->mPrint();
	}
}
class SectionList extends AList {
	protected function CreateElem() {
		return new Section();
	}
	public static function MkSelQry() {
		return 'SELECT * FROM lms_section';
	}
	public static function ProcSelQry($instance, $result) {
		$instance->vElem = array();
		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($instance->vElem, Section::NewWith($row['sec_year'], $row['crs_code'], $row['sec_id'],
					$row['sec_cur_rev']));
	}
	public function SetUsr($usr_id, $usr_dt, $usr_comment) {
		foreach($this->vElem as $elem)
			$elem->SetUsr($usr_id, $usr_dt, $usr_comment);
	}
}