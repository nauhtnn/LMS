<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("ClassType.php");
$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$vClsType = new ClassTypeList();
$vClsType->Parse($dat);
$vClsType->Ins();
header('Location: classTypePage.php', true, 301);
exit();
?>