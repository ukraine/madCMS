<?
include "lib/lib.php";
if (!@include "lib/$section.func.php")	include "lib/default.func.php";
if (!@include "lib/$section.php")		include "lib/default.php";
include "templates/index.html";
?>