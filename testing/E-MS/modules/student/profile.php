<?php
/*Programming by. sAcIw*/
 EventLogin($_SESSION,'S');
 $act = empty($_GET['act'])? 'view' : $_GET['act'];
 if($act==='data'):
	ConnectDB();
	$sql = array(
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
	);

	if(UpdateDB(USER,$sql,"username='".$_SESSION['_username']."'")){
		$_SESSION['_fname']=$_POST['fname'];
		$_SESSION['_lname']=$_POST['lname'];
		$_SESSION['_icon']=$_POST['icon'];
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=student&name=profile#data',
				'no'=>'index.php?mod=student',
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
	CloseDB();
 endif;
 if($act==='pass'):
	ConnectDB();
	if(UpdateDB(USER,array('password'=>PassEnCode(trim($_POST['pass_new']))),"username='".$_SESSION['_username']."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=student&name=profile#pass',
				'no'=>'index.php?mod=student',
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
	CloseDB();
 endif;
 if($act==='view'):
 ConnectDB();
$sql = "SELECT pname,fname,lname,birthday,sex,age,education,class,room,email,icon,username FROM ".USER." WHERE username='".$_SESSION['_username']."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
 ?>
 <ul class="nav nav-tabs" id="tab">
	<li class="active"><a data-toggle="tab" href="#data">ข้อมูลส่วนตัว</a></li>
    <li ><a data-toggle="tab" href="#pass">เปลี่ยนรหัสผ่าน</a></li>     
</ul>
<!-- My Tab-content -->
<div class="tab-content" id="myTabContent">
	<!-- Home -->
	<div id="data" class="tab-pane fade active in">
<script type="text/javascript" src="js/jquery.ui.datepicker-th.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.8.4.custom.min.js" ></script>
<link type="text/css" href="css/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />

<script type="text/javascript">
    $(function(){
        // Datepicker
        $('#datepicker').datepicker({
            changeMonth: true,
            changeYear: true,
			dateFormat: "d/MM/yy",
			altField: '#alternate_date', altFormat: 'yy-mm-dd'
        });
    });
</script>
		<form class="well" name="data"  method="post" action="index.php?mod=student&name=profile&act=data" onSubmit="return formCheckdata()">
			<label>ชื่อ - นามสกุล</label>
			<input type="text" name="pname" value="<?php echo $rs['pname'];?>" class="span1" size="16" placeholder="คำนำหน้า">
			<input type="text" name="fname" value="<?php echo $rs['fname'];?>" class="span2" size="16" placeholder="ชื่อ">
			<input type="text" name="lname" value="<?php echo $rs['lname'];?>" class="span2" size="16" placeholder="นามสกุล">
			<label>วัน/เดือน/ปี เกิด</label>
			<?php
				$birthday = $rs["birthday"];
				$birthday = explode("-",$birthday);
				//ตรวจสอบค่าว่าง
				if($birthday[2]>1)
					$birthday = $birthday[2].'/'.$FULL_MONTH2[$birthday[1]].'/'.$birthday[0];
				else
					$birthday = $rs["birthday"];

			?>
			<input type="text" class="span2" value="<?php echo $birthday;?>" id="datepicker" size="16" placeholder="วัน/เดือน/ปี">
			<input type="hidden" name="birthday" value="<?php echo $rs["birthday"];?>" id="alternate_date">
			<label class="form-inline">  
				<span>เพศ</span>
				<label class="checkbox">
					<input type="radio" name="sex" value="ช" <?php echo Correct("ช",$rs["sex"],'c');?>>ชาย
				</label>
				<label>
					<input type="radio" name="sex" value="ญ" <?php echo Correct("ญ",$rs["sex"],'c');?>>หญิง
				</label>
			</label>
			<!-- <span>อายุ</span>
			<input type="text" name="age" class="span1" maxlength="2" value="<?php echo $rs["age"];?>" onkeypress="check_number(event);" placeholder="อายุ"> -->
			<label>การศึกษา</label>
			<select name="education" style="width:120px;">
				<option value="">เลือกการศึกษา</option>
				<?php
					foreach($EDUC As $v=>$k):
				?>
				<option value="<?php echo $v; ?>" <?php echo Correct($v,$rs["education"],'s');?>><?php echo $k; ?></option>
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
				<option value="<?php echo $i; ?>" <?php echo Correct($rs["class"],sprintf($i),'s');?>><?php echo $i; ?></option>
				<?php
					endfor;
				?>
			</select>
			<span>ห้อง</span>
			<input type="text" name="room" class="span1" maxlength="2" value="<?php echo $rs["room"];?>" onkeypress="check_number(event);" placeholder="ห้อง">
			<label>อีเมล์</label>
			<input id="prependedInput" name="email" value="<?php echo $rs['email'];?>" class="span2" type="text" size="16" placeholder="อีเมล์">
			<label>รูปไอคอน</label>
			<div class="controls">
				<select name="icon" class="span2" onchange="showimage();">
					<option value="img (238).gif">เลือกรูปไอคอน</option>
					<?php
						$i =1;
						while($i<238){
							echo "<option value='img ({$i}).gif' ".Correct($rs['icon'],"img ({$i}).gif",'s').">img({$i})</option>\n";
							$i++;
						}
					?>
				</select>
			</div>
			<label>ตัวอย่างรูป</label>
			<img src="images/avatar/<?php echo $rs['icon'];?>" name="avatar" />
			<label></label>
			<button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
			<a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
		</form>
<script language="JavaScript">
 function showimage(){
      if (!document.images)
         return
		//use path form $avatardir
	  document.images.avatar.src='images/avatar/'+
		  document.data.icon.options[document.data.icon.selectedIndex].value
}
</script>
<script language="JavaScript">
function formCheckdata() {
	
	var obj = document.data;
	if (obj.username.value == false) {
		alert("กรุณากรอกชื่อผู้ใช้");
		obj.username.focus();
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
	if(obj.email.value == false || isValidEmail(obj.email.value) == false)) {
		alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
		obj.email.focus();
		return false;
	}
}
</script>
	</div>
	<!-- end Home -->

	<!-- Profile -->
	<div id="pass" class="tab-pane fade">
		<form class="well" name="pass" method="post" action="index.php?mod=student&name=profile&act=pass" onSubmit="return formCheckpass()">
			<label>ชื่อผู้ใช้</label>
			<input type="text" value="<?php echo $rs['username'];?>" disabled class="span2" size="16" placeholder="ชื่อผู้ใช้">
			<label>รหัสผ่าน</label>
			<input type="password" name="pass_new" class="span2" size="16" placeholder="รหัสผ่าน">
			<input type="password" name="pass_cfm" class="span2" size="16" placeholder="ยืนยันรหัสผ่าน">
			<label></label>
			<button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
			<a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
		</form>
<script language="Javascript" type="text/javascript">

function formCheckpass() {
	
	var obj = document.pass;
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
}
</script>
	</div>
	<!-- end Profile -->
</div>
<!-- end My Tab-content -->
<?php
endif;
#end view
?>