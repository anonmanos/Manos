<?
  session_start();
  $static = "../static";
  $active = "contact";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    $title = "Contact";
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
    $title  = "Contact | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    include 'body/JDJ5JDEwPWdHZG1zd01HMU9aM1E9dD1UWkcxemQwMUhNVTlhTTFFOW5OPVdrY3hlbVF3TVVoTlZUbGhUVEZGT1E9PT09.php';

    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
