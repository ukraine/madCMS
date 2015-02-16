<?

error_reporting(0);

include "../lib/configs.php";
include "../lib/shared.php";
include "../lib/main.func.php";

function getSiteMapXML($SiteMapLinks="") {

	/* 13.02.2008
	for мультивложенность
	*/

	$query = "SELECT * FROM `".PREFIX."pages` WHERE `visibility`='y' ORDER BY `priority` DESC";

	$result = mysql_query ($query);
	$num_links =  mysql_num_rows($result);

    for ($i=0; $i<$num_links; $i++){
        
		$row = mysql_fetch_array($result);
	
		$lastmod = "<lastmod>".date("Y-m-d",ConvertMysqlTimeStampToUnixTime2($row['timestamp']))."</lastmod>\n";;
		
		$SiteMapLinks .= "<url>\n<loc>".SITEURL."$row[id]/</loc>\n$lastmod<changefreq>monthly</changefreq>\n<priority>0.$row[priority]</priority>\n</url>\n";
    
	}
	return $SiteMapLinks;

}

echo getSiteMapXML ();

?>