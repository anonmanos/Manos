<?
  $title  = "Signup";
  $active = "signup";
  $static = "../../static";
  include $static.'/only/functions/index.php';
  include $static.'/header/index.php';
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
  if (isset($_POST["password"])) {
    $password   = $_POST["password"];
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

  if(checkName($active, $name)){
  }
  elseif(checkEmail($active, $email)){
  }
  elseif(alreadyEmail($active, $static, $email)){
  }
  elseif(checkPassword($active, $password)){
  }
  elseif(matchPassword($active, $password, $confirmPassword)){
  }
  elseif(signup($active, $static, $name, $email, $password, $confirmPassword)){
  }else {
    echo "error function signup";
  }
  // end body users code
  include $static.'/only/footer/index.php';
  // end of users code!
?>
