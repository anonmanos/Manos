<?php
if (isset($_POST['login']) AND ($_POST['login']===(md5('login')))):
	ConnectDB();
	$password=PassEnCode($_POST['password']);
	$sql="SELECT id,fname,lname,level,icon FROM ".USER." WHERE username='".$_POST['username']."' AND password='".$password."' AND login='F'";
	$dbquery = QueryDB($sql);
	$num_rows = RowsDB($dbquery);
	if ($num_rows===1):
		$rs = FetchDB($dbquery);
		$_SESSION['_ip'] = session_id();
		$_SESSION['_id'] = $rs['id'];
		$_SESSION['_fname'] = $rs['fname'];
		$_SESSION['_lname'] = $rs['lname']; // ใช้ในการแสดงชื่อหน้าแรก
		$_SESSION['_username'] = $_POST['username']; // ใช้ในเว็บบอร์ด
		$_SESSION['_level'] = $rs['level'];
		$_SESSION['_icon'] = $rs['icon'];
		$sql = array(
			"uid"=>$rs['id'],
			"atime"=>TIMES,
			"event"=>'LI',
			"ipaddr"=>IPADDRESS,
		);
		if(InsertDB(LOGS,$sql));
		$sql="UPDATE ".USER." SET login='O' WHERE id='{$rs['id']}' LIMIT 1";
		$dbquery = QueryDB($sql);
		echo "
		<div class=\"alert alert-success\">
			<strong>ยินดีต้อนรับ&nbsp;!</strong>คุณ&nbsp;{$rs['fname']}
		</div>
		<meta http-equiv=\"refresh\" content=\"3.5;URL=index.php?mod={$MOD[$rs['level']]}\">";
	else:
		echo "
		<div class=\"alert alert-error\">
			<strong>ข้อผิดพลาด&nbsp;?</strong>กรุณาตรวจสอบข้อมูลอีกครั้ง.
		</div>
		<meta http-equiv=\"refresh\" content=\"3.5;URL=index.php\">";
		/*
		echo "
		<div class=\"alert fade in\">
            <a href=\"index.php\" data-dismiss=\"alert\" class=\"close\">&times;</a>
            <strong>เกิดข้อผิดพลาด!</strong> กรุณาตรวจสอบข้อมูลอีกครั้ง.
          </div>";
		*/
	endif;
else:
?>
<form name="login" class="well form-inline" method="POST" action="index.php" onSubmit="return formCheckLogin()">
	<div>
		<label class="span1" style="margin:0;">ชื่อผู้ใช้</label><label class="span1">รหัสผ่าน</label>
	</div>
	<input type="text" name="username" class="input-small" placeholder="ชื่อผู้ใช้">
	<input type="password" name="password" class="input-small" placeholder="รหัสผ่าน">
	<button type="submit" class="btn">เข้าสู่ระบบ</button>
	<input type="hidden" name="login" value="<?php echo md5('login');?>"><hr style="margin:5px 0;"/>
	<a href="index.php?mod=login&name=forgetpass">ลืมรหัสผ่าน</a><br/>
	<a href="index.php?mod=login&name=clear">กรณีผู้ใช้เข้าสู่ระบบไม่ได้</a><br/>
	<a href="index.php?mod=login&name=register">ลงทะเบียนเรียน</a><br/>
	<!--  class="btn btn-info btn-small" -->
</form>
<script language="Javascript" type="text/javascript">
function formCheckLogin() {	
	var obj = document.login; 
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
endif;
?>