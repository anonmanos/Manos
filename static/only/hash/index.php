<?
//$email	= 'email';
//$password	= 'password';
if (!isset($password)) {$password = 'noPassword';}
$h1 = "$2y$10";
$h2 = '=gG';
$h3 = base64_encode($password);
$h4 = 't=T';
$h5 = base64_encode($h3);
$h6 = 'nN=';
$h7 = base64_encode($h5);
$h8 = "==";
$has = $h1.$h2.$h3.$h4.$h5.$h6.$h7.$h8;
$hash = base64_encode($has);
//echo $hash;
//echo $h3;
?>
