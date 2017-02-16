<?php
ob_start();
session_start();

require_once("mainfile.php");

$_GET = isset($_GET)? trimRequest($_GET) : false;
$_POST = isset($_POST)? trimRequest($_POST) : false;

GOTOMODULE(isset($_GET['mod'])?$_GET['mod']:'index',isset($_GET['name'])?$_GET['name']:'index');

?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
	///////////////////////////////
	include("".$MODPATHFILE."");
	///////////////////////////////
?>
