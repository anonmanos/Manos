<?
  $datetime = date("n/j/y, g:i:s A");
// sleep(1);


// $log_datetime = $datetime = date("n/j/y g:i:s a");
// function logs($static, $log_datetime) {
//   $log_ip = $_SERVER['REMOTE_ADDR'];
//   if(isset($_SESSION['gtnsession'])) {
//     $log_users = $_SESSION['gtnsession'];
//   }
//   else {
//     $log_users = "Public";
//     $log_title = $title = "functions";
//   }
//   if(isset($static)) {
//
//   }
//   else {
//     $static = "../static";
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
?>
