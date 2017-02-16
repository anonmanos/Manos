<?
  session_start();
  $active = "account";
  $static = "../../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    header('Refresh: 0; url=/');
  	exit();
    // end of public coed!
  }
  else {
    // for users code!
    $title  = "Password | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    if (isset($_POST["currentPassword"])) {
      $currentPassword   = $_POST["currentPassword"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (isset($_POST["newPassword"])) {
      $newPassword   = $_POST["newPassword"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (isset($_POST["confirmPassword"])) {
      $confirmPassword   = $_POST["confirmPassword"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (changePassword($active, $static, $currentPassword, $newPassword, $confirmPassword)) {
      echo "error changePassword";
    }
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
