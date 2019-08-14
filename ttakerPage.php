<?php
require_once('User.php');
echo '<!DOCTYPE html><html><body>'.$usr->getName().'<br>
<form action="ttakerIns.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="submit" name="submit">
</form></body></html>';
?>