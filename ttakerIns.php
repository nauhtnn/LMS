<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("TTaker.php");

$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$v = new TTakerList();
$v->Parse($dat);
echo $v->MkInsQry();
echo $v->Ins();
// header('Location: index2.php', true, 301);
// exit();
?>