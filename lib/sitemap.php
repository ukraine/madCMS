<<? echo ('?') ?>xml version="1.0" encoding="UTF-8"?>
<urlset 
	xmlns="http://www.google.com/schemas/sitemap/0.84"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
	http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
<?

error_reporting(0);

include "../lib/configs.php";
include "../lib/shared.php";
include "../lib/main.func.php";

function getSiteMapXML($SiteMapLinks="") {

	// 13.02.2008

	global $link;

	$query = "SELECT * FROM `".PREFIX."pages` WHERE `visibility`='y' ORDER BY `priority` DESC";

	$result = mysqli_query ($link, $query);
	$num_links =  mysqli_num_rows($result);

    for ($i=0; $i<$num_links; $i++){
        
		$row = mysqli_fetch_array($result);
	
		$lastmod = "<lastmod>".date("Y-m-d",ConvertMysqlTimeStampToUnixTime($row['timestamp']))."</lastmod>\n";;
		
		$SiteMapLinks .= "<url>\n<loc>".SITEURL."$row[id]/</loc>\n$lastmod<changefreq>monthly</changefreq>\n<priority>0.$row[priority]</priority>\n</url>\n";
    
	}
	return $SiteMapLinks;

}

echo getSiteMapXML ();

?></urlset>