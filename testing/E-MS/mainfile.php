<?php
//หากมีการเรียกไฟล์นี้โดยตรง
if (preg_match("/^mainfile.php/",$_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}

//ตรวจสอบว่ามีโมดูลหรือไม่ (โมดูล User)
function GOTOMODULE($folders,$files){
	global $MODPATHFILE;
	if(empty($folders)){$folders = "index";} 
    if(empty($files)){$files = "index";}
	$modpathfile="modules/".$folders."/".$files.".php";

	if (file_exists($modpathfile)) {
		$MODPATHFILE = $modpathfile;
	}else{
		die ("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><center><h1 style='color:red;'>LINK&nbsp;ERROR</h1>ขอโทษทีครับ ยังไม่มีหน้านี้ครับ....<br>sAcIw กำลังจัดทำอยู่.<br><a href='javascript:history.back();'>ย้อนกลับ</a></center>");
	}
}

require_once("includes/mysql.inc.php");
require_once("includes/config.in.php");
require_once("includes/array.in.php");
require_once("includes/function.in.php");

?>