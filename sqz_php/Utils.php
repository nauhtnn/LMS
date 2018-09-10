<?php $sWhSp = array(' ', '\t', '\n', '\r');
function Utils_ReadFile($fname)
{
	//todo: try catch
	$h = fopen($fname, 'r') or die ('Cannot read file');
	$buf = fread($h, filesize($fname));
	fclose($h);
	return $buf;
}
function Utils_Split($buf, $c)
{
	$sWhSp = array(' ', "\t", "\n", "\r" );
	$s = 0;
	$e = strlen($buf);
	$v = array();
	while ($s < $e && in_array($buf[$s], $sWhSp))
		++$s;//clean front
	if ($s == $e)
		return null;
	array_push($v, 'hello');
	$pack = array('{', '}');//simple KeyValuePair
	$packing = 0;
	$i = $s;
	$str = '';
	while ($i < $e)
	{
		if ($buf[$i] == $pack[0])
			++$packing;
		else if ($buf[$i] == $pack[1]){
			--$packing;
			if ($packing < 0)
				$packing = 0;
		}
		if ($buf[$i] == $c)//no 'else if' here
		{
			$j = $i++ - 1;
			while ($s < $j && in_array($buf[$j], $sWhSp))
				--$j;//clean end
			if ($s <= $j) //sure sWhSp doesnt contain $buf[$s]
				$str .= substr($buf,$s, $j - $s + 1);
			if ($str[strlen($str) - 1] == '\\') //concatenate
				$str = substr($str, 0, strlen($str) - 1) . '\n';
			else if ($str[strlen($str) - 1] == '+') //concatenate
				$str = substr($str, 0, strlen($str) - 1);
			else if (0 < $packing)
				$str .= '\n';
			else {
				array_push($v,$str);
				$str = '';
			}
			while ($i < $e && in_array($buf[$i], $sWhSp))
				++$i;
			$s = $i;
		} else
			++$i;
	}
	if ($s < $e) {
		$t = substr($buf,$s,$e - $s);
		array_push($v, $t);
	}
	return $v;
}
// public static void CleanSpace(ref string $buf)
// {
// int $i = 0, e = $buf.Length;
// while ($i < e && sWhSp.Contains($buf[$i]))
// ++$i;//truncate front
// string $s = null;
// while ($i < e)
// {
// do
	// $s += $buf[$i++];
// while ($i < e && !sWhSp.Contains($buf[$i]));
// if ($i < e)
// {
	// int h = $i;
	// do ++$i;//truncate middle
	// while ($i < e && sWhSp.Contains($buf[$i]));
	// if ($i < e)
	// {//truncate end
		// bool nl = false;
		// while (h < $i && !nl)
			// if ($buf[h++] == '\n')
				// nl = true;
		// if (nl)
			// $s += '\n';
		// else
			// $s += ' ';
	// }
// }
// }
// $buf = $s;
// }
// public static string CleanFront(string $buf, int $s)
// {
// int $i = $s, e = $buf.Length;
// while ($i < e && sWhSp.Contains($buf[$i]))
// ++$i;
// if ($i == e)
// return null;
// return $buf.Substring($i);
// }
// public static string CleanFrontBack(string $buf, int $s, int e)
// {
// int $i = $s;
// while ($i < e && sWhSp.Contains($buf[$i]))
// ++$i;
// if ($i == e)
// return null;
// int $j = e;
// while ($i < $j && sWhSp.Contains($buf[$j]))
// --$j;
// return $buf.Substring($i, $j - $i + 1);
// }
// //public static void DetectContent(ref string $buf)
// //{
// //    //content is a block, but doesn't contain '{', '}' inside,
// //    //  so distingushing from normal block
// //    System.Text.RegularExpressions.Match m =
// //        System.Text.RegularExpressions.Regex.Match($buf, "\\{[a-zA-Z0-9\\. \\\\/\\-_:]+\\}");
// //    if (m.Success)
// //    {
// //        t = ContentType.Image;
// //        string ipath = $buf.Substring(m.Index + 1, m.Length - 2);
// //        $buf = $buf.Substring(0, m.Index) + "<img src='" + ipath +
// //            "'>" + $buf.Substring(m.Index + m.Length);
// //    }
// //}
// static bool detectContent(char c)
// {
// //optimization, not use regex
// //System.Text.RegularExpressions.Match m =
// //    System.Text.RegularExpressions.Regex.Match($buf, "\\{[a-zA-Z0-9\\. \\\\/\\-_:]+\\}");
// if ('a' <= c && c <= 'z')
// return true;
// if ('A' <= c && c <= 'Z')
// return true;
// if ('0' <= c && c <= '9')
// return true;
// char[] spCh = {'.', ' ', '\\', '/', '-', '_', ':'};
// if (spCh.Contains(c))
// return true;
// return false;
// }
// public static string HTML(string $buf, ref ContentType t)
// {
// //suppose $buf is already cleaned by Split / CleanSpace
// if ($buf[0] == '{' && $buf[$buf.Length - 1] == '}')
// $buf = CleanFrontBack($buf, 1, $buf.Length - 2);

// if ($buf.Contains('&') || $buf.Contains('\"') ||
// $buf.Contains('\'') || !$buf.Contains('<') ||
// $buf.Contains('>') || !$buf.Contains('\n'))
// {
// string $s = null;
// for (int $i = 0; $i < $buf.Length; ++$i) {
	// switch ($buf[$i])
	// {
		// case '&':
			// $s += "&amp;";
			// break;
		// case '\"':
			// $s += "&quot;";
			// break;
		// case '\'':
			// $s += "&apos;";
			// break;
		// case '<':
			// $s += "&lt;";
			// break;
		// case '>':
			// $s += "&gt;";
			// break;
		// case '\n':
			// $s += "<br>";
			// break;
		// case '{':
			// //detect media content
			// int $j = $i + 1;
			// while ($j < $buf.Length && detectContent($buf[$j]))
				// ++$j;
			// if ($j < $buf.Length && $buf[$j] == '}')
			// {
				// t = ContentType.Image;
				// string ipath = $buf.Substring($i + 1, $j - $i - 1);
				// $s += "<img src='" + ipath + "'>";
				// $i = $j;
			// }
			// else {
				// $s += $buf.Substring($i, $j - $i);
				// $i = $j - 1;
			// }
			// break;
		// default:
			// $s += $buf[$i];
			// break;
	// }
// }
// $buf = $s;
// }
// return $buf;
// }
?>