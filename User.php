<?php
require_once('AList.php');
class User {
	public $name;
	public $passw;
	public $type;
	public static function NewWith($name, $passw, $type) {
		$it = new self();
		$it->name = $name;
		$it->passw = $passw;
		$it->type = $type;
		return $it;
	}
	public function Parse($s) {
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->name = $tokens[0];
		if (1 < $n)
			$this->passw = hash('sha256', $tokens[1]);
		if (2 < $n)
			$this->type = $tokens[2];
	}
	public function mPrint() {
		echo $this->name."|".$this->passw."|".$this->type;
	}
}

class UserList extends AList {
	protected function CreateElem() {
		return new User();
	}
	
	protected function MkInsQry() {
		$sql = "INSERT INTO lms_user(usr_name, usr_passw, usr_type) VALUES ";
		
		foreach($this->vElem as $elem)
			$sql .= "('".$elem->name."','".$elem->passw."',".$elem->type."),";
		return substr($sql, 0, strlen($sql) - 1);//remove the last comma
	}
	
	protected function MkSelQry() {
		return "SELECT usr_name, usr_passw, usr_type FROM lms_user";
	}
	
	protected function ProcSelQry($result)
	{
		$this->vElem = array();
		if ($result->num_rows > 0)
			while($row = $result->fetch_assoc())
				array_push($this->vElem, User::NewWith($row['usr_name'], $row['usr_passw'], $row['usr_type']));
	}
};
?>