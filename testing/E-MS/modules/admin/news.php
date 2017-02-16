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
    <a href="index.php?mod=admin&name=news">ข่าวสาร</a> <span class="divider">/</span>
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
List($goto,$totalpage) = SelectPage($page,$each,"",NEWS,"");
?>

<a href="index.php?mod=admin&name=news&act=add" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มข่าวสารใหม่</a>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>หัวข้อ</th>
      <th>ประกาศ</th>
      <th>ปรับปรุง</th>
      <th>โดย</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT a.id,a.title,a.create_time,a.update_time,u.fname FROM ".NEWS." As a LEFT JOIN ".USER." As u ON(a.author_id=u.id) ORDER BY a.create_time DESC LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><?php echo $rs['title'];?></td>
      <td><?php echo ThaiTimeConvert($rs['create_time']);?></td>
      <td><?php echo ThaiTimeConvert($rs['update_time']);?></td>
      <td><?php echo $rs['fname'];?></td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=admin&name=news&act=edit&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขข้อมูล</a></li>
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
				<p>คุณต้องการลบข้อมูลข่าว หัวข้อ : <u><?php echo $rs['title'];?></u>  นี้หรือไม่ ?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=admin&name=news&act=delete&id=<?php echo $rs['id'];?>">ตกลง</a>
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
<a href="index.php?mod=admin&name=news&act=edit&id=<?php echo $rs['id'];?>" class="btn btn-warning"><i class="icon-pencil icon-white"></i> แก้ไขข้อมูล</a>
		<a href="index.php?mod=admin&name=news&act=delete&id=<?php echo $rs['id'];?>" class="btn btn-danger"><i class="icon-trash icon-white"></i> ลบข้อมูล</a>
-->
<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=admin&name=news");

endif;
# end view

if($act==='add'):

?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=admin&name=news&act=insert" name="saciw" onSubmit="return formCheck()">
  <label>หัวข้อข่าว</label>
  <input type="text" name="title" class="span3" size="16" placeholder="หัวข้อข่าว">
  <label>เนื้อหา</label>
  <div class="controls">
	<textarea id="textarea" name="content" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> บันทึก</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end add

if($act==='insert'):
	ConnectDB();
	$sql ="SELECT id FROM ".NEWS." WHERE title='".$_POST['title']."'";
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
		$sql = array(
			"title"=>$_POST['title'],
			"content"=>EnCodeText($_POST['content']),
			"create_time"=>time(),
			"update_time"=>time(),
			"author_id"=>$_SESSION['_id']
		);

		if(InsertDB(NEWS,$sql)){
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=news&act=add',
				'no'=>'index.php?mod=admin&name=news',
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
$sql = "SELECT id,title,content FROM ".NEWS." WHERE id='".trim($_GET['id'])."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=admin&name=news&act=update&id=<?php echo $rs['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>หัวข้อข่าว</label>
  <input type="text" name="title" class="span3" size="16" value="<?php echo $rs['title'];?>" placeholder="หัวข้อข่าว">
  <label>เนื้อหา</label>
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
		"title"=>$_POST['title'],
		"content"=>EnCodeText($_POST['content']),
		"update_time"=>time(),
	);

	if(UpdateDB(NEWS,$sql,"id='".$_GET['id']."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=news&act=edit&id='.trim($_GET['id']),
				'no'=>'index.php?mod=admin&name=news',
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
	if(DeleteDB(NEWS,"id='".trim($_GET['id'])."'")){
		/*$ms = array(
				'message'=>' <strong>ลบข้อมูลเรียบร้อย</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=admin&name=news',
				'no'=>'',
		);
		ShowProcess($ms);*/
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=admin&name=news">';
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
	if (obj.title.value == false) {
		alert("กรุณากรอกหัวข้อข่าว");
		obj.title.focus();
		return false;
	}
	/*if (obj.content.value == false) {
		alert("กรุณากรอกเนื้อหาข่าว");
		obj.content.focus();
		return false;
	}*/
}
</script>