<?php
require_once('AList.php');
class TTaker {
	public $name;
	public $birthDt;
	public $birthPlace;
	public $testDt;
	public $passed;
	public $testType;
	public $tid;
	public static function NewWith($name, $birthDt, $birthPlace,
		$testDt, $passed, $testType, $tid) {
		$it = new self();
		$it->name = $name;
		$it->birthDt = $birthDt;
		$it->birthPlace = $birthPlace;
		$it->testDt = $testDt;
		$it->passed = $passed;
		$it->testType = $testType;
		$it->tid = $tid;
		// $it->mPrint1();
		return $it;
	}
	public function Generate() {
		$name = "gen";
		$birthDt = "2019-01-01";
		$birthPlace = "LA";
		$testDt = "2020-01-01";
		$passed = 0;
		$testType = 5;
		$tid = 0;
	}
	public function Parse1($s) {
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if ($n < 7) {
			Generate();
			return;
		}
		$this->name = $tokens[0];
		$this->birthDt = $tokens[1];
		$this->birthPlace = $tokens[2];
		$this->testDt = $tokens[3];
		$this->passed = $tokens[4];
		$this->testType = $tokens[5];
		$this->tid = $tokens[6];
	}
	public function mPrint1() {
		echo $this->testType."|".$this->tid."|".$this->name."|".$this->birthDt.
			"|".$this->birthPlace."|".$this->testDt."|".$this->passed;
	}
	
	public function mPrint2Row() {
		echo '<tr><td>'.$this->testType.'</td><td>'.$this->tid.'</td><td>'.$this->name.'</td><td>'.$this->birthDt.
			'</td><td>'.$this->birthPlace.'</td><td>'.$this->testDt.'</td><td>'.$this->passed.'</td></tr>';
	}
	
	public function mPrintTableHeader() {
		echo '<table border=1><tr><td>Test type</td><td>ID</td><td>Name</td><td>Birthdate</td><td>Birthplace</td>'.
			'<td>test date</td><td>Passed / Failed</td></tr>';
	}
	
	public function mPrintTableFooter() {
		echo '</table>';
	}
}

class TTakerList extends AList {
	private $selectQryCriteria;
	
	protected function CreateElem() {
		return new TTaker();
	}
	
	public function MkInsQry() {
		$sql = "INSERT INTO lms_ttaker(tt_name, tt_birthDt, tt_birthPlace,
			tt_testDt, tt_passed, tt_testType, tt_id) VALUES ";
		
		foreach($this->vElem as $elem)
			$sql .= "('".$elem->name."','".$elem->birthDt."','".$elem->birthPlace."','".
				$elem->testDt."',".$elem->passed.",".$elem->testType.",".$elem->tid."),";
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	
	public function SetCriteria4SelectQry($v) {
		$this->selectQryCriteria = $v;
	}
	
	public function MkSelQry() {
		return "SELECT * FROM lms_ttaker".$this->selectQryCriteria;
	}
	
	protected function ProcSelQry($result)
	{
		$this->vElem = array();
		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc()) {
				// echo $row['tt_name'].'\n';
				array_push($this->vElem, TTaker::NewWith($row['tt_name'], $row['tt_birthDt'], $row['tt_birthPlace'],
					$row['tt_testDt'], $row['tt_passed'], $row['tt_testType'], $row['tt_id']));
			}
	}
};
?>