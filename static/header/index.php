<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- title -->
    <title><?='「GTN」'.$title?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?=$static?>/css/bootstrap.min.css"/>
    <!-- Other CSS -->
    <link rel="stylesheet" href="<?=$static?>/css/main.css"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand">
        <i class="fa fa-cube"></i>Global Testing Network</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li<?activeHome($active);?>><a href="/">Home</a></li>
          <li<?activeAbout($active);?>><a href="/about">About</a></li>
          <li<?activeContact($active);?>><a href="/contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li<?activeLogin($active);?>><a href="/login">Sign in</a></li>
          <li<?activeSignup($active);?>><a href="/signup">Create Account</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container">
