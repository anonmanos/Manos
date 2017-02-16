<?
  session_start();
  $active = "index";
  $static = "../../static";
if(empty($_SESSION["gtnsession"])){
  $title = "static";
  include $static.'/functions/index.php';
  // for public code!
  header('Refresh: 0; url=/');
  exit();
  // end of public coed!
}else {
  // for user code!
  $title = "static".$_SESSION["gtnsessionname"];
  include $static.'/only/functions/index.php';
  header('Refresh: 0; url=/');
  exit();
  // end of users coed!
}
?>
