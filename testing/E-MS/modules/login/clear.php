<?php
if(isset($_POST['lear'])){
	ConnectDB();
	$password=PassEnCode($_POST['password']);
	$sql="SELECT id FROM ".USER." WHERE username='{$_POST['username']}' AND password='{$password}' AND status='Y' LIMIT 1";
	$dbquery = QueryDB($sql);
	$num_rows = RowsDB($dbquery);
	if($num_rows>0){
		$rs = FetchDB($dbquery);
		$sql="UPDATE ".USER." SET login='F' WHERE id='{$rs['id']}' LIMIT 1";
		$dbquery = QueryDB($sql);
		if($dbquery){
			//แสดงว่าได้ทำการลบเสดแล้ว
			$ms = array(
			'message'=>' <strong>ลบข้อมูลการเข้าใช้ระบบที่ค้างเรียบร้อยแล้ว</strong>',
			'class'=>'btn-success',
			'yes'=>'index.php',
			'no'=>'index.php?mod=login&name=clear',
			);
			ShowProcess($ms);
		}else{
			//ลบไม่ได้
			$ms = array(
			'message'=>' <strong>ไม่สามารถลบข้อมูลเข้าใช้งานระบบที่ค้างได้</strong>',
			'class'=>'btn-danger',
			'yes'=>'index.php?mod=login&name=clear',
			'no'=>'index.php',
			);
			ShowProcess($ms);
		}//CLOSE IF $dbquery
	}else{
		//ตรวจสอบ ชื่อและรหะสผ่าน ไม่ถูกต้อง
		$ms = array(
			'message'=>' <strong>ชื่อผู้ใช้ระบบหรือรหัสผ่านไม่ถูกต้อง</strong>',
			'class'=>'btn-warning',
			'yes'=>'index.php?mod=login&name=clear',
			'no'=>'index.php',
		);
		ShowProcess($ms);
	}//CLOSE IF NUM ROWS
}else{

?>
<h4>ลบข้อมูลการเข้าใช้งานระบบครั้งก่อน</h4>
<form name="lear" method="post" action="" class="form-horizontal" onSubmit="return formCheckLear()">
<div class="control-group">
	<label for="input01" class="control-label">ชื่อผู้ใช้&nbsp;:</label>
	<div class="controls">
		<input type="text" name="username" class="input-small" placeholder="ชื่อผู้ใช้">
	</div>
</div>
<div class="control-group">
	<label for="input01" class="control-label">รหัสผ่าน&nbsp;:</label>
	<div class="controls">
		<input type="password" name="password" class="input-small" placeholder="รหัสผ่าน">
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-primary" name="lear" type="submit">ลบข้อมูล</button>
	<button class="btn">ยกเลิก</button>
</div>
</form>

<script language="Javascript" type="text/javascript">
function formCheckLear() {
	var obj = document.lear; 
	if (obj.username.value == false) {
		alert("กรุณากรอกชื่อผู้ใช้");
		obj.username.focus();
		return false;
	}
	if (obj.password.value == false) {
		alert("กรุณากรอกรหัสผ่าน");
		obj.password.focus();
		return false;
	}

}
</script>
<?php
}//CLOSE ELSE ISSET LEAR
?>