<?
  // $datetime = date("n/j/y, g:i:s A");
// sleep(1);
// $log_datetime = $datetime = date("n/j/y g:i:s a");
// function logs($log_datetime) {
//   $log_ip = $_SERVER['REMOTE_ADDR'];
//   if(isset($_SESSION['gtnsession'])) {
//     $log_users = $_SESSION['gtnsession'];
//   }
//   else {
//     $log_users = "Public";
//     $log_title = $title = "functions";
//     $static = "static";
//   }
//   $log_agent = $_SERVER['HTTP_USER_AGENT'];
//   include $static.'/only/data/index.php';
//   $sql= "insert into logs values('$log_datetime','$log_ip','$log_users','$log_title','$log_agent')";
//   mysql_query($sql) or die("error=$sql");
// }
// logs($static, $log_datetime);

function activeHome($active) {
  if (isset($active)) {
    if($active=='home') {
      echo ' class="active"';
    }
  }
}
function activeAbout($active) {
  if (isset($active)) {
    if($active=='about') {
      echo ' class="active"';
    }
  }
}
function activeContact($active) {
  if (isset($active)) {
    if($active=='contact') {
      echo ' class="active"';
    }
  }
}
function activeSignup($active) {
  if (isset($active)) {
    if($active=='signup') {
      echo ' class="active"';
    }
  }
}
function activeLogin($active) {
  if (isset($active)) {
    if($active=='login') {
      echo ' class="active"';
    }
  }
}


function checkName($active, $name) {
  if(empty($name)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your Name<br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}


function checkEmail($active, $email) {
  if(empty($email)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your Email</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter a valid email address</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}

function alreadyEmail($active, $static, $email) {
  if(empty($email)) {
  include $static.'/only/data/index.php';
  $sql		= "select * from users where user_email='$email'";
  $query		= mysql_query($sql) or die("error=$sql");
  $already	= mysql_num_rows($query);
    if(empty($already)) {
      echo '<div class="alert alert-danger" role="alert"><h3>This email address is already taken<br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }
  }
}


function checkPassword($active, $password) {
  if(empty($password)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your Password</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z0-9]{6,64}+$/", $password) == 1) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! password must be at least 6 characters</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}




function matchPassword($active, $newPassword, $confirmPassword) {
  if($newPassword!=$confirmPassword) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Your password do not match<br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}


function changePassword($active, $static, $currentPassword, $newPassword, $confirmPassword) {
  if(empty($currentPassword)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your Current Password</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z0-9]{6,64}+$/", $currentPassword) == 1) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Current Password must be at least 6 characters</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(empty($newPassword)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your New Password</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z0-9]{6,64}+$/", $newPassword) == 1) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! New Password must be at least 6 characters</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(empty($confirmPassword)) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Enter Your Confirm Password</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(!preg_match("/^[a-zA-Z0-9]{6,64}+$/", $confirmPassword) == 1) {
    echo '<div class="alert alert-danger" role="alert"><h3>Warning! Confirm Password must be at least 6 characters</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
  elseif(matchPassword($active, $newPassword, $confirmPassword)) {
  }
  elseif(isset($_SESSION['gtnsession'])) {
    include $static.'/only/data/index.php';
    $sqlp		= "select * from users where user_id='{$_SESSION['gtnsession']}'";
    $queryp		= mysql_query($sqlp) or die("error=$sqlp");
    $old = mysql_fetch_array($queryp);
    $password = $newPassword;
    $oldpassword = $old['user_password'];
    include $static.'/only/hash/index.php';
    if($oldpassword==$hash) {
      echo '<div class="alert alert-danger" role="alert"><h3>Warning! Your Current Password is Wrong<br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }elseif($hash) {
      $sql = "update users set user_password='$hash' where user_id = '{$_SESSION['gtnsession']}'";
      mysql_query($sql) or die("error=$sql");
      echo '<div class="alert alert-success" role="alert"><h3>Password updated.! <br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }
    else {
      echo "error else matchPassword";
    }
  }
}




function login($active, $static, $email, $password) {
  include $static.'/only/hash/index.php';
  include $static.'/only/data/index.php';
  $sql	= "SELECT * FROM `users` WHERE `user_email` = '$email' AND user_password = '$hash'";
  $query	= mysql_query($sql) or die("error=$sql");
  $sqlrows	= mysql_num_rows($query);
  if($sqlrows) {
    $sqlf		= "select * from users where user_email='$email'";
    $queryf		= mysql_query($sqlf) or die("error=$sqlf");
    $f		= mysql_fetch_array($queryf);
    $_SESSION["gtnsession"]=$f['user_id'];
    $_SESSION["gtnsessionname"]=$f['user_name'];
    $_SESSION["gtnsessionemail"]=$f['user_email'];
    $_SESSION["gtnsessionlocation"]=$f['user_location'];
    $_SESSION["gtnsessionwebsite"]=$f['user_website'];
    echo '<div class="alert alert-success" role="alert"><h3>Welcome to Global Testing Network!</h3><br/>Please! Wait...</div>';
    header('Refresh: 1; url=/account');
    exit();
  }
  else {
    echo '<div class="alert alert-danger" role="alert"><h3>The username or password did not match. Please try again.</h3><br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}




function profileUpdate($active, $static, $name, $email, $location ,$website) {
  include $static.'/only/data/index.php';
  if($email!==$_SESSION['gtnsessionemail']||$name!=$_SESSION["gtnsessionname"]||$location!=$_SESSION["gtnsessionlocation"]||$website!=$_SESSION["gtnsessionwebsite"]) {
    $sqll		= "select * from users where user_email='$email'";
    $queryl		= mysql_query($sqll) or die("error=$sqll");
    $fl		= mysql_fetch_array($queryl);
    $numl	= mysql_num_rows($queryl);
    if($email==$_SESSION['gtnsessionemail']) {
      $sql = "update users set user_name='$name', user_email='$email', user_location='$location', user_website='$website' where user_id = '{$_SESSION['gtnsession']}'";
      mysql_query($sql) or die("error=$sql");
      $_SESSION["gtnsessionname"]=$name;
      $_SESSION["gtnsessionemail"]=$email;
      $_SESSION["gtnsessionlocation"]=$location;
      $_SESSION["gtnsessionwebsite"]=$website;
      echo '<div class="alert alert-success" role="alert"><h3>Profile information updated.! <br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }
    elseif($numl) {
      echo '<div class="alert alert-danger" role="alert"><h3>This email address is already taken<br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }else {
      $sql = "update users set user_name='$name', user_email='$email', user_location='$location', user_website='$website' where user_id = '{$_SESSION['gtnsession']}'";
      mysql_query($sql) or die("error=$sql");
      $_SESSION["gtnsessionname"]=$name;
      $_SESSION["gtnsessionemail"]=$email;
      $_SESSION["gtnsessionlocation"]=$location;
      $_SESSION["gtnsessionwebsite"]=$website;
      echo '<div class="alert alert-success" role="alert"><h3>Profile information updated.! <br/><h4>Please! Wait...</h4></div>';
      header('Refresh: 1; url=/'.$active);
      exit();
    }
  }
  else {
    echo '<div class="alert alert-info" role="alert"><h3>Profile information not updated.! <br/><h4>Please! Wait...</h4></div>';
    header('Refresh: 1; url=/'.$active);
    exit();
  }
}



function signup($active, $static, $name, $email, $password, $confirmPassword) {
  include $static.'/only/hash/index.php';
  include $static.'/only/data/index.php';
  $sql= "insert into users values('','$name','$email','$hash','','','$datetime')";
  mysql_query($sql) or die("error=$sql");
  echo '<div class="alert alert-success" role="alert"><h3>Welcome to Global Testing Network! <a href="/login" class="alert-link">Chick Here for Login</a><br/><h4>Please! Wait...</h4></div>';
  header('Refresh: 1; url=/login');
  exit();
}

function contact($active, $static, $name, $email, $message) {
  include $static.'/only/data/index.php';
  $datetime = date("n/j/y, g:i:s A");
  $mass = base64_encode($message);
  $sql= "insert into contacts values('$datetime','$name','$email','$mass')";
  mysql_query($sql) or die("error=$sql");
  echo '<div class="alert alert-success" role="alert"><h3>Thank you for your contact.<br/><h4>Please! Wait...</h4></div>';
  header('Refresh: 1; url=/contact');
  exit();
}
?>
