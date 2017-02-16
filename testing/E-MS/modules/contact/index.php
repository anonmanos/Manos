<?php
if(isset($_POST['SEND'])):
	$subject = $_POST['subject'];
	$info =array(
		"{HEADDER}"=>SYS_NAME,
		"{SUBJECT}"=>$_POST['subject'],
		"{FULLNAME}"=>$_POST['fullname'],
		"{CONTENT}"=>$_POST['content'],
	);
	if(SendMail(ADM_MAIL,$subject,$info,'contact.html',$_POST['email'])){
		$ms = array(
			'message'=>' <strong>ระบบไดส่งข้อมูลของท่านเรียบร้อยแล้ว<br />ขอขอบพระคุณทุกๆคำแนะนำ</strong><br />จะส่งข้อมูลต่อหรือไม่?',
			'class'=>'btn-success',
			'yes'=>'index.php?mod=contact',
			'no'=>'index.php',
		);
		ShowProcess($ms);
	}else{
		$ms = array(
			'message'=>' <strong>ระบบไม่สามารถส่งข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
			'class'=>'btn-danger',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);		
	}//CLOSE IF SEND EMAIL
else:
?>
<form class="well" method="post" action="" name="saciw" onSubmit="return formCheck()">
  <label>ชื่อ&nbsp;-&nbsp;นามสกุล</label>
  <input type="text" name="fullname" class="span3" size="16" placeholder="ชื่อ - นามสกุล">
  <label>อีเมล์</label>
  <input id="prependedInput" name="email" class="span2" type="text" size="16" placeholder="อีเมล์">
  <label>เหตุผลในการติดต่อ</label>
  <div class="controls">
	<select name="subject">
		<option value="">เลือกประเภท</option>
		<option value="ข้อคิดเห็นทั่วไป">ข้อคิดเห็นทั่วไป</option>
		<option value="แจ้งข้อผิดพลาด">แจ้งข้อผิดพลาด</option>
		<option value="ต้องการความช่วยเหลือ">ต้องการความช่วยเหลือ</option>
		<option value="ติดต่อผู้ดูแลระบบ">ติดต่อผู้ดูแลระบบ</option>
	</select>
  </div>
  <label>ข้อคิดเห็นของท่าน</label>
  <div class="controls">
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<textarea name="content" id="textarea"></textarea>
  </div>
  <label></label>
  <button type="submit" name="SEND" class="btn btn-primary">ตกลง</button>
</form>
<script type="text/javascript">
<!--
	CKEDITOR.replace( 'textarea',{	
		height 	: 300,
		toolbar : "Basic",
	} );
//-->
function formCheck() {
	
	var obj = document.saciw;
	if (obj.fullname.value == false) {
		alert("กรุณากรอกชื่อ-นามสกุล");
		obj.fullname.focus();
		return false;
	}
	if(obj.email.value == false || !isValidEmail(obj.email.value)) {
		alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
		obj.email.focus();
		return false;
	}
	if (obj.subject.value == '') {
		alert("กรุณาเลือกหัวข้อด้วย");
		obj.subject.focus();
		return false;
	}
	if (obj.content.value == false) {
		alert("กรุณากรอกเนื้อหา");
		obj.content.focus();
		return false;
	}
}
</script>
<?php
endif;
?>
