<?php
$strFileName = "tt.loging";
$objFopen = fopen($strFileName, 'a');
$strText1 = "I Love ThaiCreate.Com Line1\n";
fwrite($objFopen, $strText1);


if($objFopen) {
	echo "File writed.";
}
else {
	echo "File can not write";
}
fclose($objFopen);
?>
