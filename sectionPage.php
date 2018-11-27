<?php
require_once('Section.php');
echo '<!DOCTYPE html><html><body>
<form action="sectionIns.php" method="post" enctype="multipart/form-data">
    <input type="text" name="usr_id" value="0">
	<input type="text" name="usr_dt" value="2018-09-16">
	<input type="text" name="usr_comment" value="thuan,s comment"><br>
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form><br>';
$v = new SectionList();
DBConn::Instance()->Sel(SectionList::MkSelQry(), 'SectionList::ProcSelQry', $v);
$v->mPrint();
echo '</body></html>';
?>