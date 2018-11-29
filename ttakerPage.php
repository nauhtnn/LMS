<?php
require_once('TTaker.php');
$v = new TTakerList();
$v->Sel();

echo '<!DOCTYPE html><html><body>
<form action="ttakerIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form>';
$v->PrintTable();
echo '</body></html>';
?>