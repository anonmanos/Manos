<?php
/* ตรวจสอบการล็อกอิน */
EventLogin($_SESSION,'A');

$act = empty($_GET['act'])? 'view' : $_GET['act'];
$Filename = 'DATA/about.txt';
if($act==='view'):

//EnCodeText();
//DeCodeText();

//อ่านค่าจากไฟล์ Text เพื่อแก้ไข
$file_open = @fopen($Filename, "r");
$TextContent = @fread ($file_open, @filesize($Filename));
@fclose ($file_open);
$TextContent = DeCodeText($TextContent);
?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=admin">หน้าหลักผู้ดูแลระบบ</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">เกี่ยวกับเรา</a>
  </li>
</ul>
<!-- เรียกใช้ CKEditor -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form method="post" action="index.php?mod=admin&name=about&act=update" name="saciw">
<textarea name="detail" id="about"  class="ckeditor">
<?php echo $TextContent;?>
</textarea>
<br>
<label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>

<?php
endif;// CLOSE IF FORM ADD


/*
///////////// UPDATE ///////////
*/
if($act==='update'):
		
	//ทำการสร้างไฟล์ text ของข่าวสาร
	$txt_open = @fopen($Filename, "w");
	if(@fwrite($txt_open, "".trim($_POST['detail'])."")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=about',
				'no'=>'index.php?mod=admin',
		);
		ShowProcess($ms);
	}else{
		$ms = array(
				'message'=>' <strong>ไม่สามารถแก้ไขข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
		);
		ShowProcess($ms);
	}
	@fclose($txt_open);
endif;// CLOSE IF FORM UPDATE


?>
<script type="text/javascript">
//<![CDATA[
	CKEDITOR.replace( 'about',{	
		height 	: 450
	} );
//]]>
</script>