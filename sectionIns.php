<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("Course.php");

$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$course = new Course(0, 0, 0, 0, 0, 0);
$course->Parse($dat);
$course->mPrint();
$course->Ins();
header('Location: coursePage.php', true, 301);
exit();
?>