<?php
require_once('TTaker.php');

$v = new TTakerList();
if(isset($_GET['tt_name'])) {
	$v->SetCriteria4SelectQry(" WHERE tt_name_ai LIKE '%".remove_accents($_GET['tt_name'])."%'");
	unset($_GET['tt_name']);
	echo $v->MkSelQry();
	$v->Sel();
}

echo '<!DOCTYPE html><html><body>
<form action="index2.php" method="get">
    Name to search:
    <input type="text" name="tt_name">
    <input type="submit" name="submit">
</form>';
$v->PrintTable();
echo '</body></html>';
?>