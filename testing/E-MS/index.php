<?php
@ob_start();
@session_start();

$time_start = microtime(true);
// Sleep for a while
usleep(100);

require_once("mainfile.php");
$PHP_SELF = "index.php";
//$_REQUEST = trimRequest($_REQUEST);
$_GET = isset($_GET)? trimRequest($_GET) : false;
$_POST = isset($_POST)? trimRequest($_POST) : false;

GOTOMODULE(isset($_GET['mod'])?$_GET['mod']:'index',isset($_GET['name'])?$_GET['name']:'index');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>E-learniing Online System</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" >

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" type="text/css" href="css/prettify.css" />

<script type="text/javascript" src="js/jquery-1.7.1.min.js" ></script>
<script type="text/javascript" src="js/javascript.js" ></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/prettify.js" ></script>
</head>
<body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true">
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1 style="width:950px;"><a href="index.php">E-learning </a><span style="font-size:21px;"><?php echo SYS_NAME;?></span></h1>
			<a href="http://www.fb.com/"><img src="images/facebook.png"></a>
			<a href="#"><img src="images/rss.png"></a>
			<a href="https://twitter.com/"><img src="images/twitter.png"></a>
		</div>
		<div id="menu">
			<?php
				$menu = isset($_GET['mod'])? $_GET['mod']:'index';
			?>
			<ul>
				<li class="first <?php echo SelectMemu($menu,'index');?>"><a href="index.php">หน้าหลัก</a></li>
				<li class="<?php echo SelectMemu($menu,'news');?>"><a href="index.php?mod=news">ข่าวสาร</a></li>
				<li class="<?php echo SelectMemu($menu,'course');?>"><a href="index.php?mod=course">รายวิชา</a></li>
				<li class="<?php echo SelectMemu($menu,'board');?>"><a href="index.php?mod=webboard">กระดานถามตอบ</a></li>
				<li class="<?php echo SelectMemu($menu,'about');?>"><a href="index.php?mod=about">เกี่ยวกับเรา</a></li>
				<li class="last <?php echo SelectMemu($menu,'contact');?>"><a href="index.php?mod=contact">ติดต่อเรา</a></li>
			</ul>
			<br class="clearfix" />
		</div>
	</div>
	<div id="page">
		<div id="content">

		<?php
			///////////////////////////////
			include("".$MODPATHFILE."");
			///////////////////////////////
		?>
			<br class="clearfix" />
		</div>
		<div id="sidebar">
			<?php
				if(empty($_SESSION['_ip'])):
					include("modules/login/index.php");
				else:
					include("modules/{$MOD[$_SESSION['_level']]}/menu.php");
				endif;
			?>
			
		</div>
		<br class="clearfix" />
	</div>
</div>
<div id="footer">
	E-learning &copy; 2012 <?php echo SYS_NAME;?>, <a href="http://www.uru.ac.th/">มหาวิทยาลัยราชภัฏอุตรดิตถ์</a> <br/> เลขที่ 27 ถ.อินใจมี ต.ท่าอิฐ อ.เมือง
จ.อุตรดิตถ์ 53000 Tel.0-5541-1096 Fax.0-5541-1296,<br/>ออกแบบ โดย : <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>. พัฒนา โดย : <a href="mail://saciw@hotmail.com">นายบรรจง  กิตติสว่างวงค์</a> สาขาวิชาเอก : <a href="http://sci.uru.ac.th/program/comsci_it/index.php">วิทยาการคอมพิวเตอร์</a>
<?php
$time_end = microtime(true);
$time = $time_end - $time_start;
$time = round($time,5);
?>
<div class="no_print" style="font-size: 80%;">หน้านี้ใช้เวลาโหลดข้อมูลทั้งสิ้น&nbsp;<?php echo $time;?>&nbsp;วินาที</div>

</div>
</body>
</html>