<?php
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK
	|| !is_uploaded_file($_FILES['fileToUpload']['tmp_name']))
{
	echo "file upload error";
	exit();
}

require_once("Section.php");
$dat = file_get_contents($_FILES['fileToUpload']['tmp_name']);
$v = new SectionList();
$v->Parse($dat);
$v->SetUsr($_POST['usr_id'], $_POST['usr_dt'], $_POST['usr_comment']);
$v->mPrint();
// $v->Ins();
// header('Location: sectionPage.php', true, 301);
// exit();
?>