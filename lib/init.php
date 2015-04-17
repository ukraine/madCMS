<?

// Запрет/Разрешение вывода любых ошибок интерпретатора
error_reporting(E_ALL);

// Глобализируем некоторые вещи
global $Settings, $email, $error_msg, $link;



/* ### I. Подключение файлов ### */

// Подключение конфигурационного файла
include "configuration.php";

// Подключение главного 
// функционального файла
include "main.func.php";

// Подключение файла с общими для 
// админки и витрины функциями
include "shared.php";

// Подключение файла с функциями для работы с "Корзиной заказов"
//include "cart.php"; ZAKHAR 4/17/2015
include "cart/point.php";

// Подключение языкового файла
include "mad/lang/english.php";



/* ### II. Инициализация переменных ### */

// Переменные-пустышки
$error_msg = $view = $adminedit = "";

// ID страницы по умолчанию
$id = "1";

// Страница шаблона по умолчанию
$template = "inner";

// Инициализация идентификатора страницы
if (!empty($_GET['id']))	$id = trimmer($_GET['id']);






/* ### III. Запуск страницеобразующих функций и обработчика событий ### */

// Старт сессии
session_start();

//if ($_SESSION && $_SESSION['loggedin'] == "yes") { error_reporting(E_ALL); }
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "yes") {
	error_reporting(E_ALL);
}
// else echo $_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
	$_SESSION['total'] = 0;
	$_SESSION['fullCost'] = 0;
	$_SESSION['discount'] = 0;
	$_SESSION['quantity'] = 0;
	$_SESSION['orderId'] = null;
}

cartClean($link);

// Получение базовых параметров системы в глобальную переменную $Settings
getSettings();

// Если присутствует POST переменная, запускаем парсер содержимого POST
if (!empty($_POST['dosometh'])) PostParser();

// Запускаем проверку и установку кукей
RefCookie();

// Генерируем и заносим в массив информацию о загружаемой странице
$page = PageGen($id);

// Если мы в корневом разделе
if ($page['parent_id']=="-1") $template="index";

// Если пользователь залогинен, даем ему право на редактирование
//if ($_SESSION && $_SESSION['loggedin']== "yes") 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == "yes")
$adminedit="<span class='adminedit'>
<a href='/mad/pages/edit/$page[id]?parent_id=$page[parent_id]'>edit</a> 
<a href='/mad/pages/'>admin</a>
<a href='/mad/login.php?do=logoff'>log out</a>
</span>";

// Отправка даты последнего изменения страницы в заголовок страницы
header('Last-Modified: '.$page['timestamp']);

flush();