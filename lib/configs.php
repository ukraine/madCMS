<?

// Version 1.2
// 12.02.2008
// 10.03.2008	Added Request required fields

// Данные для доступа к БД
/*
$db_host = "mysql1058.servage.net";
$db_user = "ifstudio52";
$db_pass = "eJqRx67E90zWiMu";
$db_name = "ifstudio52";
*/

// Данные для доступа к БД
$db_host = "localhost";
$db_user = "itranslate";
$db_pass = "----------";
$db_name = "itranslate";

// Соединяемся и выбираем нужную базу данных
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Запрещенные символы и их замена
$ForbiddenChars = array("'", "‘ ", "`",  "'", "</textarea>", "<textarea");
$AllowedChars = array("&#39;", "&lsquo;", "&#96;", "&#39;", "&lt;/textarea&gt;", "&lt;textarea");

// Языковые параметры
$language = "";
if (!empty($_GET['hl']) && strlen($_GET['hl']) == "2") define("LANGUAGE", "_{$_GET[hl]}"); 
else define("LANGUAGE", $language);

// Получение URL-а сайта
$siteurl = "http://".$_SERVER['HTTP_HOST']."/";

define("PREFIX", "madcms_");
define("SITEURL", $siteurl);
define("FILESTORAGEPATH", $_SERVER['DOCUMENT_ROOT']."/files/customerfiles/");
define("URLSTORAGEPATH", SITEURL."files/customerfiles/");
define("SHOWINTERPRETERSEVERY", "4");
define("USDEURRATE", "0.79");
define("TESTRATES", "13");

// Обязательные к заполнению поля для формы обратной связи
$FeedbackRequiredFields = array("email"=>"Email address", "name"=>"Name", "text"=>"Text of the message");

// Обязательные к заполнению поля для формы обратной связи
$ContactEmailForm		= array("name" => "your name", "email" => "Your email address", "contento" => "Text of your message");
$QuoteRequestFields		= array("name" => "your name", "email" => "Your email address");
// $InstantQuoteRequest	= array("source_text" => "Source text");
$TranslatorApplication	= array(
"lastname" => "Last name", 
"firstname" => "First name",
"email" => "Your e-mail address",
"country" => "Your country",
"phone" => "Your phone number"
);

$TranslatorTestApplication	= array(
"name" => "Your name", 
"email" => "Your e-mail address",
"testtranslation" => "Test translation",
);

$LinkSubmissionForm	= array(
"name" => "Your name", 
"emailo" => "Your e-mail address",
"url" => "URL of your web-site",
"backurl" => "URL of your web-site with our link inside",
"title" => "Title or name of your company",
"description" => "Description of your web-site"
);


$list['moscow'] = array(

	"daria-u" => "English, Spanish | 172 | 37.5 | higher | 180 | MITT, Mosbuild",
	"diana-a" => "English, Spanish | 175 | 000 | higher | 200 | MITT, Textile", // edu n/a
	"irina-z" => "English | 175 | 000 | higher | 215 | ConsumExpo", // edu n/a
	"elena-v" => "English, French | 172 | 000 | higher | 215 | ProdExpo, Betonex ",
	"kate-a" => "English, Spanish | 170 | 39 | higher | 215 | MITT, Moshoes",
	"bella-c" => "English, German | 170 | 39 | higher | 215 | Intercharm",
	"xenia-v" => "English, French | 170 | 36 | higher | 215 | SvyazExpoCom",
	"eteri" => "English, Spanish | 173 | 000 | higher | 215 | Expocamen, Moshoes", 
//	"maria-b" => "English, Spanish | 172 | 38 | higher | 215 ", 

	"vera-k" => "English | 173 | 37.5 | higher | 200 | Elektro, MITT", // edu n/a
	"anastasia-k" => "Spanish | 179 | 39 | higher | 215 | Mirstekla",
	"olga-max" => "English | 173 | 38 | higher | 200 | Rosupak ",
	"xenia-kir" => "English, German | 174 | 37.5 | higher | 215 | WorldFood",
//	"alina-y" => "English, French | 176 | 37.5 | higher | 215",
//	"anna-b" => "English, Italian, Spanish | 180 | 40 | higher | 215",
//	"elena-brit" => "English, Italian, German | 178 | 39 | higher | 215",
//	"julia-f" => "English, Spanish | 172 | 37 | higher | 215 ",
//	"viktoria-n" => "English, Spanish | 173 | 38 | 000 | 215 ",",
//	"irina-p" => "English, German | 172 | 000 | 000 | 215 ",

);

$list['spb'] = array(

//	"lena-n" => "English | 000 | 000 | higher | 133 | leniya_nikulina@bk.ru", // blacklisted
	"marina-s" => "English | 000 | 000 | higher | 115 | Inavtrotrans | dzika@inbox.ru ", // 21 yo 
	"valeria-b" => "English | 000 | 000 | higher | 125 | Tires and disks | losoulera@gmail.com", // 29 yo 
	"yulia-v" => "German, French | 000 | 000 | higher | 133 | Interstroyexpo | julia_vasilyeva@inbox.ru", // 
	"andy-b" => "English | 000 | 000 | higher | 133 | AgroRussia | andy.bassargin@gmail.com", // 30 yo // 

);

$list['ukraine'] = array(

	"eugene-p" => "English | 000 | 000 | higher | 100 | n/a | e_panchuk@mail.ru", // 
	"gene-l" => "English | 000 | 000 | higher | 120 | n/a | lucky_swan@rambler.ru", // edu n/a 
	"ed-h" => "Hebrew, Spanish | 000 | 000 | higher | 115 | n/a | heyfetzed@rambler.ru", // 
	"vasil-k" => "Spanish | 000 | 000 | higher | 110 | n/a | basilykrez@mail.ru", // 

);

$list['chelyabinsk'] = array(

	"maria-f" => "English, German | 000 | 000 | higher | 100 | n/a | sageeldhel@mail.ru  ",

);

$list['vladivostok'] = array(

	"natalia-t" => "English, French | 000 | 000 | higher | 100 | n/a | ilovecandies88@mail.ru ",

);

$list['kazan'] = array(

	"maria-s" => "English, Italian | 000 | 000 | higher | 150 | n/a | emci2008@gmail.com ",

);

$list['msk'] = array(

	"alexander-n" => "German | 174 | 000 | higher | 135 | Health and Beauty Systems | nenilin14@mail.ru ", // 20 yo только выходные
	"alexandra-b" => "German | 174 | 000 | higher | 135 | MITT | alexandra.borisenko@yandex.ru ", // 20 yo
	"liliya-k" => "German | 000 | 000 | higher | 120 | MITT | kleynikova@mail.ru ",
//	"viktoriya-p" => "English | 000 | 000 | higher | 125 | BIOT, TextileLegProm | VictoriaPyrlik@gmail.com",
	"tatiana-ch" => "English, French | 150 | 000 | higher | 125 | Mosshoes | tanya_chueva@mail.ru ", // edu n/a
	"xenia-o" => "French, Spanish | 000 | 000 | higher | 125 | MITT | kseniaokisheva@mail.ru ",
	"tania-k" => "German | 000 | 000 | higher | 135 | ConsumExpo | taniakonakova@mail.ru ",
	"inna-s" => "Spanish | 167 | 000 | higher | 125 | MITT | inna.solskaya@mail.ru ", // 
	"daria-a" => "English | 167 | 000 | higher | 125 | MITT | dasch.work@gmail.com ", // 30


);

$list['russia'] = array(

	"andrey-n" => "English | 000 | 000 | higher | 111 | n/a | aheart@mail.ru ",
	"oksana-l" => "English | 000 | 000 | higher | 111 | n/a | bsnss@inbox.ru ",

);

$list['italy'] = array(

	"anna-d" => "Spanish, Italian | 000 | 000 | higher | 143 | n/a | esdyanna@gmail.com ",
	"anna-l" => "Italian | 174 | 000 | higher | 143 | n/a | italianorusso@hotmail.com ", // 27 yo

);

$list['voronezh'] = array(

	"lyuda-z" => "English | 000 | 000 | higher | 111 | n/a | arkanar87@gmail.com ", // 1987

);

$list['nizhniy'] = array(

	"eugene-k" => "English | 000 | 000 | higher | 111 | n/a | eugenkasarjan@mail.ru ", // 43 yo
	"valeriy-p" => "English | 000 | 000 | higher | 121 | n/a | va_pers@mail.ru ", // 43 yo
);

$list['barnaul'] = array(

	"oleg-s" => "German, English | 000 | 000 | higher | 100 | n/a | schelepow.ol@yandex.ru ", // 29 yo
	"kate-n" => "English | 000 | 000 | higher | 200 | n/a | katekind@gmail.com ", // 29 yo

);

$list['amsterdam'] = array(

	"anastasia-o" => "English, German | 000 | 000 | higher | 300 | n/a | anastasijaosina@gmail.com  ", // 1989

);

$list['rostov'] = array(

	"avgustina-p" => "English, German | 000 | 000 | higher | 111 | n/a | awgustina-p@yandex.ru ", // 1989

);

$list['ufa'] = array(

	"oksana-r" => "English, German | 000 | 000 | higher | 111 | n/a | ruzhitskaya75@rambler.ru ", // 1989

);

define("THUMBSDIR","4");
define("OURPRICEMULTIPLIER","1.35");
define("MARKETPRICEMULTIPLIER","1.95");

// Соотв. русским месяцам
$Months = array("Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");

?>