<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("Course.php");

$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$vCrs = new CourseList();
$vCrs->Parse($dat);
$vCrs->mPrint();
$vCrs->Ins();
header('Location: coursePage.php', true, 301);
exit();
?>