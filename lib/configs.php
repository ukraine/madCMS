<?

// Version 1.2
// 2/28/2015 Changed db login details vars to constants
// 12.02.2008
// 10.03.2008	Added Request required fields

// Данные для доступа к БД
// DB login details
define("DB_HOST","localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");

// Соединяемся и выбираем нужную базу данных
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

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
	"vera-k" => "English | 173 | 37.5 | higher | 200 | Elektro, MITT", // edu n/a
	"anastasia-k" => "Spanish | 179 | 39 | higher | 215 | Mirstekla",
	"olga-max" => "English | 173 | 38 | higher | 200 | Rosupak ",
	"xenia-kir" => "English, German | 174 | 37.5 | higher | 215 | WorldFood",

);

$list['spb'] = array(

	"marina-s" => "English | 000 | 000 | higher | 115 | Inavtrotrans | ", // 21 yo 
	"valeria-b" => "English | 000 | 000 | higher | 125 | Tires and disks | ", // 29 yo 
	"yulia-v" => "German, French | 000 | 000 | higher | 133 | Interstroyexpo | ", // 
	"andy-b" => "English | 000 | 000 | higher | 133 | AgroRussia | ", // 30 yo // 

);

$list['ukraine'] = array(

	"eugene-p" => "English | 000 | 000 | higher | 100 | n/a | ", // 
	"gene-l" => "English | 000 | 000 | higher | 120 | n/a | ", // edu n/a 
	"ed-h" => "Hebrew, Spanish | 000 | 000 | higher | 115 | n/a | ", // 
	"vasil-k" => "Spanish | 000 | 000 | higher | 110 | n/a | ", // 

);

$list['chelyabinsk'] = array(

	"maria-f" => "English, German | 000 | 000 | higher | 100 | n/a |  ",

);

$list['vladivostok'] = array(

	"natalia-t" => "English, French | 000 | 000 | higher | 100 | n/a | ",

);

$list['kazan'] = array(

	"maria-s" => "English, Italian | 000 | 000 | higher | 150 | n/a | ",

);

$list['msk'] = array(

	"alexander-n" => "German | 174 | 000 | higher | 135 | Health and Beauty Systems | ", // 20 yo только выходные
	"alexandra-b" => "German | 174 | 000 | higher | 135 | MITT | ", // 20 yo
	"liliya-k" => "German | 000 | 000 | higher | 120 | MITT | ",
//	"viktoriya-p" => "English | 000 | 000 | higher | 125 | BIOT, TextileLegProm | VictoriaPyrlik@gmail.com",
	"tatiana-ch" => "English, French | 150 | 000 | higher | 125 | Mosshoes | ", // edu n/a
	"xenia-o" => "French, Spanish | 000 | 000 | higher | 125 | MITT | ",
	"tania-k" => "German | 000 | 000 | higher | 135 | ConsumExpo | ",
	"inna-s" => "Spanish | 167 | 000 | higher | 125 | MITT | ", // 
	"daria-a" => "English | 167 | 000 | higher | 125 | MITT | ", // 30


);

$list['russia'] = array(

	"andrey-n" => "English | 000 | 000 | higher | 111 | n/a | ",
	"oksana-l" => "English | 000 | 000 | higher | 111 | n/a | ",

);

$list['italy'] = array(

	"anna-d" => "Spanish, Italian | 000 | 000 | higher | 143 | n/a | ",
	"anna-l" => "Italian | 174 | 000 | higher | 143 | n/a | ", // 27 yo

);

$list['voronezh'] = array(

	"lyuda-z" => "English | 000 | 000 | higher | 111 | n/a | ", // 1987

);

$list['nizhniy'] = array(

	"eugene-k" => "English | 000 | 000 | higher | 111 | n/a | ", // 43 yo
	"valeriy-p" => "English | 000 | 000 | higher | 121 | n/a | ", // 43 yo
);

$list['barnaul'] = array(

	"oleg-s" => "German, English | 000 | 000 | higher | 100 | n/a | ", // 29 yo
	"kate-n" => "English | 000 | 000 | higher | 200 | n/a | ", // 29 yo

);

$list['amsterdam'] = array(

	"anastasia-o" => "English, German | 000 | 000 | higher | 300 | n/a |  ", // 1989

);

$list['rostov'] = array(

	"avgustina-p" => "English, German | 000 | 000 | higher | 111 | n/a | ", // 1989

);

$list['ufa'] = array(

	"oksana-r" => "English, German | 000 | 000 | higher | 111 | n/a | ", // 1989

);

define("THUMBSDIR","4");
define("OURPRICEMULTIPLIER","1.35");
define("MARKETPRICEMULTIPLIER","1.95");

// Соотв. русским месяцам
$Months = array("Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");

