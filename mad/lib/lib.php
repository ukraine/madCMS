<?

error_reporting(E_ALL);

// $ip = "79.165.24.62";

global $parent_id, $baseurl;

// ### Подключение служебных файлов

include "../lib/configs.php";
include "../lib/shared.php";
include "lang/russian.php";

// ### Инициализация переменных

$textarea = "";

$baseurl = substr($siteurl,0,-1);
$siteurl = "/mad/";

// Названия к кнопкам
$ButtonNames = array(
	"add" => $translation['11'],
	"edit" => $translation['73']
);

// Названия разделов
$SectionNames = array(
	"default" => $translation['4'],
	"pages" => $translation['5'],
	"news" => $translation['6'],
	"faq" => $translation['7'],
	"settings" => $translation['2'],
	"files" => $translation['1'],
	"categories" => $translation['14'],
	"developers" => $translation['150'],
	"rates" => $translation['164']
);

// Сортировка только по id для определенных таблиц
$SqlOrderByDefaultById = array(
	"settings",
	"newsletters",
	"subscribers"
);

// Используется для чекбоксов
$checkedOrNot = array("","checked");

// Сортировка по умолчанию
$orderby = "priority";
$ascdesc="DESC";

// Раздел по умолчанию
$parent_id="-1";

// Разрешение на удаление/перенос страниц/ы
$addremove = "1";

// Работа с чекбоксами
$checkbox = array(""," checked");


if (empty($_REQUEST['section'])) $section = "default"; else $section = $_REQUEST['section'];
if (empty($_REQUEST['action'])) $action = "default"; else $action = $_REQUEST['action'];
if (empty($error_msg)) $error_msg = "";
if (isset($_POST['action'])) $action = $_POST['action'];
if (in_array($section,$SqlOrderByDefaultById)) $orderby = "id";

$textEditor = array(

"0" => "simple",
"1" => "CKeditor"

);

// Получение настроек сайта
getSettings();

// Если вдруг сбилась установка кол-ва отображаемых объектов на страницу, ставим 10 по умолчанию
if (empty($Settings['itemsonpage'])) $Settings['itemsonpage']="10";

$textarea = $textEditor[$Settings["advEditor"]];

// Получаем данные о последовательности сортировки
if (!empty($_GET['ascdesc'])) $ascdesc = $_GET['ascdesc'];

// Получаем данные о последовательности сортировки
if (!empty($_GET['parent_id'])) $parent_id = $_GET['parent_id'];

// Если мы находимся в корне, запрещаем удаление и добавление в корень других страниц
if ($parent_id=="-1") $addremove = "0";

// ### Дальше пошел список служебных функций

// Выполнение запроса в БД и получение результирующего массива с данными
function ProcessSQL($sql) { return ExecuteSqlGetArray($sql); }

// Вывод класса для парной строки
// 04.02.2008
function PairedLineOrNot($number, $pair=" class='pair'") {

	if ($number%2 !== 0) $pair="";
	return $pair;

}

// Вспомогательная функция для определения детей ListChildrenIds
function ListChildrenIdsOne($id)
{
	global $db_link, $link;

	$childrens = "";

	$qres = mysqli_query($link, "SELECT `id` FROM `".PREFIX."pages` WHERE $id IN (`parent_id`)");
	while($row = mysqli_fetch_assoc($qres)) {
		$childrens .= $row['id'] . ",";
		$childrens .= ListChildrenIdsOne($row['id']);
	}

	return $childrens;
}


// Определение детей по ID
function ListChildrenIds($ids)
{
	$res = $ids . ',';

	$ids = split(',', $ids);
	foreach($ids as $id)
		$res .= ListChildrenIdsOne($id);

	if(strlen($res))
		return substr($res, 0, -1);
	else
		return $res;
}


// Ограничение видимой области объекта до $limitto символов
function limitVisiblePart($fieldname, $limitto,$threedots = "") {

	global $f; if (strlen($f[$fieldname]) > $limitto) $threedots = "...";
	$fieldname = strip_tags(utf8_substr(stripslashes($f[$fieldname]), 0, $limitto)).$threedots;
	return $fieldname;

}

// Ограничение видимой области объекта до $limitto символов
function limitValueByChars($fieldname, $limitto, $threedots = "")	{
	if (strlen($fieldname) > $limitto) $threedots = "...";
	return strip_tags(utf8_substr(stripslashes($fieldname), 0, $limitto)).$threedots;;
}


function ChangeValue() {

	global $details, $table;

	$details["id"] = $_REQUEST['id'];
	edit_data ($details, $table);

	return 1;

}

function sendmail ($subject, $str="")	{

	global $Settings;

		foreach($_REQUEST as $key=>$val)	{
				$str.="$key : $val \n";
			}
		if(mail($Settings['email'], $subject, $str))	return 1;
		else return 0;
}

// Генерация тега select
// 03.08.2007
function GenerateSelectList($WhatWhatTableToSelect, $nameOfIdentificatorAutoToSelect, $nameofvaluetoshow)	{

	global $link;

	$res = mysqli_query($link, "select * from `".PREFIX."$WhatWhatTableToSelect`");

	$select = "<select name='$nameOfIdentificatorAutoToSelect'>";
	
	while($col = mysqli_fetch_array($res))	{
		$select .= "\t\t<option value='".$col['id']."'";
		$select .= selectv2($nameOfIdentificatorAutoToSelect, $col['id']);
		$select .= ">$col[$nameofvaluetoshow]</option>\n";
	}

	return $select."</select>";

}

// Генерация тега input
// 25.08.2007
function GenerateInputTag($name, $description, $type="text", $separator=" &nbsp; ",$br="<br>")	{

	echo "\n<input 
	type='$type' 
	name='$name' 
	value='" . ifExistValueReturnIt($name) .  "'
	id='label$name'
	> $separator 
	<label for='label$name'>$description</label><br>";

}

// Генерация тега textarea
// 03.10.2007
function GenerateTextAreaTag($name)	{

	echo "<textarea name='$name'>" . ifExistValueReturnIt($name) . "</textarea>";

}


// Автоматически выбирать требуемые поля тега select
// 25.08.2007
/* function selectv2($field, $number)	{
	global $f; if($f[$field] == $number) return " selected";
}*/


function getSettings()	{
	global $Settings; $Settings = ProcessSQL("SELECT * FROM `".PREFIX."settings` WHERE id='1'");
}

function ErrorMsg () {
	global $error_msg; if (!empty($error_msg))	echo "<div class='error_msg'>$error_msg</div>"; 
}

function checkbox($field)	{
	global $f; if($f[$field] == "y") echo " checked";
}

function select($field, $number)	{
	global $f; if($f[$field] == $number) echo " selected";
}

function radiobox($field, $number)	{
	global $f; if($f[$field] == $number) echo " checked";
}

function ifExistValueReturnIt($valuename) {

	global $f;
	
	if (isset($_REQUEST[$valuename])) 
		return $_REQUEST[$valuename]; 
	else return $f[$valuename];
}


function ifExistGetValue($valuename) {

	global $f;
	
	if (isset($_POST[$valuename])) 
		echo $_POST[$valuename]; 
	else echo $f[$valuename];
}

function HighLight($value, $SectionAction) {

	global $section, $action;
	if ($$SectionAction==$value)	echo "id='current'";

}

$copyrights = "2005 - ".date('Y')." &copy;  <a href='$Settings[softurl]'>$Settings[softname] - $translation[115]</a><br>$translation[114] $Settings[sitename]";

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!== "yes")  {
	include "login.php";
	exit();
}

?>