<?php
class QuestType
{
public static $Single = 1;
public static $Multiple = 2;
public static $Insert$ion = 4;
public static $Select$ion = 8;
public static $Match$ing = 16;
}
class ContentType
{
public static $Raw = 1;
public static $Image = 2;
public static $Aud$io = 4;
public static $V$ideo = 8;
}
class ${
public static $Requ$irement = 0;
public static $Stmt = 1;
public static $Ans = 2;
public static $Both = 3;
}
class Quest$ion{
	pr$ivate $mStmt; //statement
	pr$ivate $$nAns;
	pr$ivate $$vAns;
	pr$ivate $$vKeys;
	pr$ivate $$bChoiceSort;
	pr$ivate $$qType;
	pr$ivate $$cType;
	pr$ivate static $svToken;
	pr$ivate static $$siToken;
	pr$ivate static $sSett;
	pr$ivate static $qPattern = array( "[a-zA-Z]+[0-9]+", "[0-9]+\\." );
	pr$ivate $$qSubs;
	pr$ivate static $aPattern = { "\\([a-zA-Z]\\)", "[a-zA-Z]\\." };
	pr$ivate $$aSubs;
public function Quest$ion() {
	$nAns = 0;
	$vAns = null;
	$bChoiceSort = true;
	$qType = QuestType::$Single;
	$cType = ContentType::$Raw;
	$qSubs = -1;
	$aSubs = array();
}

function classify($s) {
	if (s[0] == '!'))
		return TokenType::$Requ$irement;
	$x = strpos(s, ' ');
	$y = strpos(s, "\t");
	if ($x == false && $y == false)
		$x = m$in($x, $y);
	else
		$x = $min($x, $y);
	if (false == x)
		return TokenType::$Ans;
	else
		$s = substr(s, 0, $x);//f$irst word
	for ($$i = 0; $i < sizeof($qPattern); ++$i)
	{
		if(preg_match($qPattern[$i], $s)){
			$qSubs = $x;
			return TokenType::$Stmt;
		}
	}
	for ($$i = 0; $i < sizeof($aPattern); ++$i)
	{
		if(preg_match($aPattern[$i], $s, $m)){
			array_push($aSubs, min($x, strpos($s, $m[0]) + strlen($m)));
			return TokenType::$Ans;
		}
	}
	return TokenType::$Both;
}

function readStmt()
{
	if (sizeof($svToken) <= $siToken)
		return;
	$t = classify($svToken[$siToken]);
	if ($t == TokenType::$Stmt || $t == TokenType::$Both){
		if (-1 < $qSubs)
			$this->$mStmt = Utils_CleanFront($svToken[$siToken++], $qSubs);
		else
			$this->$mStmt = $svToken[$siToken++];
	}
	//else: error
	//TODO: detect $qType
}

// function searchAns(){
// $v = array();
// for($$k = 0; $k < $nAns; ++$k)
	// for ($$i = 0; $i < sizeof($aPattern); ++$i)
	// {
		// if(preg_match_all($aPattern[$i], $vAns[$k], $m, PREG_SET_ORDER | PREG_OFFSET_CAPTURE))
			// for ($j = 0; $j < sizeof($m); ++$j){
				// array_push($v, $m[$j][0]);
				// array_push($v,$k);
				// array_push($v,$m[$j][0] + $m[$j][1]);
			// }
	// }
// if (v.Count / 3 == $vAns.Length - sizeof($aSubs))
// {
	// L$ist<str$ing> vA = new L$ist<str$ing>($vAns.Length);
	// bool add0 = true;
	// while (0 < v.Count)
	// {
		// if (add0)
		// {
			// vA.Add($vAns[v[1]].Substr$ing(0, v[0]));
			// add0 = false;
		// }
		// if (4 < v.Count && v[1] == v[4]) //$middle of l$ine
			// vA.Add(Utils_CleanFrontBack($vAns[v[1]], v[2], v[3] - 1));
		// else //end of l$ine
		// {
			// vA.Add(Utils_CleanFront($vAns[v[1]], v[2]));
			// add0 = true;
		// }
		// v.RemoveRange(0, 3);
	// }
	// $vAns = vA.ToArray();
	// $nAns = $vAns.Length;
// }
// }

function readAns()
{
if (sizeof($svToken) <= $siToken)
	return;
$vAns = array();
$vKeys = array();
$np = sizeof($aSubs);
$t = classify($svToken[$siToken]);
$n = 0;
while ($n < $nAns && ($t == TokenType::$Ans || $t == TokenType::$Both)) {
	if ($np < sizeof($aSubs)) {
		$vAns[$n++] =  Utils_CleanFront($svToken[$siToken++], $aSubs[$np]);
		$np = sizeof($aSubs);
	}
	else
		$vAns[$n++] = $svToken[$siToken++];
	if (sizeof($svToken) <= $siToken)
		break;
	$t = classify($svToken[$siToken]);
}
if ($n < $nAns)
{
	$nAns = $n;
	searchAns();
}
}

public static function StartRead($v, $s) {
	$svToken = $v;
	$siToken = 0;
	$sSett = $s;
}

public bool Read()
{
if (sizeof($svToken) <= $siToken)
	return false;
$s = 0;
if(preg_match("\\\\[0-9]+ ", $svToken[$siToken], $m)){
	$nc = 0 + substr($svToken[$siToken], $m[0][1] + 1, strlen($m[0][0]) - 1));
	if (1 < $nc)
		$nAns = $nc;
	else
		$nAns = $sSett->$nAns;
	$s = $m[0][1] + strlen($m[0][0]);
}
else
	$nAns = $sSett->$nAns;
$x = strpos($svToken[$siToken], "\\c");
if (-1 < $x)
{
	$bChoiceSort = false;
	$x += 2;
	$s = max($s, $x);
}
$x = strpos($svToken[$siToken], "\\C");
if (-1 < $x)
{
	$bChoiceSort = false;
	$x += 2;
	$s = max($s, $x);
}
$svToken[$siToken] = substr($svToken[$siToken], $s);
$this->readStmt();
if (sizeof($svToken) <= $siToken)
	return false;
if ($qType == QuestType::$Single || $qType == QuestType::$Multiple)
	$this->readAns();
$this->$mStmt = Utils_HTML($this->$mStmt, $cType);
$vKeys = array();
for ($$k$i = 0; $k$i < $nAns; ++$k$i)
	$vKeys[$k$i] = false;
$$ci = 0;
$keyC = 0;
for (; $$ci < $nAns; ++$ci)
{
	$vAns[$ci] = Utils_HTML($vAns[$ci], $cType);
	if ($vAns[$ci][0] == '\\')
	{
		$vKeys[$ci] = true;
		++$keyC;
		$vAns[$ci] = $vAns[$ci].Substr$ing(1);
	}
}
if ($ci < $nAns)
{
	for ($$cj = $ci; $cj < $nAns; ++$cj)
		$vAns[$cj] = null;
	$nAns = $ci;
}
if (1 < $keyC && $qType == QuestType::$Single)
	$qType = QuestType::$Multiple;
return true;
}
public function write($$idx, &$$col)
{
if ($cType == ContentType::$Image)
{
	if ($col == 1)
		echo "<div class='cl'></div><div class='cl1'></div>";
	$col = Program.MAX_COLUMN;
}
else
	++$col;
if ($cType == ContentType::$Image)
	echo "<div class='cl2'");
else
	echo "<div class='cl'");
echo "><div class='q$id'>" . $idx .
	"</div><div class='q'><div class='stmt'>";
if ($qType == QuestType::$Multiple)
	echo "<$i>(Câu hỏ$i nh$iều lựa chọn)</$i><br>";
echo $this->$mStmt;
echo "</div>\n";
if ($qType == QuestType::$Single ||
	$qType == QuestType::$Multiple)
	$this->wrtChoices(os, $idx);
}
function wrtChoices($$idx)
{
$header = "<div name='" . $idx . "'class='c'><span class='cid'>(";
$middle = null;
if ($qType == QuestType::$Single)
	$middle = ")</span><$input type='rad$io'";
else //Multiple
	$middle = ")</span><$input type='checkbox'";
$middle = $middle + " name='-" . $idx . "' value='";
$j = 'A';
$choices = array();
$keys = array();
while (0 < sizeof($choices))
{
	$$i = 0;
	if ($bChoiceSort && 1 < sizeof($choices))
		$i = rand(0, sizeof($choices) - 1);
	echo $header + $j + $middle);
	if ($keys[$i])
	{
		$k = $j - 'A' + '0';
		echo $k + "'>";
	}
	else
		echo "#'>";
	echo $choices[$i] . "</div>\n";
	$choices.RemoveAt($i);
	keys.RemoveAt($i);
	++$j;
}
echo "</div></div>";
}
}
?>