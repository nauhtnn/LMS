<?php
class Student {
	//public $hash_name;
	public $name;
	public $birthday;
	public $phone;
	public $tuition = "false";
	public function Parse($s) {
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
		{
			$this->name = $tokens[0];
			//$this->hash_name = md5($this->name, true);
		}
		if (1 < $n)
			$this->birthday = $tokens[1];
		if (2 < $n)
			$this->phone = $tokens[2];
		if (3 < $n)
			$this->tuition = $tokens[3];
	}
	public function mPrint() {
		echo $this->name."|".$this->birthday."|".$this->phone."|".$this->tuition;//."|".$this->hash_name;
	}
}

class StudentList {
	public $vElem;
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		while ($token !== false)
		{
			$stu = new Student();
			$stu->Parse($token);
			array_push($this->vElem, $stu);
			$token = strtok("\n");
		}
	}
	
	public function mPrint()
	{
		if(0 < count($this->vElem))
			foreach($this->vElem as $stu)
				echo $stu->mPrint()."<br>";
		else
			echo "No student has been found!";
	}
};
?>