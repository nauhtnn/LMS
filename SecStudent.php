<?php
require_once('AList.php');
class SecStudent {
	private $stu_id;
	private $name;
	private $birthday;
	private $phone;
	private $revision;
	private $bNew;
	public function IsNew() {
		return false;//$bNew;
	}
	public function SetID($id) {
		$this->id = $id;
	}
	public function ID($id) {
		return $this->id;
	}
	public function SetRevision($r) {
		$this->revision = $r;
	}
	public function Revision($r) {
		return $this->revision;
	}
	public function Parse1($s) {
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
	public function mPrint1() {
		echo $this->stu_id."|".$this->name."|".$this->birthday."|".$this->phone;
	}
}