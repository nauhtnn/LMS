<?php
session_start();
if(isset($_COOKIE['usr'])){
	$key = $_COOKIE['usr'].'_'.hash('sha256', $_SERVER['HTTP_USER_AGENT']);
	if(isset($_SESSION[$key])){
		echo 'session authenticated';
		return;
	}
}
require_once('DBConn.php');
if(isset($_POST['usr']) && isset($_POST['pw'])){
	$conn = DBConn::Conn();
	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	$result = $conn->query('SELECT * FROM lms_user WHERE usr_id="'.$_POST['usr'].'" AND usr_passw="'.hash('sha256',$_POST['pw']).'"');
	if ($result->num_rows == 1){
		$_SESSION[$_POST['usr'].'_'.hash('sha256', $_SERVER['HTTP_USER_AGENT'])] = 1;
		setcookie('usr', $_POST['usr'], time() + (86400 * 30));
		echo 'authenticated';
		return;
	}
	$page = file_get_contents('signIn_tempt.html');
	$page = str_replace('__usr', $_POST['usr'], $page);
	$page = str_replace('__pw', $_POST['pw'], $page);
	echo $page;
	return;
}
echo file_get_contents('signIn_tempt.html');
?>