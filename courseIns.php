<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("Course.php");

$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$v = new CourseList();
$v->Parse($dat);
$v->mPrint();
$v->Ins();
header('Location: coursePage.php', true, 301);
exit();
?>