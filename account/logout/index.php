<?
  session_start();
  $active = "logout";
  $static = "../../static";
    // for users code!
    $title  = "Logout";
    include $static.'/only/functions/index.php';
    include $static.'/header/index.php';
    // body users code
    session_destroy();
    echo '<div class="alert alert-info" role="alert"><h3>Thank you for join!<br/><h4>Please! Wait...</h4></div>';
		header('Refresh: 0; url=/');
		exit();
    // end body users code
    include $static.'/only/footer/index.php';
    // end of users code!
?>
