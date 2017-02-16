<?php
function UploadResizeIMG($File="",$Filenames="",$Width="",$Height="",$Folder=""){
$filepath=$File['tmp_name'];
$type = array(explode('.',$File['name']));
$type = end($type);
$type = strtolower($type);
exit();
if ($type == "jpg" or $type == "jpeg" or $type =="png" or $type=="gif") {
	//copy($fileupload,$fileupload_name);

	if ($type =="jpg" or $type =="jpeg") {
		$ori_img = imagecreatefromjpeg($filepath);
		$Filenames .= ".jpg";
	} else if ($type =="png") {
		$ori_img = imagecreatefrompng($filepath);
		$Filenames .= ".png";
	} else if ($type =="gif") {
		$ori_img = imagecreatefromgif($filepath);
		$Filenames .= ".gif";
	}

	list($ori_w,$ori_h) = getimagesize($filepath);
	$path = $Folder.$Filenames;
	if ($ori_w>$Width OR $ori_h>$Height){
		if($ori_w>$Width){
			$new_w = $Width; 
			$new_h = round(($new_w/$ori_w) * $ori_h);
		}else{
			$new_h = $Height; 
			$new_w = round(($new_h/$ori_h) * $ori_w);
		}
		
		$new_img= imagecreatetruecolor($new_w,$new_h);
		imagecopyresized($new_img,$ori_img,0,0,0,0,$new_w,$new_h,$ori_w,$ori_h);
		
		if ($type =="jpg" or $type =="jpeg") {
			imagejpeg($new_img,$path);
		} else if ($type =="png") {
			imagepng($new_img,$path);
		} else if ($type =="gif") {
			imagegif($new_img,$path);
		}

		imagedestroy($ori_img); 
		imagedestroy($new_img); 
	}else{
		@copy($filepath,$path);
	}
    unlink($filepath);
	return $Filenames;
} else {
	return false;
}
}
?>