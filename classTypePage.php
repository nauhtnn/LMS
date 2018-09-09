<?php
require_once('ClassType.php');

$vClassType = new ClassTypeList();
$vClassType->Sel();

echo '<!DOCTYPE html><html><body>
<form action="classTypeIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form>';
$vClassType->mPrint();
echo '</body></html>';
?>