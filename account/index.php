<?
  session_start();
  $active = "account";
  $static = "../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    header('Refresh: 0; url=/');
  	exit();
    // end of public coed!
  }
  else {
    // for users code!
    $title  = "Profile | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    include 'body/JDJ5JDEwPWdHZG1zd01HMU9aM1E9dD1UWkcxemQwMUhNVTlhTTFFOW5OPVdrY3hlbVF3TVVoTlZUbGhUVEZGT1E9PT09.php';
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
