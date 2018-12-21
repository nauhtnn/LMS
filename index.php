<?php
require_once('TTaker.php');

function checkRadioIT($checked, $html) {
	if($checked)
	{
		$html = str_replace('__radio_IT_checked', 'checked', $html);
		$html = str_replace('__radio_EN_checked', '', $html);
	}
	else
	{
		$html = str_replace('__radio_IT_checked', '', $html);
		$html = str_replace('__radio_EN_checked', 'checked', $html);
	}
	return $html;
}

$page = file_get_contents('idx_tempt.html');
$page = str_replace('__target', 'index.php', $page);

$v = new TTakerList();
$searchCriteria = "";
if(isset($_GET['tt_name'])) {
	$keyword = htmlspecialchars(lms_trim(remove_accents($_GET['tt_name'])));
	$searchCriteria = "tt_name_ai LIKE '%".$keyword."%'";
	$page = str_replace('__name2search', $keyword, $page);
}
else
	$page = str_replace('__name2search', '', $page);

if(isset($_GET['excludedTest'])) {
	if($searchCriteria != "")
		$searchCriteria = $searchCriteria." AND ";
	if($_GET['excludedTest'] == "IT") {
		$searchCriteria = $searchCriteria." tt_testType < 3";
		$page = checkRadioIT(true, $page);
	}
	else {
		$searchCriteria = $searchCriteria." 2 < tt_testType";
		$page = checkRadioIT(false, $page);
	}
}
else
	$page = checkRadioIT(false, $page);	

if($searchCriteria != "")
{
	$v->SetCriteria4SelectQry(" WHERE ".$searchCriteria." ORDER BY tt_name");
	$v->MkSelQry();
	$v->Sel();
	$page = str_replace('__searchResult', $v->PrintTable(), $page);
}
else
	$page = str_replace('__searchResult', '', $page);
	
echo $page;
?>