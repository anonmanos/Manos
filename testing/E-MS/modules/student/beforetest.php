<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'S');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
//ตรวจสอบว่าได้ทำแบบทดสอบหลังเรียน ป้องกันการทำซ้ำๆ
ConnectDB();
$sql = "SELECT sc.beforetest FROM ".STADY." As st LEFT JOIN ".SCORE." As sc ON(st.id=sc.id) WHERE st.major_id='".$_GET['majorId']."' AND st.author_id='".$_SESSION['_id']."' AND sc.lsid='".$_GET['lessonId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
if($rs['beforetest']!=''):
	$ms = array(
		'message'=>'<strong>ไม่สามารถทำแบบทดสอบหลังเรียนได้<br/>เนื่องจากนักเรียนได้ทำแบบทดสอบหลังเรียนไปแล้ว</strong>',
		'class'=>'btn-danger',
		'yes'=>'index.php?mod=student&name=lesson&majorId='.$_GET['majorId'].'&lessonId='.$_GET['lessonId'],
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
$sql = "SELECT M.name,L.chapter,L.title,L.content FROM ".MAJOR." As M INNER JOIN ".LESS." As L ON(M.id=L.mid) WHERE L.id='".$_GET['lessonId']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
?>
  <li>
    <a href="index.php?mod=student&name=major&majorId=<?php echo $_GET['majorId'];?>"><?php echo $rs['name'];?></a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">บทที่&nbsp;<?php echo $rs['chapter'].'&nbsp;'.$rs['title'];?></a>
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
<form class="well" method="post" action="index.php?mod=student&name=beforetest&act=insert&majorId=<?php echo $_GET['majorId'];?>&lessonId=<?php echo $_GET['lessonId'];?>" name="saciw">
<?php
ConnectDB();
$sql = "SELECT chapter,title FROM ".LESS." WHERE id='".$_GET['lessonId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
?>
<label id="title">บทที่&nbsp;<?php echo $rs['chapter'].'&nbsp;'.$rs['title'];?></label>
<label id="title">แบบทดสอบหลังเรียน&nbsp;มีทั้งหมด&nbsp;<span id="number"><?php echo countAll(TEST,'lsid',"lsid='".$_GET['lessonId']."' AND code='B'",false);?></span>&nbsp;ข้อ</label>
<?php
ConnectDB();
$sql="SELECT id,title FROM ".TEST." WHERE lsid='".$_GET['lessonId']."' AND code='B' ORDER BY RAND()";
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
	$('#Com').html('<div id="myCom" class="modal hide fade" style="display: none;"><div class="modal-header"><a class="close" data-dismiss="modal" href="#">&times;</a><h3>ยืนยันการส่งคำตอบแบบทดสอบหลังเรียน</h3></div><div class="modal-body"><p>นักเรียนแน่ใจที่จะส่งคำตอบหรือไม่ ?<br />หากเมื่อกดปุ่มยืนยันแล้วไม่สามารถแก้ไขข้อมูลได้</p></div><div class="modal-footer"><button type="submit" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> ยืนยัน</button><a data-dismiss="modal" class="btn" href="#">ยกเลิก</a></div></div>');
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

	$sql = "SELECT st.id,CONCAT('บทที่ ',le.chapter,' ',le.title) As lesson FROM ".STADY." As st LEFT JOIN ".LESS." As le ON(st.major_id=le.mid) WHERE st.major_id='".$_GET['majorId']."' AND st.author_id='".$_SESSION['_id']."' AND le.id='".$_GET['lessonId']."' LIMIT 1";
	$query = QueryDB($sql);
	$rs = FetchDB($query);

	$sql = array(
			"beforetest"=>$ansCount,
		);
	if(UpdateDB(SCORE,$sql,"id='".$rs['id']."' AND lsid='".$_GET['lessonId']."'")){
		$ms = array(
					'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />คะแนนแบบทดสอบหลังเรียน '.$rs['lesson'].' ได้ '.$ansCount.' คะแนน</strong>',
					'class'=>'btn-success',
					'yes'=>'index.php?mod=student&name=lesson&majorId='.$_GET['majorId'].'&lessonId='.$_GET['lessonId'],
					'no'=>'#',
		);
		ShowProcess($ms);
	}
	CloseDB();

endif;
#end insert
?>