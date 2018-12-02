<?php
require_once('TTaker.php');

$v = new TTakerList();
$searchCriteria = "";
if(isset($_GET['tt_name'])) {
	$keyword = htmlspecialchars(lms_trim(remove_accents($_GET['tt_name'])));
	$searchCriteria = "tt_name_ai LIKE '%".$keyword."%'";
	unset($_GET['tt_name']);
}

if(isset($_GET['excludedTest'])) {
	if($searchCriteria != "")
		$searchCriteria = $searchCriteria." AND ";
	if($_GET['excludedTest'] == "IT")
		$searchCriteria = $searchCriteria." tt_testType < 3";
	else
		$searchCriteria = $searchCriteria." 2 < tt_testType";
	unset($_GET['excludedTest']);
}

if($searchCriteria != "")
{
	$v->SetCriteria4SelectQry(" WHERE ".$searchCriteria." ORDER BY tt_name");
	$v->MkSelQry();
	$v->Sel();
}

$page = file_get_contents('idx_tempt.html');
$page = str_replace('__target', 'index.php', $page);
$page = str_replace('__searchResult', $v->PrintTable(), $page);
echo $page;
?>