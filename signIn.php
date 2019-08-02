<?php
require_once('User.php');
$usr = new User();
$usr->Authenticate();
if($usr->getAuth()) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

$page = file_get_contents('signIn_tempt.html');
if(isset($_POST['usr']))
	$page = str_replace('usr"', 'usr" value="'.$_POST['usr'].'"', $page);
if(isset($_POST['pw']))
	$page = str_replace('pw"', 'pw" value="'.$_POST['pw'].'"', $page);
echo $page;
?>