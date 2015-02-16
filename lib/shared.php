<?

// Выполняем запрос и получаем массив с требуемыми данными
// 14.07.2007
function ExecuteSqlGetArray($sql) {
	
	global $link;
	return mysqli_fetch_array(mysqli_query($link, $sql));

}

// Подсчет кол-ва значений в таблице
function GetTotalData ($table,$where="") {
	$res = ExecuteSqlGetArray("SELECT COUNT(*) FROM `".PREFIX."$table` $where");
	return $res['0'];
}

// Converting MySQL timestamp to datetime
// 16.09.2007
function ConvertMysqlTimeStamp($time, $separator="-", $seconds=false) {

	$timestamp = substr($time, 6,2).$separator;
	$timestamp .= substr($time, 4,2).$separator;
	$timestamp .= substr($time, 0,4)."&nbsp;";

	if ($seconds) {
		$timestamp .= substr($time, 8,2).":";
		$timestamp .= substr($time, 10,2).":";
		$timestamp .= substr($time, 12,2);
	}

	return($timestamp);
}


function ConvertMysqlTimeStampToUnixTime($timestamp)	{

	$year=substr($timestamp,0,4);
	$month=substr($timestamp,5,2);
	$day=substr($timestamp,8,2);
	$hour=substr($timestamp,11,2);
	$minute=substr($timestamp,14,2);
	$second=substr($timestamp,17,2);

	$newdate=mktime($hour,$minute,$second,$month,$day, $year);
	return($newdate);
}

function ConvertMysqlTimeStampToUnixTime2($timestamp)	{

echo "$timestamp = ";

	$year=substr($timestamp,0,4);
	$month=substr($timestamp,5,2);
	$day=substr($timestamp,8,2);
	$hour=substr($timestamp,11,2);
	$minute=substr($timestamp,14,2);
	$second=substr($timestamp,17,2);

echo "$year $month $day $hour $minute $second <br>";

	$newdate=mktime($hour,$minute,$second,$month,$day, $year);
	return($newdate);
}


function utf8_substr($str,$start)
{
   preg_match_all("/./su", $str, $ar);

   if(func_num_args() >= 3) {
       $end = func_get_arg(2);
       return join("",array_slice($ar[0],$start,$end));
   } else {
       return join("",array_slice($ar[0],$start));
   }
}


// Отображение дерева сайта - используется для вывода тега select
// 02.03.2008
// Добавлен вывод только разрешенных к просмотру страниц
function displayTree($selectlist="0", $parent="-1", $level=0) { 

	global $section, $siteurl, $parent_id, $link;

	$addqueries = array(
	
		"",
		" AND visibility = 'y'"

	);


	$result = mysqli_query ($link, "SELECT `page_name`,`id`,`parent_id`,`title` FROM `".PREFIX."pages` WHERE `parent_id`='$parent' $addqueries[$selectlist] ORDER BY `priority` desc");
	$tabber = "&nbsp;&nbsp;&nbsp;&nbsp;";
	$tabber2 = "\t";

	while ($row = mysqli_fetch_array($result)) {

		@$itemtemplate = array(			
			"<option value='$row[id]'>".str_repeat($tabber,$level).$row['page_name']."</option>\n",
			str_repeat($tabber2,$level)."<li><a href='{$siteurl}$row[id]/' title='$row[page_name]'>$row[page_name]</a>\n"
			);

		echo $itemtemplate[$selectlist];

		if ($row['id']=="13") {

			echo "\t\t\t<ul>\n";

			$result = mysqli_query ($link, "SELECT `name`,`id` FROM `".PREFIX."rates` WHERE `fixedrate` > '0' AND `visibility` = 'y' ORDER BY `priority` desc");
			while ($fixedRates = mysqli_fetch_array($result)) {
				echo "\t\t\t\t<li><a href='{$siteurl}50/?document_type=$fixedRates[id]'>$fixedRates[name]</a></li>\n";
			} // end while

			echo "\t\t\t</ul>\n";

		} // endif
			
			echo str_repeat($tabber2,$level)."\t<ul>\n";
			displayTree($selectlist, $row['id'], $level+1);
			echo str_repeat($tabber2,$level). "\t</ul>\n" . str_repeat($tabber2,$level). "\t</li>\n";

   } 
}


// Служебная функция для displayTreeV2
function getOpenPath($open_id)
{
	global $link;
	
	$path = array();
	$path[] = $open_id;

	while(true) {
		$result = mysqli_query ($link, "SELECT id, parent_id FROM `".PREFIX."pages` WHERE `id`='$open_id' LIMIT 0, 1");
		if(!($row = mysqli_fetch_array($result)))
			return $path;
		if($row['parent_id'] == -1)
			return $path;
		$path[] = $row['parent_id'];
		$open_id = $row['parent_id'];
	}
}

/*
 * Функция выводит дерево.
 * Параметры:
 *	$open_id -- идентификатор меню который будет открыт
 *	$parent -- идентификатор узла с которого начинать строить дерево. Если -1 то с корня.
 *	$padding -- строка которой будут отделятся уровни.
 *	$level -- при вызове пользователя должно быть 0. Лучше опустить этот необязательный параметр.
 */

function displayTreeV2($open_id="-1", $parent="-1", $padding="&nbsp;&nbsp;&nbsp;&nbsp;", $level=0, $front=0)
{
	global $siteurl, $parent_id, $link;	// DELETE ME!

	static $open_path;
	if($level == 0)
		$open_path = getOpenPath($parent_id);
	
	$result = mysqli_query ($link, "SELECT * FROM `".PREFIX."pages` WHERE `parent_id`='$parent' ORDER BY priority DESC");

	while($row = mysqli_fetch_array($result)) {
		echo(str_repeat($padding, $level));
			
		$page_name = limitValueByChars($row['page_name'],16);	

		if ($parent_id == $row['id']) echo "{$page_name}  - <a href='edit/$row[id]?parent_id=$row[parent_id]' class='edittree'>edit</a> <br>\n";
		elseif ($front == 0) echo("<a href='{$siteurl}pages/?parent_id={$row['id']}'>{$page_name}</a></br>\n");
		else echo("<p><a href='{$siteurl}{$row['id']}/'>{$page_name}</a></p>\n"); 
		
		
		if(in_array($row['id'], $open_path))
			displayTreeV2($open_id, $row['id'], $padding, $level+1);
	}
}

/*
 * Функция выводит дерево.
 * Параметры:
 *	$open_id -- идентификатор меню который будет открыт
 *	$parent -- идентификатор узла с которого начинать строить дерево. Если -1 то с корня.
 *	$padding -- строка которой будут отделятся уровни.
 *	$level -- при вызове пользователя должно быть 0. Лучше опустить этот необязательный параметр.
 */

function displayTreeV3($open_id="-1", $parent="-1", $padding=" &mdash; ", $level=0)
{
	global $siteurl, $parent_id, $link;	// DELETE ME!

	static $open_path;
	if($level == 0)
		$open_path = getOpenPath($open_id);
	
	$result = mysqli_query ($link, "SELECT * FROM `".PREFIX."pages` WHERE `parent_id`='$parent' AND `visibility` = 'y' ORDER BY priority DESC");

	while($row = mysqli_fetch_array($result)) {
		echo "<li";
		if($open_id == $row['id'])
			echo(" class='current'><b>{$row['page_name']}</b></li>\n");
		else {
		echo ">"; echo(str_repeat($padding, $level)); echo "<a href='{$siteurl}{$row['id']}/'>{$row['page_name']}</a></li>\n";
		}
		/*if($open_id == $row['id']) {
			displayTreeV3(-1, $open_id, $padding, $level+1);
		}*/
		
		if(in_array($row['id'], $open_path))
			displayTreeV3($open_id, $row['id'], $padding, $level+1);
	}
}


function getParentLevel($id)
{

	global $link;

	while(true) {
		$qres = mysqli_query ($link, "SELECT parent_id FROM `".PREFIX."pages` WHERE `id`='$id' LIMIT 0, 1");
		if(!($row = mysqli_fetch_assoc($qres)))
			return false;

		if($row['parent_id'] == 1)
			return $id;
	
		$id = $row['parent_id'];
		//return $row['parent_id'];
	}
}

// Получение текущего пути страницы
function getCurrentPathArray($parent_id) {

	$row = ExecuteSqlGetArray("SELECT `parent_id`,`page_name`,`page_path`,`id` FROM `madcms_pages` WHERE `id`='$parent_id'");	
	$path[$parent_id] = array($row['page_name'],$row['page_path']);

	if($row && $row['id']!=="-1" && $row['parent_id']!=="-1") $path = getCurrentPathArray($row['parent_id']) + $path;

	return $path;

} 

// Получение текущего пути страницы
function getCurrentPath($parent_id) {

	global $section, $baseurl, $siteurl;

	$showpathtoobject['parenturl']="{$baseurl}";
	$showpathtoobject['header']="Site";
	

	if ($parent_id!="-1") {
		$showpathtoobject['parenturl']="{$baseurl}";
		$showpathtoobject['header']="<a href='{$siteurl}$section/'>Site</a>";
		$path = getCurrentPathArray($parent_id);

	foreach($path as $key=>$val)
			{
				
				if ($parent_id!=="-1" && $key == $parent_id) $showpathtoobject['header'].= " &rarr;  $val[0]";
				else $showpathtoobject['header'].= " &rarr; <a href='?parent_id=$key'>$val[0]</a> ";
			
			$showpathtoobject['parenturl'] .= $val['1']."/";

			}

	}

	return $showpathtoobject;
	
}


// Получение текущего пути страницы
function getCurrentPathArrayHome($id) {

	$row = ExecuteSqlGetArray("SELECT `parent_id`,`page_name`,`page_path`,`id` FROM `madcms_pages` WHERE `id`='$id'");	
	$path[$id] = array($row['page_name'],$row['page_path']);

	if($row && $row['id']!=="-1" && $row['parent_id']!=="-1") $path = getCurrentPathArray($row['parent_id']) + $path;

	return $path;

} 

// Получение текущего пути страницы
function getCurrentPathHome($id) {

	global $section, $baseurl, $siteurl;

	$showpathtoobject['parenturl']="{$baseurl}";
	$showpathtoobject['header']=$DocumentName="";
	

	if ($id!="-1") {

		$showpathtoobject['parenturl']="{$baseurl}";

		$path = getCurrentPathArrayHome($id);

		foreach($path as $key=>$val)
				{
					
					if ($id!=="-1" && $key == $id) $showpathtoobject['header'].= " &nbsp; $val[0]";
					else $showpathtoobject['header'].= "<a href='/$key/'>$val[0]</a> &rarr; ";
				
				$showpathtoobject['parenturl'] .= $val['1']."/";

				}

	}

	if ($_GET['id'] == "50" && !empty($_GET['document_type'])) {

		$sql = "

			SELECT * FROM `".PREFIX."rates`
			WHERE `visibility`='y' 
			AND `fixedrate` != '0'
			AND `id` = '" . intval(trimmer($_GET["document_type"])). "'

		";

		// echo $sql;

		$documentProperties = ExecuteSqlGetArray($sql);
		$DocumentName = rtrim($documentProperties['name'],"s");

		// echo $DocumentName;
		// $documentProperties['name']
	
	}

	$showpathtoobject['header'] .= $DocumentName;

	return $showpathtoobject;
	
}



// Получить треубемое значение ключа из БД по его идентификатору
// 03.08.2007
// 10.03.2008 changed processSQL to ExecuteSqlGetArray
function GetValueById ($table, $id, $name) {
	$result = ExecuteSqlGetArray("SELECT `$name` FROM `".PREFIX."$table` WHERE id='$id'"); return $result['0'];
}

// Автоматически выбирать требуемые поля тега select
// 26.02.2008
function IsSelected($field, $id)	{

	// echo "--> $_REQUEST[$field] is equal to $id <--\n";

	if ($_REQUEST && $_REQUEST[$field] == $id) return " selected";
}


// Отправка почты с вложениями
// 17.10.2007
// $ct = выбор типа контента, по умолчанию HTML, 1 - для смешанного типа
function sendmail2 ($ctype="0")	{

	global $Settings, $error_msg, $filestoragepath;

	// Пока не знаю для чого це потрібно, але вроде розділювач між прикріпленими файлами
	$mime_boundary = "==Multipart_Boundary_x{" . md5(time()) . "}x";

	// Текст письма
	$content = html_entity_decode($_POST['content']);

	// Массив с двуями видами шапками - просто HTML и смешанный (текст + аттачи)
	$contenttype = array(
		"Content-type: text/html; charset=\"UTF-8\"\r\n\r\n",
        "Content-Type: multipart/mixed; " . 
        "boundary=\"{$mime_boundary}\";\n"
		// "Content-Transfer-Encoding: 7bit\n\n"
	);
	
	// Если есть файлы то подставляем соотв. другой хедер, а также прикреп. файлы
	if ($_POST['filelisting']) {

		$ctype = "1";
		
		// указываем наличие файлов
		$content .= "This is a multi-part message in MIME format.\n\n" . 
        "--{$mime_boundary}\n" . 
        "Content-Type; multipart/mixed\n" . 
        "Content-Transfer-Encoding: 7bit\n\n";

		// Получаем массив из названий файлов, полученной из переменной POST
		$filelisting = explode(";", $_POST['filelisting']);

		// Убиваем последний элемент в этом массиве
		array_pop($filelisting);

		// Тип файла по умаолчанию
		$fileatt_type = "application/octet-stream"; // File Type 

		// Разбираем массив с файлами
		foreach($filelisting as $key=>$value) {

			// Получаем полный путь к файлу
			$filetoread = $filestoragepath.trim($value);

			// Открываем его
			$file = fopen($filetoread,'rb'); 

			// Считываем в буфер
			$data = fread($file,filesize($filetoread)); 

			// Закрываем
			fclose($file);

			// Конвертируем в емейл формат
			$data = chunk_split(base64_encode($data)); 
			
			// Загоняем сконвертированные данные в текст письма
			$content .= "\n\n--{$mime_boundary}\n" . 
					  "Content-Type: {$fileatt_type};" . 
					  " name=\"" . trim($value) . "\";\n" . 
					  "Content-Transfer-Encoding: base64\n" . 
					  "Content-Disposition: attachment;\n\n" . 
					 $data;
	
		}

		$content .= "--{$mime_boundary}--\n";

	}

	// Формирование шапки в зависимости от наличия файлов
	$headers = 
		"From: $_POST[fromname] <$_POST[fromemail]>\r\n" .
		"Reply-To: $_POST[fromname] <$_POST[fromemail]>\r\n" .
		"Organization: $Settings[company_name]\r\n".
		"MIME-version: 1.0\n".
		$contenttype[$ctype];	

		if (mail("$_POST[toname] <$_POST[toemail]>", $_POST['subject'], $content, $headers)) $error_msg = "Message Sent Successfully";
			else $error_msg = "Message Sending Failed";
			

	return $error_msg;

}

// Added 21.11.2009
function sendmail3 ($str="")	{

		global $error_msg;

		$headers = "From: '$_POST[fromname]' <$_POST[fromemail]>\r\n" .
		"Return-Path: '$_POST[fromname]' <$_POST[fromemail]>\r\n" .
		"Reply-To: '$_POST[fromname]' <$_POST[fromemail]>\r\n" .
		"BCC: Yuriy Yatsiv <yuriy.yatsiv@gmail.com>\r\n" .
		"MIME-version: 1.0\n" .
		"Content-Transfer-Encoding: 8bit\n" .
		"Content-type: text/plain; charset=\"UTF-8\"";

		/* foreach($_REQUEST as $key=>$val)
			{

			if ($key !== "cat_path" && $key !== "page_path" && $key !== "__utma" && $key !== "__utmz" && $key !== "dosometh" && $key !== "subject" && $key !=="__utmb" && $key !=="__utmc" && $key !== "PHPSESSID")
				$str.="<B>$key:</B> $val <BR>";
		} */

		if	(mail("'$_POST[toname]' <$_POST[toemail]>", $_POST['subject'], $_POST['text'], $headers)) {

				$error_msg = "Your message was successfully sent.";
				return true;

			}

		else {

			$error_msg = "Your message was not sent. Please try again later";
			return false;

		}
		


}


// 15.11.2009
function GenerateCheckBox($array,$separator=" &nbsp; ",$br="<br>", $js="",$var=""){

	global $checkedOrNot;

	foreach($array  as $key=>$description)	{

	@$var .= "<input type='checkbox' id='$key' " . $checkedOrNot[ifExistValueReturnIt($key)] . " onClick='ChangeHiddenFieldValue(\"$key\")' $js><label for='$key'> $separator $description &nbsp; </label>\n$br";

	}

	echo $var;

}

// Автоматически выбирать требуемые поля тега select
// 25.08.2007
function selectv2($field, $number)	{

	if($field == $number) return " selected";

}

?>