<?
  session_start();
  $active = "contact";
  $static = "../../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    $title  = "Contact Check";
    include $static.'/only/functions/index.php';
	  include $static.'/header/index.php';
	  if (isset($_POST["name"])) {
	    $name   = $_POST["name"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }
	  if (isset($_POST["email"])) {
	    $email   = $_POST["email"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }
	  if (isset($_POST["message"])) {
	    $message   = $_POST["message"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }

	  if(checkName($active, $name)){
	  }
	  elseif(checkEmail($active, $email)){
	  }
	  elseif(contact($active, $static, $name, $email, $message)){
	  }else {
	    echo "error function contact";
	  }
	  include $static.'/footer/index.php';
    // end of public coed!
  }
  else {
    // for users code!
    $title  = "Contact | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
		// body users code
	  if (isset($_POST["name"])) {
	    $name   = $_POST["name"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }
	  if (isset($_POST["email"])) {
	    $email   = $_POST["email"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }
	  if (isset($_POST["message"])) {
	    $message   = $_POST["message"];
	  }
	  else {
	    header('Refresh: 0; url=/'.$active);
	    exit();
	  }
	  if(checkName($active, $name)){
	  }
	  elseif(checkEmail($active, $email)){
	  }
	  elseif(contact($active, $static, $name, $email, $message)){
	  }else {
	    echo "error function contact";
	  }
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
