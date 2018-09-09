<?php
class ClassType {
	public $id = "0";
	public $name;
	public $nPeriod;
	public function Parse($s)
	{
		$tokens = preg_split("/\t/", $s);
		$n = count($tokens);
		if (0 < $n)
			$this->name = $tokens[0];
		if (1 < $n)
			$this->nPeriod = $tokens[1];
	}
	
	public function mPrint()
	{
		echo $this->id."|".$this->name."|".$this->nPeriod;
	}
}

class ClassTypeList
{
	public $vElem;
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		while ($token !== false)
		{
			$classType = new classType();
			$classType->Parse($token);
			array_push($this->vElem, $classType);
			$token = strtok("\n");
		}
	}
	
	public function mPrint()
	{
		foreach($this->vElem as $cType)
			echo $cType->mPrint()."<br>";
	}
}
?>