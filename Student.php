<?php
class Student {
	public $name;
	public $birthday;
	public $phone;
	public $tuition = "false";
	public function Parse($s) {
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->name = $tokens[0];
		if (1 < $n)
			$this->birthday = $tokens[1];
		if (2 < $n)
			$this->phone = $tokens[2];
		if (3 < $n)
			$this->tuition = $tokens[3];
	}
	public function mPrint() {
		echo $this->name."|".$this->birthday."|".$this->phone."|".$this->tuition;
	}
}
?>