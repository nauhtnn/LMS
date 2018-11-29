<?php
class DBConn
{
	public static function Conn()
	{
		$servername = "localhost";
		$username = "root";
		$password = "1234";
		$dbname = "lms";
		return new mysqli($servername, $username, $password, $dbname);
	}
};
//partly from WordPress
function remove_accents( $string ) {
	if ( !preg_match('/[\x80-\xff]/', $string) )
		return $string;
	$chars = array(
	// Decompositions for Latin-1 Supplement
	'À' => 'A', 'Á' => 'A',
	'Â' => 'A', 'Ã' => 'A',
	'È' => 'E', 'É' => 'E',
	'Ê' => 'E', 'Ë' => 'E',
	'Ì' => 'I', 'Í' => 'I',
	'Ð' => 'D', 'Ñ' => 'N',
	'Ò' => 'O', 'Ó' => 'O',
	'Ô' => 'O', 'Õ' => 'O',
	'Ö' => 'O', 'Ù' => 'U',
	'Ú' => 'U', 'Û' => 'U',
	'Ü' => 'U', 'Ý' => 'Y',
	'à' => 'a', 'á' => 'a',
	'â' => 'a', 'ã' => 'a',
	'è' => 'e', 'é' => 'e',
	'ê' => 'e', 'ë' => 'e',
	'ì' => 'i', 'í' => 'i',
	'ò' => 'o', 'ó' => 'o',
	'ô' => 'o', 'õ' => 'o',
	'ù' => 'u', 'ú' => 'u',
	'û' => 'u', 'ü' => 'u',
	'ý' => 'y', 'þ' => 'th',
	'ÿ' => 'y', 'Ø' => 'O',
	// Decompositions for Latin Extended-A
	'Ā' => 'A', 'ā' => 'a',
	'Ă' => 'A', 'ă' => 'a',
	'Ą' => 'A', 'ą' => 'a',
	'Đ' => 'D', 'đ' => 'd',
	'Ē' => 'E', 'ē' => 'e',
	'Ĕ' => 'E', 'ĕ' => 'e',
	'Ė' => 'E', 'ė' => 'e',
	'Ĩ' => 'I', 'ĩ' => 'i',
	'Į' => 'I', 'į' => 'i',
	'İ' => 'I', 'ı' => 'i',
	'ĺ' => 'l', 'Ļ' => 'L',
	'Ő' => 'O', 'ő' => 'o',
	'Ũ' => 'U', 'ũ' => 'u',
	'Ū' => 'U', 'ū' => 'u',
	'Ŭ' => 'U', 'ŭ' => 'u',
	'Ů' => 'U', 'ů' => 'u',
	'Ű' => 'U', 'ű' => 'u',
	'Ų' => 'U', 'ų' => 'u',
	// Vowels with diacritic (Vietnamese)
	// unmarked
	'Ơ' => 'O', 'ơ' => 'o',
	'Ư' => 'U', 'ư' => 'u',
	// grave accent
	'Ầ' => 'A', 'ầ' => 'a',
	'Ằ' => 'A', 'ằ' => 'a',
	'Ề' => 'E', 'ề' => 'e',
	'Ồ' => 'O', 'ồ' => 'o',
	'Ờ' => 'O', 'ờ' => 'o',
	'Ừ' => 'U', 'ừ' => 'u',
	'Ỳ' => 'Y', 'ỳ' => 'y',
	// hook
	'Ả' => 'A', 'ả' => 'a',
	'Ẩ' => 'A', 'ẩ' => 'a',
	'Ẳ' => 'A', 'ẳ' => 'a',
	'Ẻ' => 'E', 'ẻ' => 'e',
	'Ể' => 'E', 'ể' => 'e',
	'Ỉ' => 'I', 'ỉ' => 'i',
	'Ỏ' => 'O', 'ỏ' => 'o',
	'Ổ' => 'O', 'ổ' => 'o',
	'Ở' => 'O', 'ở' => 'o',
	'Ủ' => 'U', 'ủ' => 'u',
	'Ử' => 'U', 'ử' => 'u',
	'Ỷ' => 'Y', 'ỷ' => 'y',
	// tilde
	'Ẫ' => 'A', 'ẫ' => 'a',
	'Ẵ' => 'A', 'ẵ' => 'a',
	'Ẽ' => 'E', 'ẽ' => 'e',
	'Ễ' => 'E', 'ễ' => 'e',
	'Ỗ' => 'O', 'ỗ' => 'o',
	'Ỡ' => 'O', 'ỡ' => 'o',
	'Ữ' => 'U', 'ữ' => 'u',
	'Ỹ' => 'Y', 'ỹ' => 'y',
	// acute accent
	'Ấ' => 'A', 'ấ' => 'a',
	'Ắ' => 'A', 'ắ' => 'a',
	'Ế' => 'E', 'ế' => 'e',
	'Ố' => 'O', 'ố' => 'o',
	'Ớ' => 'O', 'ớ' => 'o',
	'Ứ' => 'U', 'ứ' => 'u',
	// dot below
	'Ạ' => 'A', 'ạ' => 'a',
	'Ậ' => 'A', 'ậ' => 'a',
	'Ặ' => 'A', 'ặ' => 'a',
	'Ẹ' => 'E', 'ẹ' => 'e',
	'Ệ' => 'E', 'ệ' => 'e',
	'Ị' => 'I', 'ị' => 'i',
	'Ọ' => 'O', 'ọ' => 'o',
	'Ộ' => 'O', 'ộ' => 'o',
	'Ợ' => 'O', 'ợ' => 'o',
	'Ụ' => 'U', 'ụ' => 'u',
	'Ự' => 'U', 'ự' => 'u',
	'Ỵ' => 'Y', 'ỵ' => 'y',
	);
	$accentInsensitiveStr = strtr($string, $chars);
	if(iconv('UTF-8','WINDOWS-1252//IGNORE', $accentInsensitiveStr))
		error_log('Cannot convert to ANSI: '.$string);
	return $accentInsensitiveStr;
}?>