<?

global $link;

$id = @intval($_GET['id']);

switch($action) {

// Вывод страницы по умолчанию
default:

	$action = "default";
	$title = @$SectionNames[$section] . " &#151; $translation[149]";

	// Инициализация перменных
	$where = $qeuryforpaginator = $paging = "";

	if ($section == "pages") $where = "WHERE parent_id = $parent_id";

		// Получение дополнительных параметров
		parse_str($_SERVER['QUERY_STRING'],$query);
		foreach($query as $key=>$val)

				{
					if ($key !== "section" && $key !== "page" && $key !== "sortby" && $key !== "ascdesc" && $key !== "parent_id") {
						
						// Дополнительная строка для запроса в БД
						$where =" $key = '$val'";

						// echo $where;

					}

					if ($key !== "section" & $key !== "page") {
												
						// Для пагинатора
						$qeuryforpaginator .= "$key=$val&";

					}

				}

	// echo $where;

	$url = $_SERVER['REDIRECT_URL'] . "?" . $qeuryforpaginator;

	// Формирование сути нашего запроса
	$sql = "FROM `".PREFIX."$section` $where ORDER BY `$orderby` $ascdesc";

	// echo $sql;

	$currentpath = getCurrentPath($parent_id);

	// Считаем общее кол-во объектов
	$res = mysqli_fetch_array(mysqli_query($link, "select count(*) as count $sql"));

	// Если хоть что-то есть, выводим список
	if($res) {
		
		// Всего записей
		$count = $res['count'];

		// Считаем общее кол-во страниц
		$totalpages = ceil($count/$Settings['itemsonpage']);

		// узнаем на какой странице находимся
		if(empty($_GET['page'])) $page = 0; else $page = $_GET['page'];

		// Выставление лимита кол-ва объектов на странице (так же исп-зуется для нумерации объ. на страницах)
		$startlimit = $Settings['itemsonpage']*$page;

		// Первый объект на странице
		$startobject = $startlimit + 1;

		// Последний объект на странице
		$endobject = $startobject + $Settings['itemsonpage'] - 1;

		// Если объектов меньше, чем разрешено на странице
		if ($count <= $Settings['itemsonpage']) $endobject = $count;
		
		// Исп. для последней страницы
		if ($endobject > $count) $endobject = $count ;

		// Формирование конечного запроса
		$sql = $sql . " LIMIT $startlimit, $Settings[itemsonpage]";

		// echo $sql;

		// Собственно делаем выборку
		$res = mysqli_query($link, "SELECT * $sql");

	}

	break;

// Страница добавления объекта
// Добавлен путь к странице
case "add":

		$currentpath = getCurrentPath($parent_id);

		$action = "addedit";
		$title = $translation['16'];

	break;

// Выполнение добавления объекта
case "do_add":

	$action = "add";
	$tolocation = "/";

	if ($section == "pages") $tolocation .= "?parent_id=$_GET[parent_id]";
	$location = $siteurl.$section.$tolocation;
		
	// print_r($_SERVER['QUERY_STRING']);

		if (insert_data ($_POST, $section)) {
			header("Location: $location");
		}	else {
			$title = $translation['93'];
			$error_msg = $translation['17'];
		}

	// 29.07.2007 
	// Авторассылка новостей
	if ($section == "news") AutoSendNewsToSubscribers();

	break;

// Вывод страницы о нас
case "about":

		$action = "about";
		$title = $translation['92'];

	break;

// Проверка ссылки
case "check":

	$action = "check";
	$title = "Link validation procedure";

	include "lib/linkchecker.php";
	
	$f = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `".PREFIX."links` WHERE `id`='$_GET[id]'"));

	// Используетс также на странице проверки ссылки
	$backURL = $f['backurl'];
	$ourURL = $f['ourlink'];
	$PassedOrNot = array("Failed","OK");
	$LinkVisibeOrNot = array("n" => "отключена","y" => "оставлена как есть");

	$result = checkLink($backURL, $ourURL, $_GET['id']);

	break;

// 22.11.2009 Проверка ссылки
case "notify":

	$action = "notify";
	$title = "Send notification";
	
	$f = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `".PREFIX."links` WHERE `id`='$id'"));

	break;

// 22.11.2009 Вывод страницы о нас
case "do_notify":

		if (sendmail3()) {
		
		$details['date_message_sent'] = date("Y-m-d G:i:s ");
		$details['id'] = $_GET['id'];

		edit_data($details,"links");
		
		}

	break;


// Выполнение внесения изменений
case "do_edit":

		$action = "edit";
		$tolocation = "/";

		if ($section == "pages") $tolocation .= "?parent_id=$_GET[parent_id]";
		$location = $siteurl.$section.$tolocation;

		// 1.b Если мы на странице изменения пароля, то шифруем его и заносим в таблицу
		if (!empty($_POST['password']) && $_POST['password']!=$Settings['password']) {
			$_POST['password'] = md5($_POST['password']);
		} else 	unset($_POST['password']);

		// "Save" or "Continue Edit"
		if (!empty($_POST['submit'])) $location = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		// Сохраняем данные и возвращаемся в начальную раздела
		if (edit_data ($_POST, $section)) {
			header("Location: $location");
		}	else {
			$title = $translation['93'];
			$error_msg = $translation['17'].mysqli_errno() . ": " . mysqli_error();
		}

	break;

// Страница редактирования
case "edit":

		$action = "addedit";
		$title = $translation['94'];
		$f = ProcessSQL("SELECT * FROM `".PREFIX."$section` WHERE `id` = $_GET[id]");

	break;

// Изменение значение. Режим AJAX
case "changevalue":

		$table = $_GET['section'];
		$request = parse_url($_SERVER['REQUEST_URI']);
		parse_str($request['query'], $details);

	if (ChangeValue()) header("Location: {$siteurl}../changed.html");

	break;

// Изменение значение. Режим AJAX
case "changecolumns":

	global $link;

	mysqli_query($link, "UPDATE `".PREFIX."$section` SET `timestamp` = NOW()");

	break;

// Страница входа
case "login":

		$action = "login";
		$title = $translation['18'];
		$f = ProcessSQL("SELECT * FROM `".PREFIX."$section` WHERE `id` = 1");

	break;

// Страница выполнения архивации сайта
case "backup":

		$action = "backup";
		$title = "DB Backup";

	break;

// Выполнение архивации сайта. Архивириуется только база данных
case "do_backup":

		$action = "backup";
		$error_msg = $translation['19'];

		$db_backup_date =  date("Y-m-d-H-i-s");
		$backupFile = "$_SERVER[DOCUMENT_ROOT]/files/$db_name-$db_backup_date.gz";
		$command = "mysqldump --opt --host=$db_host --user=$db_user --password=$db_pass $db_name | gzip > $backupFile";
		// echo $command;
		@system($command,$status);

		if ($status === FALSE) $error_msg = $translation['20'];

		header ( 'Cache-control: max-age=31536000' );
		header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		header ( 'Content-Length: ' . filesize ( $backupFile ) );
		header ( 'Content-Type: application/x-gzip-compressed; name="' . basename ( $backupFile ) . '"' );
		header ( 'Content-Transfer-Encoding: binary' );
		readfile($backupFile);

	break;

// Выполнение восстановления базы данных. Пре-пре-альфа
case "do_restore":

		$action = "db";
		$error_msg = "DB restored";

		print_r($_FILES);
		print_r($_ENV);

		$command = 
			
		"gunzip " . $_FILES['backupFile']['tmp_name'] . " ". $_SERVER['DOCUMENT_ROOT'] . "/tmp/" . str_replace(".zip", "", $_FILES['backupFile']['name']) .
		"; mysqlimport --user=$db_user --password=$db_pass $db_name " . $_SERVER['DOCUMENT_ROOT'] . "/tmp/" . str_replace(".zip", "", $_FILES['backupFile']['name']) . 
		"; rm -f " . $_SERVER['DOCUMENT_ROOT'] . "/tmp/" . str_replace(".zip", "", $_FILES['backupFile']['name']);
		
		system($command,$status);
		if ($status === FALSE) $error_msg = $translation['20'];

	break;



// Удаление объекта
case "delete":

	$tolocation = "/";

	if ($section == "pages") $tolocation .= "?parent_id=$_GET[parent_id]";
	$location = $siteurl.$section.$tolocation;

		if (delete_data("id", $section, $_GET['id'])) {
			header("Location: $location");
		}	else {
			$title = "Error";
			$error_msg = $translation['17'];
		}

	break;

// Множественное удаление объектов
case "massactiontoobjects":

	$error_msg = $translation['156'];
	$title = $translation['93'];

		// Если были переданы ID объектов
		if (@$_POST['id']) {

			// Инициализируем переменную для перенаправления
			$tolocation = "/";
			$ids = "";

			// Если мы находимся в разделе страницы, то должны вернуть пользовотеля туда, откуда он пришел
			if ($section == "pages" && @$_GET['parent_id']) $tolocation .= "?parent_id=$_GET[parent_id]";

			// Формирурем адрес "туда"
			$location = $siteurl.$section.$tolocation;

			// Разбиваем массив с ID объектов
			foreach($_POST['id'] as $key=>$value) {
				
				// Делаем невозможным перенос объекта в самого себя
				if ($value !== $_POST['parent_id']) $ids .= "$value,";

			}

			// Формируем строку с объектами (требуется для создания запроса множественных строк в БД)
			$ids = substr_replace($ids ,"",-1);
			
			/*** Начинаем выполнять массовые действия ***/

			// Если нужно переместить, выполняем перемещение
			if (@$_POST['massaction']) {

					if (move_data("id", $section, $ids,"1")) header("Location: $location");
					else $error_msg = $translation['17'];			
			
			
			}

			// В противном случае это удаление
			else {
				
					// echo $ids;

					if (delete_data("id", $section, $ids,"1")) header("Location: $location");
					else $error_msg = $translation['17'];


			}

		}

	break;

// Выполнение запроса к базе данных
case "do_runquery":

		$action = "default";
		$error_msg = $translation['137'];

		$title = $translation['167'];

		// Don't change here
		if (mysqli_query($link, str_replace("\\", "", $_POST['sql']))) return 1; else { $error_msg = $translation['138'] . mysqli_errno() . ": " .mysqli_error();  return 0; }
		// Don't change here */


	break;

}

?>