<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'A');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
 ?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=admin&name=setting">จัดการระบบ</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=admin&name=student">นักเรียน</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#"><?php echo $ACTION[$act]; ?></a>
  </li>
</ul>
<?php

if($act==='view'):

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _NUM_PAGE;

//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"",USER,"level='S'");
?>

<a href="index.php?mod=admin&name=student&act=add" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มนักเรียนใหม่</a>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>ชื่อผู้ใช้</th>
      <th>ชื่อ - นามสกุล</th>
      <th>เพศ</th>
      <th>อีเมล์</th>
      <th>สถานะ</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT id,username,CONCAT(pname,fname,' ',lname) As fullname,sex,email,level,status,login FROM ".USER." WHERE level='S' LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><?php echo $rs['username'];?></td>
      <td><?php echo $rs['fullname'];?></td>
      <td><?php echo $rs['sex'];?></td>
      <td><a href="mailto://<?php echo $rs['email'];?>" title="<?php echo $rs['email'];?>"><i class="icon-envelope"></i></a></td>
      <td><img src="images/status/<?php echo $LOGIN[$rs['login']]['i'];?>.gif" title="<?php echo $LOGIN[$rs['login']]['v'];?>" /></td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=admin&name=student&act=edit&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขข้อมูล</a></li>
            <li><a data-toggle="modal" href="#delete_<?php echo $i;?>"><i class="icon-trash"></i> ลบข้อมูล</a></li>
			<li><a data-toggle="modal" href="#lock_<?php echo $i;?>"><i class="<?php echo $STATUS[$rs['status']]['i'];?>"></i> <?php echo $STATUS[$rs['status']]['v'];?></a></li>
          </ul>
        </div>
		<!-- box alert delete-->
		<div id="delete_<?php echo $i;?>" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการลบข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการลบข้อมูลนักเรียน  : <u><?php echo $rs['fullname'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=admin&name=student&act=delete&id=<?php echo $rs['id'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
		<!-- box alert lock-->
		<div id="lock_<?php echo $i;?>" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการระงับใช้งานข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการให้<?php echo $STATUS[$rs['status']]['v'];?>ข้อมูลนักเรียน  : <u><?php echo $rs['fullname'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=admin&name=student&act=lock&id=<?php echo $rs['id'];?>&status=<?php echo $STATUS[$rs['status']]['k'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
	  </td>
    </tr>
<?php
	$i++;
endwhile;
?>
  </tbody>
</table>

<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=admin&name=student");

endif;
# end view

if($act==='add'):

?>
<form class="well" method="post" action="index.php?mod=admin&name=student&act=insert" name="saciw" onSubmit="return formCheck()">
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
  <label>อีเมล์</label>
  <div class="input-prepend">
	<span class="add-on">@</span>
	<input id="prependedInput" name="email" class="span2" type="text" size="16" placeholder="อีเมล์">
  </div>
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> ตกลง</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end add

if($act==='insert'):
	ConnectDB();
	$sql ="SELECT id FROM ".USER." WHERE fname='".$_POST['fname']."' AND lname='".$_POST['lname']."' OR email='".trim($_POST['email'])."' OR username='".trim($_POST['username'])."'";
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
			"username"=>trim($_POST['username']),
			"password"=>PassEnCode(trim($_POST['pass_new'])),
			"pname"=>$_POST['pname'],
			"fname"=>$_POST['fname'],
			"lname"=>$_POST['lname'],
			"email"=>$_POST['email'],
			"level"=>'S',
		);

		if(InsertDB(USER,$sql)){
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=student&act=add',
				'no'=>'index.php?mod=admin&name=student',
			);
			ShowProcess($ms);
		}else{
			$ms = array(
				'message'=>' <strong>ไม่สามารถบันทึกข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
			);
			ShowProcess($ms);
		}
	}// CLOSE IF NUM_ROWS
	CloseDB();
endif;
#end insert

if($act==='edit'):

ConnectDB();
$sql = "SELECT id,username,pname,fname,lname,email FROM ".USER." WHERE id='".trim($_GET['id'])."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>
<form class="well" method="post" action="index.php?mod=admin&name=student&act=update&id=<?php echo $rs['id'];?>" name="saciw" onSubmit="return formCheck()">
<h3>ข้อมูลใช้ในระบบ</h3>
  <label>ชื่อผู้ใช้</label>
  <input type="text" name="username" class="span2 input-xlarge disabled" disabled="" size="16"  value="<?php echo $rs['username'];?>" placeholder="ชื่อผู้ใช้">
<h3>ข้อมูลเบื้องต้น</h3>
  <label>ชื่อ - นามสกุล</label>
  <input type="text" name="pname" value="<?php echo $rs['pname'];?>" class="span1" size="16" placeholder="คำนำหน้า">
  <input type="text" name="fname" value="<?php echo $rs['fname'];?>" class="span2" size="16" placeholder="ชื่อ">
  <input type="text" name="lname" value="<?php echo $rs['lname'];?>" class="span2" size="16" placeholder="นามสกุล">
  <label>อีเมล์</label>
  <div class="input-prepend">
	<span class="add-on">@</span>
	<input id="prependedInput" name="email" value="<?php echo $rs['email'];?>" class="span2" type="text" size="16" placeholder="อีเมล์">
  </div>
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end edit

if($act==='update'):
	ConnectDB();
	$sql = array(
		"pname"=>$_POST['pname'],
		"fname"=>$_POST['fname'],
		"lname"=>$_POST['lname'],
		"email"=>$_POST['email'],
	);

	if(UpdateDB(USER,$sql,"id='".trim($_GET['id'])."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=student&act=edit&id='.trim($_GET['id']),
				'no'=>'index.php?mod=admin&name=student',
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
# end update

if($act==='delete'):
	ConnectDB();
	if(DeleteDB(USER,"id='".trim($_GET['id'])."'"))
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=admin&name=student">';
	else{
		$ms = array(
				'message'=>' <strong>ไม่สามารถลบข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
		);
		ShowProcess($ms);
	}
	CloseDB();
endif;
#end delete

if($act==='lock'):
	ConnectDB();
	$sql = array(
		"status"=>$_GET['status'],
	);
	if(UpdateDB(USER,$sql,"id='".trim($_GET['id'])."' AND login='F'"))
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=admin&name=student">';
	else{
		$ms = array(
				'message'=>' <strong>ไม่สามารถ'.$STATUS[$_GET['status']]['v'].'ข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
		);
		ShowProcess($ms);
	}
	CloseDB();
endif;
#end lock
?>

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
	if(obj.email.value == false || !isValidEmail(obj.email.value)) {
		alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
		obj.email.focus();
		return false;
	}
}
</script>