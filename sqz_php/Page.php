<?php
require_once 'Settings.php';
class Page
{
	public $mSt;
	public function Page(){
		$this->$mSt = new Settings;
	}
	public function WriteHeader(){
		if ($this->$mSt->$bDIV)
			$this->WriteHdrDIV();
	}
	public function WriteHdrDIV(){
		echo "<!DOCTYPE html><html><head><meta charset='utf-8'/><script src='sQz.js'>".
			"</script><link rel='stylesheet' type='text/css' href='sQz.css'></head>".
			"<body onload='setCell()'>";
	}
	public function WriteFooter(){
		echo "</body></html>";
	}
	public function WriteFormHeader($nQuest){
		echo "<form><div id='lp'><div class='tit2'>Answer Sheet</div><div id='sht'>" .
			"<table id='ans'><tr><th class='o i'></th><th>A</th><th>B</th><th>C</th>" .
			"<th>D</th></tr>";
		//if 0 < $nQuest
		$buf = null;
		$s = "<tr><td>";
		$e = "</td><td></td><td></td><td></td><td></td></tr>\n";
		for ($i = 0; $i < $nQuest;)
			$buf = $buf + $s + (++$i) + $e;
		$buf .= "</table></div><input type='button'class='btn btn1'" .
		"onclick='score()'value='Submit'><input type='button'" .
		"class='btn'onclick='showAnswer()'value='Ans Keys'>" .
		"</div><div class='bp'></div>";
		echo $buf;
	}
	public function WriteFormFooter(){
		echo "</form>";
	}
}
?>
