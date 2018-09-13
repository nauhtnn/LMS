<?php
require_once('DBConn.php');
abstract class AList {
	protected $vElem;
	
	abstract protected function CreateElem();
	abstract protected function MkInsQry();
	abstract protected function MkSelQry();
	abstract protected function ProcSelQry($result);
	
	public function Parse($s)
	{
		$this->vElem = array();
		$token = strtok($s, "\n");
		while ($token !== false)
		{
			$elem = $this->CreateElem();
			$elem->Parse($token);
			array_push($this->vElem, $elem);
			$token = strtok("\n");
		}
	}
	public function mPrint()
	{
		if(0 < count($this->vElem))
			foreach($this->vElem as $elem)
				echo $elem->mPrint()."<br>";
		else
			echo "No elem has been found!";
	}
	
	public function Ins() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = $this->MkInsQry();

		if ($conn->query($sql) === TRUE) {
			echo "New records created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();
	}
	
	public function Sel() {
		$conn = DBConn::Conn();
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = $this->MkSelQry();
		$result = $conn->query($sql);
		
		$this->ProcSelQry($result);
	}
}
?>