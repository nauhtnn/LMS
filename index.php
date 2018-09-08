<?php
require_once("Student.php");

$fname = "webdictionary.txt";
$myfile = fopen($fname, "r") or die("Unable to open file!");
$dat = fread($myfile, filesize($fname));
fclose($myfile);

$token = strtok($dat, "\n");
while ($token !== false)
{
	$student = new Student();
	$student->Parse($token);
	echo $student->mPrint()."<br>";
	$token = strtok("\n");
}
?> 