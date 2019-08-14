<?php
if($_SERVER['REQUEST_URI'] == '/c' || $_SERVER['REQUEST_URI'] == '/cert') {
	header('Location: cert/index.php');
} else
	echo 'LMS index';
?>