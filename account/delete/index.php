<?
  session_start();
  $active = "delete";
  $static = "../../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    header('Refresh: 0; url=/');
  	exit();
    // end of public coed!
  }
  else {
    // for users code!
    $title  = "Delete| ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    if (isset($_POST["_csrf"])) {
      $deleteUser   = $_POST["_csrf"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if(isset($_csrf)||isset($_SESSION['gtnsession'])) {
      include $static.'-only/data/index.php';
      $sql = "delete from users where user_id = '{$_SESSION['gtnsession']}'";
      mysql_query($sql) or die("error=$sql");
      echo '<div class="alert alert-info" role="alert"><h3>Your account has been deleted.<br/><h4>Please! Wait...</h4>
            </div>';
      header('Refresh: 0; url=/');
      session_destroy();
      exit();
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
