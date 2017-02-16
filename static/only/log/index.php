<?
  // sleep(1);
  // $log_datetime = date("n/j/y g:i:s a");
  // $log_ip = $_SERVER['REMOTE_ADDR'];
  // $log_title = $title;
  // $log_users = $_SESSION["gtnsession"];
  // $log_agent = $_SERVER['HTTP_USER_AGENT'];
  // include $static.'/only/data/index.php';
  // $sql= "insert into logs values('$log_datetime','$log_ip','$log_users','$log_title','$log_agent')";
  // mysql_query($sql) or die("error=$sql");

?>


<?
  // sleep(1);
  $log_today = date("Ymd");
  $log_datetime = date("F j  H:i:s");
  $log_ip = $_SERVER['REMOTE_ADDR'];
  $log_hostname = $_SERVER['HTTP_HOST'];
  $log_title = $title;
  $log_users = $_SESSION["gtnsession"];
  $log_agent = $_SERVER['HTTP_USER_AGENT'];
  // include $static.'/only/data/index.php';
  // $sql= "insert into logs values('$log_datetime','$log_ip','$log_users','$log_title','$log_agent')";
  // mysql_query($sql) or die("error=$sql");
?>
<?php
$strFileName = $static.'/only/log/only'.$log_today.'.logs';
$objFopen = fopen($strFileName, 'a');
$strText1 = "$log_datetime  $log_ip  $log_hostname  $log_users  $log_title  $log_agent'\n";
fwrite($objFopen, $strText1);


// if($objFopen) {
// 	echo "File writed.";
// }
// else {
// 	echo "File can not write";
// }
fclose($objFopen);
?>
