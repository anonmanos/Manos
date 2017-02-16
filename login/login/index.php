<?
  session_start();
  $active = "login";
  $static = "../../static";

    $title  = "Sign in Check";
    include $static.'/only/functions/index.php';
    include $static.'/header/index.php';
    // body users code
		if (isset($_POST["email"])) {
			$email   = $_POST["email"];
		}
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
		if (isset($_POST["password"])) {
			$password   = $_POST["password"];
		}
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
		if (checkEmail($active, $email)) {
		}
		elseif(checkPassword($active, $password)) {
		}
		elseif(login($active, $static, $email, $password)){
		}
    else {
      header('Refresh: 0; url=/'.$active);
      exit();
		}
    // end body users code
    include $static.'/footer/index.php';
    // end of users code
?>
