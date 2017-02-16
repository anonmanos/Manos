<fieldset>
	<legend>ฟอร์มลืมรหัสผ่าน</legend>
<?php
if(isset($_POST['resultforget'])){
ConnectDB();
$sql="SELECT CONCAT(pname,fname,'  ',lname) AS fullname,username,password,email FROM ".USER." WHERE username='".$_POST['resultforget']."' OR email='".$_POST['resultforget']."'";
	$dbquery = QueryDB($sql);
	$num_rows = RowsDB($dbquery);
	if($num_rows<=0){
		$ms = array(
			'message'=>' <strong>ไม่มีชื่อผู้ใช้หรืออีเมล์ที่ท่านกรอกนี้</strong>',
			'class'=>'btn-warning',
			'yes'=>'index.php?mod=login&name=forgetpass',
			'no'=>'index.php',
		);
		ShowProcess($ms);
	}else{
		$result = FetchDB($dbquery);

$subject = "แจ้งการลืมรหัสผ่านสมาชิก";
$info =array(
	"{HEADDER}"=>SYS_NAME,
	"{FULLNAME}"=>$result['fullname'],
	"{USERNAME}"=>$result['username'],
	"{PASSWORD}"=>PassDeCode($result['password']),
	"{URL}"=>WEB_URL);
		if(SendMail($result['email'],$subject,$info,'forget_pass.html')){
			$ms = array(
			'message'=>' <strong>ระบบได้ส่งรหัสผ่านของท่านไปทางอีเมล์เรีบยร้อยแล้ว</strong>',
			'class'=>'btn-success',
			'yes'=>'index.php',
			'no'=>'',
		);
		ShowProcess($ms);
		}else{
			$ms = array(
			'message'=>' <strong>ระบบไม่สามารถส่งรหัสผ่านไปทางอีเมล์ได้ในขณะนี้</strong>',
			'class'=>'btn-danger',
			'yes'=>'index.php?mod=login&name=forgetpass',
			'no'=>'index.php',
			);
		ShowProcess($ms);
		}
	}
	CloseDB();
}else{
?>
       <form name="saciw" method="post" action="index.php?mod=login&name=forgetpass" onSubmit="return formCheck()">
          <table width="413" class="table">
			<thead>
             <tr align="center">
                <th >กรุณากรอก&nbsp;<font color="#FF0000">ชื่อผู้ใช้/อีเมลล์</font>&nbsp;ระบบจะส่งรหัสผ่านไปทางอีเมล์ของท่าน</th>
             </tr>
			</thead>
             <tr align="center">
                <td>ชื่อผู้ใช้/อีเมลล์&nbsp;:&nbsp;<input name="resultforget" type="text" style=" margin:0;" placeholder="ชื่อผู้ใช้/อีเมลล์">&nbsp;&nbsp;<button type="submit" class="btn btn-primary" >ตกลง</button></td>
             </tr>
           </table>
       </form>
<?php
}	
?>
</fieldset>
<script language="Javascript" type="text/javascript">
function formCheck() {
	if (document.saciw.resultforget.value == false) {
		alert("กรุณากรอกข้อมูลก่อน");
		document.saciw.resultforget.focus();
		return false;
	}

}
</script>