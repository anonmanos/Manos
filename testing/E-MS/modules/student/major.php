<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'S');

  if(isset($_GET['act']) AND $_GET['act']==='active'):
	//ลงทะเบียนเรียน
	ConnectDB();
	$sql ="SELECT id FROM ".STADY." WHERE major_id='".$_GET['majorId']."' AND author_id='".$_SESSION['_id']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>มีการลงทะเบียนแล้ว กรุณาตรวจสอบข้อมูลอีกครั้ง</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{		
		$sql = array(
			"major_id"=>$_GET['majorId'],
			"author_id"=>$_SESSION['_id'],
		);

		if(InsertDB(STADY,$sql)){
			$ms = array(
				'message'=>' <strong>ลงทะเบียนเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=student&name=major&majorId='.$_GET['majorId'].'#profile',
				'no'=>'index.php?mod=student&name=major&majorId='.$_GET['majorId'],
			);
			ShowProcess($ms);
		}else{
			$ms = array(
				'message'=>' <strong>ไม่สามารถลงทะเบียนได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
			);
			ShowProcess($ms);
		}
	}// CLOSE IF NUM_ROWS
	CloseDB();
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
$sql = "SELECT id,code,name,content,prerequisite,reference,stdate,endate,final FROM ".MAJOR." WHERE id='".$_GET['majorId']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
//CloseDB();
?>
  <li class="active">
    <a href="#"><?php echo $rs['name'];?></a>
  </li>
</ul>

<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#home" data-toggle="tab">เนื้อหา</a></li>
	<li class=""><a href="#profile" data-toggle="tab">สารบัญ&nbsp;(<?php echo countAll(LESS,'mid',"mid='".$_GET['majorId']."'",false);?>)</a></li>
</ul>
<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade active in" id="home">
		<style type="text/css">
			label{font-weight:bold;}
		</style>
		<label>รหัสวิชา</label>
		<?php echo $rs['code'];?>
		<label>ชื่อรายวิชา</label>
		<?php echo $rs['name'];?>
		<label>เนื้อหา</label>
		<?php echo DeCodeText($rs['content']);?>
		<label>วัตถุประสงค์</label>
		<?php echo DeCodeText($rs['prerequisite']);?>
		<label>เอกสารอ้างอิง</label>
		<?php echo DeCodeText($rs['reference']);?>
		<label>วันเริ่มสอนถึงวันสิ้นสุด</label>
		<?php echo ThaiTimeConvert($rs['stdate']);?>
		&nbsp;-&nbsp;
		<?php echo ThaiTimeConvert($rs['endate']);?>
		<label>แบบทดสอบปิดรายวิชา</label>
		โดยเอาบทเรียนละ <?php echo $rs['final'];?> ข้อ มีทั้งหมด <u><?php echo $final= $rs['final']*countAll(LESS,'mid',"mid='".$_GET['majorId']."'",false);?></u> ข้อ
		<label></label>
<?php
//ปุ่มลงทะเบียนเรียน
ConnectDB();
$sql ="SELECT id FROM ".STADY." WHERE major_id='".$_GET['majorId']."' AND author_id='".$_SESSION['_id']."'";
$res = QueryDB($sql) ;
$row = RowsDB($res) ;
if($row<=0){
?>
<a data-toggle="modal" href="#reGisModal" class="btn btn-primary"><i class="icon-book icon-white"></i>[ลงทะเบียน]</a>
<div id="reGisModal" class="modal hide fade" style="display: none;">
  <div class="modal-header">
    <a class="close" data-dismiss="modal" href="#">&times;</a>
    <h3>ยืนยันการลงทะเบียน</h3>
  </div>
  <div class="modal-body">
    <p>คุณ <?php echo $_SESSION['_fname'];?> ต้องการจะลงทะเบียนเรียนวิชา <?php echo $rs['name'];?> หรือไม่ ?</p>
  </div>
  <div class="modal-footer">
	<a class="btn btn-primary" href="index.php?mod=student&name=major&majorId=<?php echo $_GET['majorId'];?>&act=active">ตกลง</a>
	<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
 </div>
</div>
<?php
}
//[จบปุ่มลงทะเบียน]
?>
</div>
<!-- 
สารบัญ
-->
<div class="tab-pane fade" id="profile">
<table class="table table-striped">
	<tr>
		<th>บทเรียน</th>
		<th>แบบทดสอบก่อนเรียน</th>
		<th>แบบทดสอบหลังเรียน</th>
	</tr>
<?php
ConnectDB();
//Lesson
$lessonCount = 0;
$sql = "SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['majorId']."' ORDER BY chapter ASC";
$query = QueryDB($sql);
while($rs = FetchDB($query)):
 //$row นำมาจากการตรวจสอบปุ่มลงทะเบียนได้เช่นกัน
 if($row<=0):
?>
	<tr>
		<td>บทที่&nbsp;<?php echo $rs['chapter'];?>&nbsp;<?php echo $rs['title'];?></td>
		<td></td>
		<td></td>
	</tr>
<?php
 else:
	$sql = "SELECT st.id,sc.aftertest,sc.beforetest FROM ".SCORE." As sc INNER JOIN ".STADY." As st ON(sc.id=st.id) WHERE st.major_id='".$_GET['majorId']."' AND st.author_id='".$_SESSION['_id']."' AND sc.lsid='".$rs['id']."' LIMIT 1";
	$qu = QueryDB($sql);
	$ls = FetchDB($qu);
	$aftertest = (($ls['aftertest']=='') OR empty($ls['id']))?'remove':'ok';
	$beforetest = (($ls['beforetest']=='') OR empty($ls['id']))?'remove':'ok';
	if($aftertest=='ok' AND $beforetest=='ok')
		$lessonCount++;
?>
	<tr>
		<td><a href="index.php?mod=student&name=lesson&majorId=<?php echo $_GET['majorId'];?>&lessonId=<?php echo $rs['id'];?>">บทที่&nbsp;<?php echo $rs['chapter'];?>&nbsp;<?php echo $rs['title'];?></a></td>
		<td style="margin-left:40px;"><i class="icon-<?php echo $aftertest;?>"></i></td>
		<td style="margin-left:40px;"><i class="icon-<?php echo $beforetest;?>"></i></td>
	</tr>
<?php
 endif;
endwhile;
CloseDB();
?>
</table>
<?php
// ตรวจสอบการทำแบบทดสอบปิดรายวิชา ถ้ามีคะแนนแล้ว
ConnectDB();
$sql = "SELECT id,final FROM ".STADY." WHERE major_id='".$_GET['majorId']."' AND author_id='".$_SESSION['_id']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
//ถ้ายังไม่ได้ทำแบบทดสอบหรือมีค่าว่าง
if($rs['final']==''){
	//$lessonCounts มาจากข้างบน เพื่อมาเทียบกับจำนวนบทเรียนว่าเท่ากันมั้ยถ้าเท่ากันแสดงว่าได้ทำแบบทดสอบก่อน,หลังเสร็จแล้ว
	$lessonCounts = countAll(LESS,'mid',"mid='".$_GET['majorId']."'",false);
	if($lessonCount==$lessonCounts){
?>
<a class="btn btn-info" href="index.php?mod=student&name=final&majorId=<?php echo $_GET['majorId'];?>&stadyId=<?php echo $rs['id'];?>"><i class="icon-plus-sign icon-white"></i>แบบทดสอบปิดรายวิชา ทั้งหมด <?php echo $final;?> ข้อ) สามารถทำข้อสอบได้</a>
<?php
	}else{	
?>
<span class="btn"><i class="icon-plus-sign icon-white"></i>แบบทดสอบปิดรายวิชา  ทั้งหมด <?php echo $final;?> ข้อ) ยังไม่สามารถทำข้อสอบได้</span>
<?php
	}
}
?>
<label style="color:red;">หมายเหตุ : </label>
<span>สัญญาลักษณ์  <i class="icon-ok"></i> หมายความว่าทำแบบทดสอบแล้ว</span><br/>
<span>สัญญาลักษณ์  <i class="icon-remove"></i> หมายความว่ายังไม่ได้ทำแบบทดสอบ</span><br/>
<span style="color:red;">เมื่อทำแบบทดสอบครบทุกบทเรียนแล้ว ปุ่มแบบทดสอบปิดรายวิชา จะสามารถคลิกได้</span>
	</div>
</div>