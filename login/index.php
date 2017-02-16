<?
  session_start();
  $active = "login";
  $static = "../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    $title  = "Sign in";
    include $static.'/functions/index.php';
    include $static.'/header/index.php';
    // body code
    include 'body/JDJ5JDEwPWdHZG1zd01HMU9aM1E9dD1UWkcxemQwMUhNVTlhTTFFOW5OPVdrY3hlbVF3TVVoTlZUbGhUVEZGT1E9PT09.php';
    // end body code
    include $static.'/footer/index.php';
    // end of public coed!
  }
  else {
    // for users code!
    header('Refresh: 0; url=/account');
  	exit();
    // end of users code!
  }
?>
