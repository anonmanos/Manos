<?
  session_start();
  $active = "test";
  $static = "../../static";
  if(empty($_SESSION["gtnsession"])) {
    // for public code!
    $title  = "Test";
    include $static.'/functions/index.php';
    include $static.'/header/index.php';
    // body public code
    echo "body code public";
    include 'body/index.php';
    // end body public code


    include $static.'/footer/index.php';
    // end of public coed!
  }
  else {
    // for users code!
    $title  = "Test | ".$_SESSION["gtnsessionname"];
    include $static.'/only/functions/index.php';
    include $static.'/only/header/index.php';
    // body users code
    echo "body code users";
    include 'body/index.php';

    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
  }
?>
