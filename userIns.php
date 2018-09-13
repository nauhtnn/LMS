<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("User.php");

$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$v = new UserList();
$v->Parse($dat);
$v->mPrint();
$v->Ins();
header('Location: userPage.php', true, 301);
exit();
?>