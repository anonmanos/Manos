<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'A');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
 ?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=admin">หน้าหลักผู้ดูแลระบบ</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=admin&name=learning">กลุ่มสาระการเรียนรู้</a> <span class="divider">/</span>
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
List($goto,$totalpage) = SelectPage($page,$each,"",LEAR,"");
?>
<a href="index.php?mod=admin&name=learning&act=add" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มกลุ่มสาระการเรียนรู้ใหม่</a>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>หัวข้อ</th>
      <th>ประกาศ</th>
      <th>ปรับปรุง</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT a.id,a.code,a.title,a.create_time,a.update_time FROM ".LEAR." As a LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
  
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><?php echo '('.$rs['code'].')'.$rs['title'];?></td>
      <td><?php echo ThaiTimeConvert($rs['create_time']);?></td>
      <td><?php echo ThaiTimeConvert($rs['update_time']);?></td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=admin&name=learning&act=edit&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขข้อมูล</a></li>
            <li><a data-toggle="modal" href="#delete_<?php echo $i;?>"><i class="icon-trash"></i> ลบข้อมูล</a></li>
          </ul>
        </div>
		<!-- box alert -->
		<div id="delete_<?php echo $i;?>" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการลบข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการลบข้อมูลกลุ่มสาระการเรียนรู้ : <u><?php echo $rs['title'];?></u>  นี้หรือไม่ ?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=admin&name=learning&act=delete&id=<?php echo $rs['id'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
	  </td>
    </tr>
<?php
	$i++;
endwhile;

CloseDB();
?>
  </tbody>
</table>

<!-- 
<a href="index.php?mod=admin&name=learning&act=edit&id=<?php echo $rs['id'];?>" class="btn btn-warning"><i class="icon-pencil icon-white"></i> แก้ไขข้อมูล</a>
		<a href="index.php?mod=admin&name=learning&act=delete&id=<?php echo $rs['id'];?>" class="btn btn-danger"><i class="icon-trash icon-white"></i> ลบข้อมูล</a>
-->
<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=admin&name=learning");

endif;
# end view

if($act==='add'):

?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=admin&name=learning&act=insert" name="saciw" onSubmit="return formCheck()">
  <label>รหัสกลุ่ม</label>
  <input type="text" name="code" class="span1" size="16" placeholder="รหัสกลุ่ม">
  <label>ชื่อกลุ่มสาระการเรียนรู้</label>
  <input type="text" name="title" class="span3" size="16" placeholder="ชื่อกลุ่มสาระการเรียนรู้">
  <label>รายละเอียด</label>
  <div class="controls">
	<textarea id="textarea" name="content" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <!-- <label>ไอคอน</label>
  <input type="file" name="icon" id="fileInput" class="input-file"> -->
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> บันทึก</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end add

if($act==='insert'):
	ConnectDB();
	$sql ="SELECT id FROM ".LEAR." WHERE code='".$_POST['code']."' OR title='".$_POST['title']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>ข้อมูลที่กรอกมีอยู่ในระบบแล้ว<br />กรุณาตรวจสอบข้อมูล</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{
		/*include('includes/uploadresize.php');
		$icon = UploadResizeIMG($_FILES['icon'],TIMES,LEA_W,LEA_H,LEA_P);*/

		$sql = array(
			"code"=>$_POST['code'],
			"title"=>$_POST['title'],
			"content"=>EnCodeText($_POST['content']),
			"create_time"=>TIMES,
			"update_time"=>TIMES,
			//"icon"=>$icon,
		);

		if(InsertDB(LEAR,$sql)){
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=learning&act=add',
				'no'=>'index.php?mod=admin&name=learning',
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
$sql = "SELECT id,code,title,content FROM ".LEAR." WHERE id='".trim($_GET['id'])."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=admin&name=learning&act=update&id=<?php echo $rs['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>รหัสกลุ่ม</label>
  <input type="text" name="code" class="span1" size="16" value="<?php echo $rs['code'];?>"  placeholder="รหัสกลุ่ม">
  <label>ชื่อกลุ่มสาระการเรียนรู้</label>
  <input type="text" name="title" class="span3" size="16" value="<?php echo $rs['title'];?>" placeholder="ชื่อกลุ่มสาระการเรียนรู้">
  <label>รายละเอียด</label>
  <div class="controls">
	<textarea id="textarea" name="content" class="input-xlarge ckeditor" rows="5">
	<?php echo DeCodeText($rs['content']);?>
	</textarea>
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
		"code"=>$_POST['code'],
		"title"=>$_POST['title'],
		"content"=>EnCodeText($_POST['content']),
		"update_time"=>TIMES,
	);

	if(UpdateDB(LEAR,$sql,"id='".trim($_GET['id'])."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=learning&act=edit&id='.trim($_GET['id']),
				'no'=>'index.php?mod=admin&name=learning',
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
	if(DeleteDB(LEAR,"id='".trim($_GET['id'])."'")){
		/*$ms = array(
				'message'=>' <strong>ลบข้อมูลเรียบร้อย</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=learning',
				'no'=>'',
		);
		ShowProcess($ms);*/
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=admin&name=learning">';
	}else{
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
?>

<script language="Javascript" type="text/javascript">
//<![CDATA[
	//defult ถ้าประกาศใน textarea id="textarea"
	CKEDITOR.replace( 'textarea',{	
		height 	: 400
	} );
//]]>

function formCheck() {
	
	var obj = document.saciw;
	if (obj.code.value == false) {
		alert("กรุณากรอกรหัสกลุ่ม");
		obj.code.focus();
		return false;
	}
	if (obj.title.value == false) {
		alert("กรุณากรอกชื่อกลุ่มสาระการเรียนรู้");
		obj.title.focus();
		return false;
	}
	/*if (obj.content.value == false) {
		alert("กรุณากรอกรายละเอียด");
		obj.content.focus();
		return false;
	}*/
}
</script>