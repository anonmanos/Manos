<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'S');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
//ตรวจสอบว่าได้ทำแบบทดสอบปิดรายวิชา ป้องกันการทำซ้ำๆ
ConnectDB();
$sql = "SELECT final FROM ".STADY." WHERE id='".$_GET['stadyId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
if($rs['final']!=''):
	$ms = array(
		'message'=>'<strong>ไม่สามารถทำแบบทดสอบปิดรายวิชาได้<br/>เนื่องจากนักเรียนได้ทำแบบทดสอบปิดรายวิชาไปแล้ว</strong>',
		'class'=>'btn-danger',
		'yes'=>'index.php?mod=student&name=major&majorId='.$_GET['majorId'],
		'no'=>'#',
	);
	ShowProcess($ms);
endif;
?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=student"> หน้าหลักนักเรียน</a> <span class="divider">/</span>
  </li>
  <li>
<?php
ConnectDB();
//Major
$sql = "SELECT name,final FROM ".MAJOR." WHERE id='".$_GET['majorId']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
$major = $rs['name'];
CloseDB();
?>
  <li>
    <a href="index.php?mod=student&name=major&majorId=<?php echo $_GET['majorId'];?>"><?php echo $major;?></a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">แบบทดสอบปิดรายวิชา</a>
  </li>
</ul>
<?php
 if($act==='view'):
?>
<style type="text/css">
	label#title{
		font-weight:bold;
		text-align:center;
	}
	#number{
		font-weight:bold;
		color: red;
	}
	div#title{
		font-weight:bold;
		text-align:right;
	}
</style>
<form class="well" method="post" action="index.php?mod=student&name=final&act=insert&majorId=<?php echo $_GET['majorId'];?>&stadyId=<?php echo $_GET['stadyId'];?>" name="saciw">
<?php 
// จำนวนข้อสอบ
$acoutFinal = $rs['final']*countAll(LESS,'mid',"mid='".$_GET['majorId']."'",false);?>
<label id="title">แบบทดสอบปิดรายวิชา&nbsp;มีทั้งหมด&nbsp;<span id="number"><?php echo $acoutFinal;?></span>&nbsp;ข้อ</label>
<?php
ConnectDB();
$sql="SELECT te.id,te.title FROM ".TEST." As te INNER JOIN ".LESS." As le ON(te.lsid=le.id) WHERE le.mid='".$_GET['majorId']."' AND te.code='B' ORDER BY RAND() LIMIT ".$acoutFinal;
$query = QueryDB($sql);
$i = 1;
$radio = array();
while($ts = FetchDB($query)):
  ?>
  
	<?php echo $i;?>
		<?php echo DeCodeText($ts['title']);?>
		<input type="hidden" name="testId[]" value="<?php echo $ts['id'];?>">
		<?php
			$sql="SELECT sort,name FROM ".TEST_CH." WHERE testid='".$ts['id']."' ORDER BY sort ASC";
			$query_ch = QueryDB($sql);
			while($ch = FetchDB($query_ch)):
				$rd = 'ans['.$ts['id'].']';
				if(@!in_array($rd,$radio))
					$radio[] = $rd ;
		?>
			  <label class="radio"><input type="radio"  name="ans[<?php echo $ts['id'];?>]" value="<?php echo $ch['sort'];?>">(<?php echo $ch['sort'];?>)&nbsp;<?php echo $ch['name'];?></label>
		<?php
			endwhile;
		?>
	<hr style="margin:1px;">
<?php
	$i++;
endwhile;

CloseDB();
?>
<a data-toggle="modal" class="btn btn-primary" onClick="return validation()" href="#myCom"><i class="icon-plus-sign icon-white"></i> ตกลง</a>
<label id="Com"></label>
</form>

<script language="Javascript" type="text/javascript">

function validation() {
	var radio = <?php echo json_encode($radio);?>;
	var n = radio.length;
	for(i=0;i<=n;i++){
		if(radio[i]){
			//alert(radio[i]);
			if($('input[name="'+radio[i]+'"]:checked').length <= 0){
				$('input[name="'+radio[i]+'"]').focus();				
				alert('กรุณาเลือกคำตอบให้ครบด้วย');
				return false;
			}
		}
	}
	$('#Com').html('<div id="myCom" class="modal hide fade" style="display: none;"><div class="modal-header"><a class="close" data-dismiss="modal" href="#">&times;</a><h3>ยืนยันการส่งคำตอบแบบทดสอบปิดรายวิชา</h3></div><div class="modal-body"><p>นักเรียนแน่ใจที่จะส่งคำตอบหรือไม่ ?<br />หากเมื่อกดปุ่มยืนยันแล้วไม่สามารถแก้ไขข้อมูลได้</p></div><div class="modal-footer"><button type="submit" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> ยืนยัน</button><a data-dismiss="modal" class="btn" href="#">ยกเลิก</a></div></div>');
}
</script>
<?php
endif;
# end view

if($act==='insert'):
	ConnectDB();
	$ansCount = 0;
	foreach($_POST['testId'] As $id){
		$sql = "SELECT answer FROM ".TEST." WHERE id='".$id."' LIMIT 1";
		$query = QueryDB($sql);
		$rs = FetchDB($query);
		if($rs['answer']===$_POST['ans'][$id])
			$ansCount++;
	}

	/*$sql = "SELECT st.id,ma.name FROM ".STADY." As st LEFT JOIN ".MAJOR." As ma ON(st.major_id=ma.id) WHERE st.id='".$_GET['stadyId']."' LIMIT 1";
	$query = QueryDB($sql);
	$rs = FetchDB($query);*/

	$sql = array(
			"final"=>$ansCount,
		);
	if(UpdateDB(STADY,$sql,"id='".$_GET['stadyId']."'")){
		$ms = array(
					'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />คะแนนแบบทดสอบปิดรายวิชา '.$major.' ได้ '.$ansCount.' คะแนน</strong>',
					'class'=>'btn-success',
					'yes'=>'index.php?mod=student&name=major&majorId='.$_GET['majorId'].'&stadyId='.$_GET['stadyId'],
					'no'=>'#',
		);
		ShowProcess($ms);
	}
	CloseDB();

endif;
#end insert
?>