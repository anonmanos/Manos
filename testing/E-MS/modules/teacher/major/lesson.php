
<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'T');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=teacher&name=setting">จัดการรายวิชา</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=teacher&name=major">รายวิชา</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=teacher&name=major/lesson&id=<?php echo $_GET['id'];?>">บทเรียน</a> <span class="divider">/</span>
  </li> 
  <li class="active">
    <a href="#"><?php echo $ACTION[$act]; ?></a>
  </li>
</ul>
<ul class="nav nav-tabs" id="tab">
	<li><a href="index.php?mod=teacher&name=major&act=edit&id=<?php echo $_GET['id'];?>">เนื้อหา</a></li>
    <li class="active"><a href="index.php?mod=teacher&name=major/lesson&id=<?php echo $_GET['id'];?>">บทเรียน&nbsp;(<?php echo countAll(LESS,'mid',"mid='".$_GET['id']."'",false);?>)</a></li>     
    <li><a href="index.php?mod=teacher&name=major/aftertest&id=<?php echo $_GET['id'];?>">แบบทดสอบก่อนเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='A'",false);?>)</a></li>     
    <li><a href="index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id'];?>">แบบทดสอบหลังเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='B'",false);?>)</a></li>    
</ul>
<?php
 if($act==='view'):

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _NUM_PAGE;

//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"",LESS," mid='".$_GET['id']."'");
?>
<a href="index.php?mod=teacher&name=major/lesson&act=add&id=<?php echo $_GET['id'];?>" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มบทเรียนใหม่</a>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>บทเรียน</th>
      <th>เขียน</th>
      <th>ปรับปรุง</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT a.id,a.chapter,a.title,a.create_time,a.update_time FROM ".LESS." As a WHERE a.mid='".$_GET['id']."' LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
  
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><a data-toggle="modal" href="#myLesson" id="lessonEvent" mId="<?php echo $rs['id'];?>">บทที่&nbsp;<?php echo $rs['chapter'].'&nbsp;'.$rs['title'];?></a></td>
      <td><?php echo ThaiTimeConvert($rs['create_time']);?></td>
      <td><?php echo ThaiTimeConvert($rs['update_time']);?></td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=teacher&name=major/lesson&act=edit&lid=<?php echo $rs['id'];?>&id=<?php echo $_GET['id'];?>"><i class="icon-pencil"></i> แก้ไขข้อมูล</a></li>
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
				<p>คุณต้องการลบบทเรียน หัวข้อ : <u><?php echo $rs['title'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=teacher&name=major/lesson&act=delete&lid=<?php echo $rs['id'];?>&id=<?php echo $_GET['id'];?>">ตกลง</a>
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
<div id="myLesson" class="modal hide fade" style="display: none; left:40%; width:860px;"></div>
<script  type="text/javascript">
$(document).ready(function(){
	
	$('a#lessonEvent').click(function(){
		id = $(this).attr('mId');
		$.get(
			'json.php',
			{mod:'teacher',name:'get_data_2',id:id},
			function(data){
				$('#myLesson').html(data);
			},
			'html'
		);		
 
	});
});
</script>
<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=teacher&name=major/lesson&id=".$_GET['id']);

endif;
# end view
 if($act==='add'):
 ?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major/lesson&act=insert&id=<?php echo $_GET['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>บทที่</label>
  <input type="text" name="chapter" class="span1" size="2" maxlength="2" placeholder="บทที่" onkeypress="check_number(event);">
  <label>ชื่อบทเรียน</label>
  <input type="text" name="title" class="span3" size="16" placeholder="ชื่อบทเรียน">
  <label>เนื้อหา</label>
  <div class="controls">
	<textarea id="textarea1" name="content" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label><input type="hidden" name="mid" value="<?php echo $_GET['id'];?>"></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> ตกลง</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end add

if($act==='insert'):
	ConnectDB();
	$sql ="SELECT id FROM ".LESS." WHERE mid='".$_POST['mid']."' AND chapter='".$_POST['chapter']."' OR title='".$_POST['title']."'";
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
			"mid"=>$_POST['mid'],
			"chapter"=>$_POST['chapter'],
			"title"=>$_POST['title'],
			"content"=>EnCodeText($_POST['content']),
			"create_time"=>TIMES,
			"update_time"=>TIMES,
		);

		if(InsertDB(LESS,$sql)){
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=teacher&name=major/lesson&act=add&id='.$_POST['mid'],
				'no'=>'index.php?mod=teacher&name=major/lesson&id='.$_POST['mid'],
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
$sql = "SELECT id,mid,chapter,title,content FROM ".LESS." WHERE id='".$_GET['lid']."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major/lesson&act=update&lid=<?php echo $_GET['lid'];?>&id=<?php echo $_GET['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>บทที่</label>
  <input type="text" name="chapter" class="span1" value="<?php echo $rs['chapter'];?>" size="2" maxlength="2" placeholder="บทที่" onkeypress="check_number(event);">
  <label>ชื่อบทเรียน</label>
  <input type="text" name="title" class="span3" size="16" value="<?php echo $rs['title'];?>" placeholder="ชื่อบทเรียน">
  <label>เนื้อหา</label>
  <div class="controls">
	<textarea id="textarea1" name="content" class="input-xlarge ckeditor" rows="5">
		<?php echo $rs['content'];?>
	</textarea>
  </div>
  <label></label>
  <input type="hidden" name="mid" value="<?php echo $rs['mid'];?>">
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end edit

if($act==='update'):
	ConnectDB();
	/*$sql ="SELECT id FROM ".LESS." WHERE mid='".$_POST['mid']."' AND chapter='".$_POST['chapter']."' OR title='".$_POST['title']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>ข้อมูลซ้ำกันนะ<br />กรุณาปรับเปลี่ยนข้อมูล</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{*/
		$sql = array(
			"chapter"=>$_POST['chapter'],
			"title"=>$_POST['title'],
			"content"=>EnCodeText($_POST['content']),
		);

		if(UpdateDB(LESS,$sql,"id='".$_GET['lid']."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=teacher&name=major/lesson&act=edit&lid='.$_GET['lid'].'&id='.$_GET['id'],
				'no'=>'index.php?mod=teacher&name=major/lesson&id='.$_GET['id'],
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
	//}
	CloseDB();
endif;
# end update

if($act==='delete'):
	ConnectDB();
	if(DeleteDB(LESS,"id='".$_GET['lid']."'")){
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=teacher&name=major/lesson&id='.$_GET['id'].'">';
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
	CKEDITOR.replace( 'textarea1',{	
		height 	: 400
	} );
//]]>
/*
$("#select").change(function () {
    $("#select option:selected").each(function () {
		$("input[name='code']").val($(this).attr('id'));
    });
}).change();
*/
function formCheck() {
	
	var obj = document.saciw;
	if (obj.chapter.value == false) {
		alert("กรุณากรอกหมายเลขบทด้วย");
		obj.chapter.focus();
		return false;
	}
	if (obj.title.value == false) {
		alert("กรุณากรอกชื่อบทเรียน");
		obj.title.focus();
		return false;
	}
	/*if (obj.content.value == false) {
		alert("กรุณากรอกเนื้อหา");
		obj.content.focus();
		return false;
	}*/
}

</script>