<?php
if($_SERVER['REQUEST_URI'] == '/c' || $_SERVER['REQUEST_URI'] == '/cert') {
	require('ttakerIndex.php');
} else
	echo 'LMS index';
?>