<h2>เกี่ยวกับเรา</h2>
<p>Posted by Phingosoft.com</p>
<?php
	$Filename = 'DATA/about.txt';
	//อ่านค่าจากไฟล์ Text 
	$file_open = @fopen($Filename, "r");
	$TextContent = @fread ($file_open, @filesize($Filename));
	@fclose ($file_open);
	$TextContent = DeCodeText($TextContent);
	echo $TextContent;
?>

