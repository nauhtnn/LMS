<?php
//require_once("Student.php");
require_once("ClassType.php");

//$fname = "webdictionary.txt";
$fname = "classType.txt";
$myfile = fopen($fname, "r") or die("Unable to open file!");
$dat = fread($myfile, filesize($fname));
fclose($myfile);

// $vStu = new StudentList();
// $vStu->Parse($dat);
// $vStu->mPrint();
$vClsType = new ClassTypeList();
$vClsType->Parse($dat);
$vClsType->mPrint();
?> 