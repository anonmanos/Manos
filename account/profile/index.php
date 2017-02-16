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
    $active = "account";
    $title  = "Profile | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    if (isset($_POST["name"])) {
      $name = $_POST["name"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (isset($_POST["email"])) {
      $email = $_POST["email"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (isset($_POST["location"])) {
      $location = $_POST["location"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (isset($_POST["website"])) {
      $website = $_POST["website"];
    }
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    if (checkName($active, $name)) {
      echo "error checkName";
    }
    elseif (checkEmail($active ,$email)) {
      echo "error checkEmail";
    }
    else {
      profileUpdate($active, $static, $name, $email, $location ,$website);
    }
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
