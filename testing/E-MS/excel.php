<?php
ob_start();
session_start();
header("content-type: application/vnd.ms-excel");
header('content-disposition: attachment; filename="myxls.xls"');#ชื่อไฟล์
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/tr/rec-html40">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
require_once("mainfile.php");

$_GET = isset($_GET)? trimRequest($_GET) : false;
$_POST = isset($_POST)? trimRequest($_POST) : false;

GOTOMODULE(isset($_GET['mod'])?$_GET['mod']:'index',isset($_GET['name'])?$_GET['name']:'index');

	///////////////////////////////
	include("".$MODPATHFILE."");
	///////////////////////////////
?>
