<?

global $link, $url, $siteurl, $loggedin;
$error_msg = $translation['95'];

if (isset($_SERVER['HTTP_REFERER'])) $url = $_SERVER['HTTP_REFERER'];

function sendNewPass() {

	global $error_msg, $Settings, $translation;

	$_POST['id'] = 1;
	$section = "settings";
	$error_msg = $translation['89'];

	if ($_POST['login'] == $Settings['login']) {
		$NewPass = substr(md5(rand()),0,8);
		include "lib/default.func.php";
		$_POST['password'] = md5($NewPass);
		unset($_REQUEST['phpbb2mysql_data']);
		unset($_REQUEST['PHPSESSID']);
		unset($_REQUEST['submit']);
		unset($_REQUEST['login']);
		unset($_REQUEST['action']);
		$_REQUEST['Ваш новый пароль'] = $NewPass;
		if (edit_data ($_POST, $section)) {
			sendmail($translation['89']);
			$error_msg = $translation['86'];
		} else $error_msg = $translation['88'];

	}

}


function openCloseAccess() {

	global $url, $error_msg, $Settings, $translation;

	include "../mad/lib/default.func.php";

	if ($_REQUEST['do'] == "allow" && $_POST['login'] == $Settings['login'] && md5($_POST['password'])== $Settings['password']) {
			
			// Создаем сессию об авторизации пользователя
			$_SESSION['loggedin'] = "yes";

			// Вставляем данные о сессии в таблицу настроек
			$details['admin_session_id'] = session_id();
			$details['id'] = "1";
			edit_data ($details, "settings");

			// Даем ему куки, если пользователь хочет сохранить пароль на время
		
			// Перенапрвляем пользователя на урл, с которого он пришел
			header("Location: $url");
		}

		elseif ($_REQUEST['do'] == "logoff")	{

			// Стираем данные о сессии из таблицы настроек
			/* $details['admin_session_id'] = "";
			$details['id'] = "1";
			edit_data ($details, "settings"); */

			// Удаляем сессию
			session_start();
			session_destroy();

			// Перенапрвляем пользователя на урл, с которого он пришел
			header("Location: $url");
		}

		else {
		$error_msg = "<span style='color: red'>$translation[85]</span>";
		}

}

if (!empty($_REQUEST['do'])) openCloseAccess();
if (!empty($_REQUEST['action'])) @sendNewPass();

?>
<html>
<head>
<title><?=$translation['82']?></title>
<link rel="stylesheet" href="<? echo $siteurl; ?>img/_mad.css" type="text/css">
<SCRIPT type="text/javascript" language="JavaScript"> 
	function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(e != null) {
	if(e.style.display == 'none') {
	e.style.display = 'block';
	} else {
	e.style.display = 'none';
	}
	}
}
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body id="login">
<H3 id="first"><? echo $error_msg; ?></H3>
<form action="" name="getAccess" method="post">
	<input type='text' name='login' style='width: 200px' id="login"> <label for="login"><?=$translation['75']?></label><br>
	<input type="password" name="password" style="width: 200px" id="password"> <label for="password"><?=$translation['76']?> </label><br><br>
	<input type="submit" name="access" value="<?=$translation['91']?>" style='width: 200px'>
	<input type="hidden" name="do" value="allow"><br>
	<input type="checkbox" name="remember" id="remember" value="1" style="width: auto; margin-right: 0;"> <label for="remember"><?=$translation['163']?></label>
	<br><br> &nbsp; &nbsp; &nbsp; <span onClick="toggle_visibility('reminder')" class="InnerLink"><?=$translation['83']?></span>
</form>
<form action="" name="Reminder" method="post" id="reminder" style="display:none;">
	<input type='text' name='login' style='width: 200px' id="loginf"> <label for="loginf"><?=$translation['84']?></label>
	<br><input type="submit" name="submit" value="<?=$translation['87']?>" style='width: 200px'>
	<input type="hidden" name="action" value="forgot">
</form>
</body>
</html>