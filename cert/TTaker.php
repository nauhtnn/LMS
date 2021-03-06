<?php
require_once('../AList.php');
require_once('TestType.php');
class TTaker {
	public $testType;
	public $testDate;
	public $weakID;
	public $name;
	public $accentInsensitiveName;
	public $birthdate;
	public $birthplace;
	public static function NewWith($testType, $testDate, $weakID, $name, $birthdate, $birthplace) {
		$it = new self();
		$it->testType = $testType;
		$it->testDate = $testDate;
		$it->weakID = $weakID;
		$it->name = $name;
		//op_rem	$it->accentInsensitiveName = remove_accents($it->name);
		$it->birthdate = $birthdate;
		$it->birthplace = $birthplace;
		return $it;
	}
	public function Generate() {
		$this->testType = 5;
		$this->testDate = "2020-01-01";
		$this->weakID = 0;
		$this->name = "gen";
		$this->accentInsensitiveName = "gen";
		$this->birthdate = "2019-01-01";
		$this->birthplace = "LA";
	}
	public function Parse1($s) {
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if ($n < 5) {
			Generate();
			return;
		}
		$this->testType = $tokens[0];
		$this->testDate = $tokens[1];
		$this->weakID = $tokens[2];
		$this->name = lms_trim(str_ireplace('\'', '\\\'', substr($tokens[3], 0, 64)));
		$this->accentInsensitiveName = remove_accents($this->name);
		$this->birthdate = $tokens[4];
		$this->birthplace = lms_trim(str_ireplace('\'', '\\\'', substr($tokens[5], 0, 64)));
	}
	public function PrintText() {
		return $this->testType."|".$this->weakID."|".$this->name."|".$this->birthdate.
			"|".$this->birthplace."|".$this->testDate;
	}
	
	public function PrintRow() {
		return '<tr><td>'.TestType::NAME[$this->testType].'</td><td>'.$this->testDate.'</td><td>'.
			TestType::PREFIX[$this->testType].$this->weakID.'</td><td class="td0">'.$this->name.
			'</td><td>'.$this->birthdate.'</td><td class="td0">'.$this->birthplace.'</td></tr>';
	}
	
	public function PrintTablePrefix() {
		return '<table border=1 style="border-collapse:collapse"><tr><th>Test type</th><th>Test date</th><th>ID of taker</th><th>Name</th><th>Birthdate</th>'.
			'<th>Birthplace</th></tr>';
	}
	
	public function PrintTablePostfix() {
		return '</table>';
	}
}

class TTakerList extends AList {
	private $selectQryCriteria;
	
	protected function CreateElem() {
		return new TTaker();
	}
	
	public function MkInsQry() {
		$sql = "INSERT INTO lms_test_taker(tt_testType, tt_testDate, tt_weakID,
			tt_name, tt_name_ai, tt_birthdate, tt_birthplace) VALUES ";
		
		foreach($this->vElem as $elem)
			$sql .= "(".$elem->testType.",'".$elem->testDate."',".$elem->weakID.",'".
				$elem->name."','".$elem->accentInsensitiveName."','".$elem->birthdate."','".$elem->birthplace."'),";
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	
	public function SetCriteria4SelectQry($v) {
		$this->selectQryCriteria = $v;
	}
	
	public function MkSelQry() {
		return "SELECT * FROM lms_test_taker".$this->selectQryCriteria;
	}
	
	protected function ProcSelQry($result)
	{
		$this->vElem = array();
		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc()) {
				array_push($this->vElem, TTaker::NewWith($row['tt_testType'], $row['tt_testDate'], $row['tt_weakID'],
					$row['tt_name'], $row['tt_birthdate'], $row['tt_birthplace']));
			}
	}
};
?>