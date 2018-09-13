<?php
require_once('User.php');

$v = new UserList();
$v->Sel();

echo '<!DOCTYPE html><html><body>
<form action="userIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form>';
$v->mPrint();
echo '</body></html>';
?>