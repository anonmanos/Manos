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
    <a href="index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id'];?>">แบบทดสอบหลังเรียน</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#"><?php echo $ACTION[$act]; ?></a>
  </li>
</ul>
<ul class="nav nav-tabs" id="tab">
	<li><a href="index.php?mod=teacher&name=major&act=edit&id=<?php echo $_GET['id'];?>">เนื้อหา</a></li>
    <li><a href="index.php?mod=teacher&name=major/lesson&id=<?php echo $_GET['id'];?>">บทเรียน&nbsp;(<?php echo countAll(LESS,'mid',"mid='".$_GET['id']."'",false);?>)</a></li>     
    <li><a href="index.php?mod=teacher&name=major/aftertest&id=<?php echo $_GET['id'];?>">แบบทดสอบก่อนเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='B'",false);?>)</a></li>     
    <li class="active"><a href="index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id'];?>">แบบทดสอบหลังเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='B'",false);?>)</a></li>    
</ul>

<?php
 if($act==='view'):

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _TEST_PAGE;

$lesson = empty($_REQUEST['lesson'])?'':$_REQUEST['lesson'];
$lesson_sql = empty($_REQUEST['lesson'])?'':' AND l.id='.$_REQUEST['lesson'];
//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"t.id",LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)',"l.mid='".$_GET['id']."' AND t.code='B'".$lesson_sql);
?>
<a href="index.php?mod=teacher&name=major/beforetest&act=add&id=<?php echo $_GET['id'];?>" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มข้อสอบใหม่</a>
<span style="float:right;">
	<select name="lsid">
	<option value="" style="width:40px;">เลือกบทเรียน</option>
	<?php
	ConnectDB();
	
	$sql="SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['id']."'";
	$query = QueryDB($sql);
	while($rs = FetchDB($query)):
	?>
	<option value="<?php echo $rs['id'];?>"  <?php echo Correct($lesson,$rs['id'],'s');?>>บทที่ <?php echo $rs['chapter'].' '.$rs['title'];?></option>
	<?php
	endwhile;
	CloseDB();
	?>
  </select>
</span>
<table class="table table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>บทเรียน</th>
      <th>คำถาม</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT t.id,t.title,t.answer,l.chapter FROM ".LESS." As l INNER JOIN ".TEST." As t ON(l.id=t.lsid) WHERE l.mid='".$_GET['id']."' AND t.code='B' ".$lesson_sql." ORDER BY t.lsid  LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
  
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td>บทที่&nbsp;<?php echo $rs['chapter'];?></td>
      <td>
		<?php echo DeCodeText( $rs['title']);?><hr style="margin:1px;">
		<?php
			$sql="SELECT sort,name FROM ".TEST_CH." WHERE testid='".$rs['id']."' ORDER BY sort ASC";
			$query_ch = QueryDB($sql);
			while($ch = FetchDB($query_ch)):
				echo '<label>('.$ch['sort'].').&nbsp;'.(($rs['answer']===$ch['sort'])?'<u style="color:red">'.$ch['name'].'</u>' : $ch['name']).'</label>';
			endwhile;
		?>
	  </td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=teacher&name=major/beforetest&act=edit&testid=<?php echo $rs['id'];?>&id=<?php echo $_GET['id'];?>"><i class="icon-pencil"></i> แก้ไขข้อมูล</a></li>
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
				<a class="btn btn-primary" href="index.php?mod=teacher&name=major/beforetest&act=delete&testid=<?php echo $rs['id'];?>&id=<?php echo $_GET['id'];?>">ตกลง</a>
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
<script>
    $("select").change(function () {
		id = $(this).val();
		if(id!='')
			location.href='index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id']?>&lesson='+id;
		else
			location.href='index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id']?>';
    });
</script>

<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=teacher&name=major/beforetest&id=".$_GET['id'].(empty($lesson)?'':'&lesson='.$lesson));

endif;
# end view
 if($act==='add'):
 ?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major/beforetest&act=insert&id=<?php echo $_GET['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>บทเรียน</label>
  <select name="lsid">
	<option value="">เลือกบทเรียน</option>
	<?php
	ConnectDB();
	$sql="SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['id']."'";
	$query = QueryDB($sql);
	while($rs = FetchDB($query)):
	?>
	<option value="<?php echo $rs['id'];?>">บทที่ <?php echo $rs['chapter'].' '.$rs['title'];?></option>
	<?php
	endwhile;
	CloseDB();
	?>
  </select>
  <label>คำถาม</label>
  <div class="controls">
	<textarea id="title" name="title" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label>คำตอบ</label>
  <div>
	<table id="choice">
	<tr>
		<th>&nbsp;#&nbsp;</th>
		<th>ตัวเลือก</th>
	</tr>
	
	</table>
  </div>
  <div style="right:0;" class="btn-group">
	<button onclick="pChoice()" type="button" class="btn" title="เพิ่ม" ><i class="icon-plus"></i></button>
	<button onclick="mChoice()" type="button" class="btn" title="ลบ"><i class="icon-minus"></i></button>
  </div><br />
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> ตกลง</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<?php
endif;
#end add

if($act==='insert'):
	#print_r($_POST);exit();
	ConnectDB();
	$sql ="SELECT id FROM ".TEST." WHERE lsid='".$_POST['lsid']."' AND title='".$_POST['title']."' AND code='B'";
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
			"lsid"=>$_POST['lsid'],
			"title"=>EnCodeText($_POST['title']),
			"answer"=>$_POST['ans'],
			"code"=>'B',
		);
		if(InsertDB(TEST,$sql)){
			$id = mysql_insert_id();
			$choice = $_POST['choice'];
			$count = count($choice);
			for($i=0;$i<=$count;$i++):
				if(!empty($choice[$i])){
					$sql = array('testid'=>$id,'sort'=>($i+1),'name'=>$choice[$i]);
					if(InsertDB(TEST_CH,$sql));
				}
			endfor;
			$ms = array(
					'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
					'class'=>'btn-success',
					'yes'=>'index.php?mod=teacher&name=major/beforetest&act=add&id='.$_GET['id'],
					'no'=>'index.php?mod=teacher&name=major/beforetest&id='.$_GET['id'],
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
$sql = "SELECT id,lsid,title,answer FROM ".TEST." WHERE id='".$_GET['testid']."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major/beforetest&act=update&testid=<?php echo $_GET['testid'];?>&id=<?php echo $_GET['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>บทเรียน</label>
  <select name="lsid">
	<option value="">เลือกบทเรียน</option>
	<?php
	ConnectDB();
	$sql="SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['id']."'";
	$query = QueryDB($sql);
	while($gr = FetchDB($query)):
	?>
	<option value="<?php echo $gr['id'];?>" <?php echo Correct($gr['id'],$rs['lsid'],'s');?>>บทที่ <?php echo $gr['chapter'].' '.$gr['title'];?></option>
	<?php
	endwhile;
	CloseDB();
	?>
  </select>
  <label>คำถาม</label>
  <div class="controls">
	<textarea id="title" name="title" class="input-xlarge ckeditor" rows="5"><?php echo $rs['title'];?></textarea>
  </div>
  <label>คำตอบ</label>
  <div>
	<table id="choice">
	<tr>
		<th>&nbsp;#&nbsp;</th>
		<th>ตัวเลือก</th>
		<?php
			ConnectDB();
			$sql_="SELECT sort,name FROM ".TEST_CH." WHERE testid='".$rs['id']."' ORDER BY sort ASC";
			$query_ch = QueryDB($sql_);
			while($ch = FetchDB($query_ch)):
			$nChs = $ch['sort'];
			$chk = ($nChs===$rs['answer'])?'checked="'.Correct($nChs,$rs['answer'],'c').'"':'';
		?>
				<tr class="nChoice"><td><?php echo $nChs;?></td><td><label class="radio"><input type="radio" name="ans" value="<?php echo $nChs;?>" <?php echo $chk;?>><input type="text" name="choice[]" class="span3" value="<?php echo $ch['name'];?>" placeholder="ตัวเลือก"></label></td></tr>
		<?php
			endwhile;
			CloseDB();
		?>
	</tr>
	
	</table>
  </div>
  <div style="right:0;" class="btn-group">
	<button onclick="pChoice()" type="button" class="btn" title="เพิ่ม" ><i class="icon-plus"></i></button>
	<button onclick="mChoice()" type="button" class="btn" title="ลบ"><i class="icon-minus"></i></button>
  </div><br />
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
			"lsid"=>$_POST['lsid'],
			"title"=>EnCodeText($_POST['title']),
			"answer"=>$_POST['ans'],
		);		
		$testid = $_GET['testid'];
	if(UpdateDB(TEST,$sql,"id='".$testid."'")){
		
		$choice = $_POST['choice'];
		$count = count($choice);
		if(DeleteDB(TEST_CH,"testid='".$testid."'"));
		for($i=0;$i<=$count;$i++):
			if(!empty($choice[$i])){
				$sql = array('testid'=>$testid,'sort'=>($i+1),'name'=>$choice[$i]);
					if(InsertDB(TEST_CH,$sql));
			}
		endfor;
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=teacher&name=major/beforetest&act=edit&testid='.$_GET['testid'].'&id='.$_GET['id'],
				'no'=>'index.php?mod=teacher&name=major/beforetest&id='.$_GET['id'],
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
	if(DeleteDB(TEST,"id='".$_GET['testid']."'")){
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=teacher&name=major/beforetest&id='.$_GET['id'].'">';
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
var nChs= <?php echo empty($nChs)? 0 : $nChs;?>;
function pChoice(){
	$("table#choice").append('<tr class="nChoice"><td>'+parseInt(nChs+1)+'</td><td><label class="radio"><input type="radio" name="ans" value="'+parseInt(nChs+1)+'"><input type="text" name="choice[]" class="span3" placeholder="ตัวเลือก"></label></td></tr>');
	nChs++;	
}
function mChoice() {
	$("table#choice tr.nChoice:last").remove();
	nChs--;
}
<?php
if(empty($nChs)):
?>
$(function() {
	for ( var i = 0; i < 4; i++) {
		pChoice();
	}
});
<?php
endif;
?>
</script>

<script language="Javascript" type="text/javascript">
//<![CDATA[
	//defult ถ้าประกาศใน textarea id="textarea"
	CKEDITOR.replace( 'title',{	
		height 	: 400
	} );
//]]>

function formCheck() {
	
	var obj = document.saciw;
	if(obj.lsid.value == false) {
		alert("กรุณาเลือกบทเรียน");
		obj.lsid.focus();
		return false;
	}
	/*if(obj.title.value == false) {
		alert("กรุณากรอกคำถาม");
		obj.title.focus();
		return false;
	}*/
	if(validation() == false){
		return false;
	}
}
function validation() {
		var n = $('input[name="ans"]:checked').length;
		var err = "";
		if(!choiceVali()){
			err += "- ใส่ข้อความในส่วนตัวเลือก\n";
		}		
		if(n == 0){
			err += "- เลือกข้อที่ถูกต้องเพื่อเป็นคำเฉลย\n";
		}
		if(err.length == 0)
			return true;
		alert("กรุณาตรวจสอบความผิดผลาด\n"+err);
		return false;
	}
	function choiceVali() {
		var ret = true;
		$('input[name^="choice"]').each(function(i){
			if($(this).val().length == false)
				ret = false;
		});
		return ret;
	}

</script>