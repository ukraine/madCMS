<?

global $error_msg, $table, $name, $email;

error_reporting(E_ALL);

$table = "links";

function sendBadEmail($details, $templateId) {

	global $id, $email, $name, $content, $subject, $table, $link;

		$sql = "SELECT subject,content FROM `templates` where `id`='$templateId'";
		$res = mysqli_query($link, "$sql");
		$f = mysqli_fetch_array($res);

	if ($name == "") $name = "!";

	$content = $f['content'];
	$subject = $f['subject'];

	// sendmail();

}

function checkLink($backurl, $searchURL, $id){
	
	global $details, $table, $email, $name, $id;

	// Вещи по умолчанию
	$details["id"] = $id;
	$details['404'] = $details["presence"] = $details['robotstxt'] = "0";

	// Проверка валидности URL-а
	if (strtolower(substr($backurl,0,7))!='http://') $backurl="http://".$backurl;
	if (strtolower(substr($searchURL,0,7))!='http://') $searchURL="http://".$searchURL;
	$url_parts = parse_url($backurl);

	// Проверка на физическое наличие robots.txt, 
	// если 404 значит игнорируем его парсинг
	$backPrimaryURL = parse_url($backurl);
	$host = get_headers("http://$backPrimaryURL[host]");
	if (stristr($host['0'],"404")) $details['robotstxt'] = 1; 

	// Проверка на физическое наличие страницы
	$head = get_headers($backurl);
	if (stristr($head['0'],"200")) { 
		
		$details['404'] = 1; 

  	// Проверка метатегов
	$metas=get_meta_tags($backurl);
	if(!empty($metas["robots"])) {
		
		$metas["robots"]=strtolower($metas["robots"]);
		
		if ((ereg("nofollow",$metas["robots"]))|| (ereg("noindex",$metas["robots"]))) $details["metarobots"] = "0";
		else $details["metarobots"] = "1";
			
	}	else $details["metarobots"] = "1";

	$details["metarobots"];

	// Checking Robots.txt
	
	/*
	$badrob=0;
	$linkParts = parse_url($searchURL);
	$fp = fsockopen($url_parts["host"],80,$errno,$errstr,20); 
	$documentpath = ""; 
		if(!$fp) {
			if ($errno==0) $error_msg .=  $errstr.$errno;
		} else { 
			$header = "GET /robots.txt HTTP/1.0\r\n";
			$header .= "Host: ".$url_parts["host"]."\r\n";
			$header .= "User-Agent: IfstudioTran LinkChecker 1.0 (http://www.ifstudio-translations.com/iflc.txt)\r\n";
			$header .= "Connection: Close\r\n\r\n";
			fwrite($fp,$header);
			
			if (isset($url_parts['path'])) {
				$documentpath = $url_parts["path"];
				if (isset($url_parts["query"])) $documentpath .= "?".$url_parts["query"];
				$ar=explode('/',$documentpath);
			}
			
			while (!feof ($fp)) {
				$line = fgets($fp);
					if (preg_match('/Disallow:\s*\/\s*$/i',$line)) {
						fclose ($fp); 
						$error_msg .=   "Индексация сайта <b>".$url_parts['host']."</b> запрещена с помощью robots.txt";
					}
				$line=str_replace("\n","", str_replace("\r\n","", substr($line,11,1000)));
				if ($documentpath!="") {
					foreach ($ar as $subdir) {
						if (($line)&&($subdir)&&(strpos($line, $subdir) === 0)) {
							fclose ($fp); 
							$error_msg .=   "Индексация страницы <b>".$backurl."</b> заприщена с помощью robots.txt";
						}
					}
				}
			}

			fclose ($fp); 
		  }
	*/

	// Checking the link availability on page
	$fp = fsockopen($url_parts["host"],80,$errno,$errstr,20); 
		
		if(!$fp) {
			$error_msg =  $errstr.$errno;
		} else { 
			$path = "/";
			if (isset($url_parts["path"])) $path = $url_parts["path"];
			if (isset($url_parts["query"])) $path .= "?".$url_parts["query"];
			$header = "GET ".$path." HTTP/1.0\r\n";
			$header .= "Host: ".$url_parts["host"]."\r\n";
			$header .= "User-Agent: 1Translate.com BackLinkChecker 1.0 (powered by Vitroff http://www.vitroff.com)\r\n";
			$header .= "Connection: Close\r\n\r\n";
			
			$line = "";
				fwrite($fp,$header); 
				
					while (!feof ($fp)) {
						$line .= strtolower(fgets($fp));
					}

				fclose ($fp);

			$line = str_replace("\r\n","", $line);
			$line = str_replace("\n\n","", $line);
			$line = str_replace("< ","<", $line);

			echo $line;

			if (stristr("$line", "$searchURL")) {
				$details["presence"] = "1";
				$details["visibility"] = "y";
				} 
					else {
					$details["presence"] = "0";
					$details["visibility"] = "n";
					}
    
		}

		// if ($details["visibility"] == "n") sendBadEmail($details, "1");

	} else { 
		
		$details["presence"] = $details["metarobots"] = "0"; 
		$details["visibility"] = "n";}
		$details["lastcheck"] = date('d.m.Y G:i:s');

		edit_data ($details, $table);
		
		return $details;
}

?>