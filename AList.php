<?php
require_once('DBConn.php');
abstract class AList {
	protected $vElem;	
	abstract protected function CreateElem();
	abstract protected function ProcSelQry($result);
	abstract public function MkInsQry();//todo: protected
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		while ($token !== false)
		{
			$elem = $this->CreateElem();
			$elem->Parse1($token);
			array_push($this->vElem, $elem);
			$token = strtok("\n");
		}
	}
	public function PrintText()
	{
		if(0 < count($this->vElem))
		{
			$s = "";
			foreach($this->vElem as $elem)
				$s = $s.$elem->PrintText()."<br>";
			return $s;
		}
		else
			return "No elem has been found!";
	}
	public function PrintTable()
	{
		if(0 < count($this->vElem))
		{
			$s = $this->vElem[0]->PrintTablePrefix();
			foreach($this->vElem as $elem)
				$s = $s.$elem->PrintRow();
			return $s.$this->vElem[0]->PrintTablePostfix();
		}
		else
			return "No elem has been found!";
	}
	public function Sel() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$result = $conn->query($this->MkSelQry());
		
		$this->ProcSelQry($result);
		$conn->close();
	}
	public function Ins() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		if ($conn->query($this->MkInsQry()) === TRUE) {
			return "New records created successfully";
		} else {
			return "Error: " . $conn->error;
		}
		$conn->close();
	}
}
?>