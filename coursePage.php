<?php
require_once('Course.php');

$vCrs = new CourseList();
$vCrs->Sel();

echo '<!DOCTYPE html><html><body>
<form action="courseIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form>';
$vCrs->mPrint();
echo '</body></html>';
?>