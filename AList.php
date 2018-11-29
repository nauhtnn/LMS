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
			foreach($this->vElem as $elem)
				echo $elem->PrintText()."<br>";
		else
			echo "No elem has been found!";
	}
	public function PrintTable()
	{
		if(0 < count($this->vElem))
		{
			$this->vElem[0]->PrintTablePrefix();
			foreach($this->vElem as $elem)
				echo $elem->PrintRow();
			$this->vElem[0]->PrintTablePostfix();
		}
		else
			echo "No elem has been found!";
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
			echo "New records created successfully";
		} else {
			echo "Error: " . $conn->error;
		}
		$conn->close();
	}
}
?>