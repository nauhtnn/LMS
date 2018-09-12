<?php
require_once('CourseType.php');

$vCrsType = new CourseTypeList();
$vCrsType->Sel();

echo '<!DOCTYPE html><html><body>
<form action="courseTypeIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form>';
$vCrsType->mPrint();
echo '</body></html>';
?>