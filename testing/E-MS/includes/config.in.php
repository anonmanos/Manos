<?php

//ตั้งค่าเวลาไทย
date_default_timezone_set("Asia/Bangkok");
$script_tz = date_default_timezone_get();
strcmp($script_tz, ini_get('date.timezone'));

//Web Config 
define("SYS_NAME",'ระบบการจัดการเครื่องมือเพื่อพัฒนาบทเรียนออนไลน์');
define("_ROOT",getcwd());
define("WEB_URL","http://localhost/E-MS");

define("TIMES",time());
define("ADM_MAIL",'saciw@hotmail.com');

//MySQL Connect
define("DBHOST","localhost");
define("DBUSERNAME","root");
define("DBPASSWORD","0312");
define("DBNAME","ecms");

//MySQL table 
define("USER","users");
define("NEWS","news");
define("MAJOR","majors");
define("MAROOM","majors_room");
define("LEAR","learning");
define("LOGS","logging");
define("LESS","lesson");
define("TEST","test");
define("TEST_CH","test_choice");
define("STADY","user_stady");
define("SCORE","user_stady_score");
define("WEBBOARD","board");
define("COMMENT","board_comment");

//Pagination
define("_NUM_PAGE",20);
define("_TEST_PAGE",10);


//Icon Learning
define("LEA_P",'upload/learning/');
define("LEA_W",'40');
define("LEA_H",'40');


//ตรวจสอบ IP
//ตรวจสอบ IP ของผู้เข้าใช้ังานเว็บ 
if(!empty($_SERVER['HTTP_CLIENT_IP'])) { 
	$IPADDRESS = $_SERVER['HTTP_CLIENT_IP'];
}elseif(preg_match("[0-9]",!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))){ 
	$IPADDRESS = $_SERVER["HTTP_X_FORWARDED_FOR"];
}else{ 
	$IPADDRESS = $_SERVER["REMOTE_ADDR"];
}
define("IPADDRESS",$IPADDRESS) ;
?>


