<?php
/*Programming by. sAcIw*/

// ค่า action = add,insert,edit,update,delete
if(isset($_POST['act']) AND $_POST['act']==='sAcIw'):
#print_r($_POST);
	ConnectDB();
	$sql ="SELECT id FROM ".USER." WHERE fname='".$_POST['fname']."' AND lname='".$_POST['lname']."' OR email='".$_POST['email']."' OR username='".$_POST['username']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>ข้อมูลซ้ำกันนะ<br />ปรับเปลี่ยนข้อมูล</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{
		$sql = array(
			"username"=>$_POST['username'],
			"password"=>PassEnCode($_POST['pass_new']),
			"pname"=>$_POST['pname'],
			"fname"=>$_POST['fname'],
			"lname"=>$_POST['lname'],
			"birthday"=>$_POST['birthday'],
			"sex"=>$_POST['sex'],
			//"age"=>$_POST['age'],
			"education"=>$_POST['education'],
			"class"=>$_POST['class'],
			"room"=>$_POST['room'],
			"email"=>$_POST['email'],
			"icon"=>$_POST['icon'],
			"level"=>'S',
		);

		if(InsertDB(USER,$sql)){
			$id = mysql_insert_id();
			$sql="SELECT id,fname,lname,level,icon FROM ".USER." WHERE id='{$id}' LIMIT 1";
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
			endif;
			$ms = array(
				'message'=>' <strong>สมัครสมาชิกเรียบร้อย<br />ตกลงเพื่อเข้าสู่ระบบ</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=student',
				'no'=>'#',
			);
			ShowProcess($ms);
		}else{
			$ms = array(
				'message'=>' <strong>ไม่สามารถสมัครสมาชิกได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
			);
			ShowProcess($ms);
		}
	}// CLOSE IF NUM_ROWS
	CloseDB();
else:
 ?>
<script type="text/javascript" src="js/jquery.ui.datepicker-th.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js" ></script>
<link type="text/css" href="css/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />

<script type="text/javascript">
    $(function(){
        // Datepicker
        $('#datepicker').datepicker({
			/*maxDate: '+1y +6m',
			hideIfNoPrevNext: true,
			minDate: 'Now',*/
            changeMonth: true,
            changeYear: true,
			dateFormat: "d/MM/yy",
			altField: '#alternate_date', altFormat: 'yy-mm-dd'
        });
    });
</script>
<form class="well" method="post" name="saciw" onSubmit="return formCheck()">
<h3>ข้อมูลใช้ในระบบ</h3>
  <label>ชื่อผู้ใช้</label>
  <input type="text" name="username" class="span2" size="16" placeholder="ชื่อผู้ใช้">
  <label>รหัสผ่าน</label>
  <input type="password" name="pass_new" class="span2" size="16" placeholder="รหัสผ่าน">
  <input type="password" name="pass_cfm" class="span2" size="16" placeholder="ยืนยันรหัสผ่าน">

<h3>ข้อมูลเบื้องต้น</h3>
  <label>ชื่อ - นามสกุล</label>
  <input type="text" name="pname" class="span1" size="16" placeholder="คำนำหน้า">
  <input type="text" name="fname" class="span2" size="16" placeholder="ชื่อ">
  <input type="text" name="lname" class="span2" size="16" placeholder="นามสกุล">
  <label>วัน/เดือน/ปี เกิด</label>
  <input type="text" class="span2" id="datepicker" size="16" placeholder="วัน/เดือน/ปี เกิด">
  <input type="hidden" name="birthday" id="alternate_date">

  <label class="form-inline">  
	<span>เพศ</span>
	<label class="checkbox">
		<input type="radio" name="sex" value="ช" checked>ชาย
	</label>
	<label>
		<input type="radio" name="sex" value="ญ">หญิง
	</label>
  </label>
  <!-- <span>อายุ</span>
  <input type="text" name="age" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="อายุ"> -->
  <label>การศึกษา</label>
  <select name="education" style="width:120px;">
	<option value="">เลือกการศึกษา</option>
	<?php
	foreach($EDUC As $v=>$k):
	?>
	<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
	<?php
	endforeach;
	?>
  </select>
  <span>ชั้น</span>
  <select name="class" style="width:80px;">
	<option value="">เลือกชั้น</option>
	<?php
	for($i=1;$i<=6;$i++):
	?>
	<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	endfor;
	?>
  </select>
  <span>ห้อง</span>
  <input type="text" name="room" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="ห้อง">
  <label>อีเมล์</label>
  <input id="prependedInput" name="email" class="span2" type="text" size="16" placeholder="อีเมล์">
  <label>รูปไอคอน</label>
  <div class="controls">
	<select id="select01" name="icon" onchange="showimage();">
		<option value="img (238).gif">เลือกรูปไอคอน</option>
		<?php
			$i =1;
			while($i<238){
				echo "<option value='img ({$i}).gif'>img({$i})</option>\n";
				$i++;
			}
		?>
	</select>
  </div>
  <label>ตัวอย่างรูป</label>
  <img src="images/avatar/img (238).gif" name="avatar" />
  <label></label>
   <button type="submit" name="act" value="sAcIw" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> ตกลง</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a> 
</form>
<script language="JavaScript">
 function showimage()
   {
      if (!document.images)
         return
		//use path form $avatardir
	  document.images.avatar.src='images/avatar/'+
		  document.saciw.icon.options[document.saciw.icon.selectedIndex].value
   }
</script>
<script language="Javascript" type="text/javascript">

function formCheck() {
	
	var obj = document.saciw;
	if (obj.username.value == false) {
		alert("กรุณากรอกชื่อผู้ใช้");
		obj.username.focus();
		return false;
	}
	if (obj.pass_new.value == false) {
		alert("กรุณากรอกรหัสผ่าน");
		obj.pass_new.focus();
		return false;
	}
	if (obj.pass_cfm.value == false) {
		alert("กรุณายืนยันรหัสผ่าน");
		obj.pass_cfm.focus();
		return false;
	}
	if (obj.pass_new.value != obj.pass_cfm.value) {
		alert("รหัสผ่านยืนยันไม่ถูกต้อง");
		obj.pass_cfm.focus();
		return false;
	}
	if (obj.pname.value == false) {
		alert("กรุณากรอกคำนำหน้าชื่อ");
		obj.pname.focus();
		return false;
	}
	if (obj.fname.value == false) {
		alert("กรุณากรอกชื่อ");
		obj.fname.focus();
		return false;
	}
	if(obj.lname.value == false) {
		alert("กรุณากรอกนามสกุล");
		obj.lname.focus();
		return false;
	}
	if(obj.birthday.value == false) {
		alert("กรุณากรอกวันเกิด");
		obj.birthday.focus();
		return false;
	}
	/*if(obj.age.value == false) {
		alert("กรุณากรอกอายุ");
		obj.age.focus();
		return false;
	}*/
	if(obj.education.value == false) {
		alert("กรุณาเลือกระดับการศึกษา");
		obj.education.focus();
		return false;
	}
	if(obj.class.value == false) {
		alert("กรุณาเลือกระดับชั้น");
		obj.class.focus();
		return false;
	}
	if(obj.room.value == false) {
		alert("กรุณากรอกห้อง");
		obj.room.focus();
		return false;
	}
	if(obj.email.value == false || isValidEmail(obj.email.value) == false) {
		alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
		obj.email.focus();
		return false;
	}
}
</script>
<?php
endif;
//ปิด if act
?>