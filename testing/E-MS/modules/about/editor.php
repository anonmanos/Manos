<?php
	Event(); //เช็กว่ามีการล็อกอินมามัย
	Checklevel($_SESSION['s_status'],"1");
?>
<fieldset class="fieldset">
	<legend>&nbsp;</legend>
	<img src="images/icon/plus.gif" align="absmiddle"> <a href="index.php?folder=admin">หน้าหลักผู้ดูแลระบบ</a> &nbsp;&nbsp;<img src="images/icon/arrow_wap.gif" align="absmiddle">&nbsp;&nbsp;<a href="index.php?folder=other">จัดการข้อมูลเว็บ</a>&nbsp;&nbsp;<img src="images/icon/arrow_wap.gif" align="absmiddle">&nbsp;&nbsp;เกี่ยวกับเรา
</fieldset>
<fieldset class="fieldset">
	<legend>เกี่ยวกับเรา</legend>

<?php
if(isset($_GET['update'])){
	//ทำการสร้างไฟล์ text ของข่าวสาร
		$txt_name = "DATA/about.txt";
		$txt_open = @fopen("$txt_name", "w");
		@fwrite($txt_open, "".$_POST['detail']."");
		@fclose($txt_open);
	ShowProcess("5","index.php?folder=about&file=editor","ปรับปรุงข้อมูล");
}// if(isset($_GET[update]))
else{
?>
<form name="saciw" method="post" action="index.php?folder=about&file=editor&update" enctype="multipart/form-data" onSubmit="return formCheck()">
<?php
//อ่านค่าจากไฟล์ Text เพื่อแก้ไข
		$FileNewsTopic = "DATA/about.txt";
		$file_open = @fopen($FileNewsTopic, "r");
		$TextContent = @fread ($file_open, @filesize($FileNewsTopic));
		@fclose ($file_open);
		$TextContent = stripslashes($TextContent);
/////////////////////////////////////////////
include("TEXTeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('detail') ;
$oFCKeditor->BasePath	= 'TEXTeditor/' ;
$oFCKeditor->Width	= '100%' ;
$oFCKeditor->Height	= '700' ;
$oFCKeditor->Value		= $TextContent ;
$oFCKeditor->Create() ;
?>
<button type="submit" name="submit" class="submit"><img src="images/icon24/Save.png">[ปรับปรุงเกี่ยวกับเรา]</button>&nbsp;<button type="reset" name="reset" class="submit"><img src="images/icon24/Delete.png">[ยกเลิก]</button>
</form>
<?php
 } // ปิด else	
?>
</fieldset>
<script language="Javascript" type="text/javascript">
function formCheck() {
	var FCK = document.saciw.detail.value
	if (FCK.length < 20) {
		alert("เนื้อหาต้องมีอย่างน้อย 20 ตัวอักษรขึ้นไปครับ") ;
		return false;
		document.saciw.detail.focus();
	}
}

</script>