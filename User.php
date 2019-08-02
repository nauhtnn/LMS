<?php
if(session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once('DBConn.php');
class User {
	private $id;
	private $name;
	private $pw;
	private $type;
	private $isAuth;
	public function __construct() { $this->isAuth = false; }
	public function getName() { return $this->name; }
	public function getType0() { return $this->type; }
	public function getAuth() { return $this->isAuth; }
	public static function NewWith($id, $name, $pw, $type) {
		$it = new self();
		$it->id = $id;
		$it->name = $name;
		$it->pw = $pw;
		$it->type = $type;
		return $it;
	}
	private function RetrieveUser($qry) {
		$conn = DBConn::Conn();
		if ($conn->connect_error)
			return;
		$result = $conn->query($qry);
		if($result == null) {
			die('Error description: '.mysqli_error($conn));
		}
		if ($result->num_rows == 1){
			$row = $result->fetch_assoc();
			$this->id = $row['usr_id'];
			$this->name = $row['usr_name'];
			$this->type = $row['usr_type'];
			$this->isAuth = true;
		}
	}
	public function Authenticate() {
		if(isset($_COOKIE['usr']) && isset($_SESSION[$_COOKIE['usr'].'_'.hash('sha256', $_SERVER['HTTP_USER_AGENT'])])) {
			$this->RetrieveUser('SELECT * FROM lms_user WHERE usr_id="'.$_COOKIE['usr'].'"');
			return;//todo
		}
		if(isset($_POST['usr']) && isset($_POST['pw'])){
			$this->RetrieveUser('SELECT * FROM lms_user WHERE usr_id="'.$_POST['usr'].'" AND usr_pw="'.hash('sha256',$_POST['pw']).'"');
			if($this->isAuth) {
				$_SESSION[$_POST['usr'].'_'.hash('sha256', $_SERVER['HTTP_USER_AGENT'])] = 1;
				setcookie('usr', $_POST['usr'], time() + (86400 * 30));
			}
		}
	}
};
?>