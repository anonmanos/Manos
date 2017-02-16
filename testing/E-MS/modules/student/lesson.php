<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'S');

//ตรวจสอบว่าได้ทำแบบทดสอบก่อนเรียนรึยัง
ConnectDB();
$sql = "SELECT sc.aftertest FROM ".STADY." As st INNER JOIN ".SCORE." As sc ON(st.id=sc.id) WHERE st.major_id='".$_GET['majorId']."' AND st.author_id='".$_SESSION['_id']."' AND sc.lsid='".$_GET['lessonId']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
if($rs['aftertest']==''){
	$ms = array(
			'message'=>'<strong>นักเรียนยังไม่ได้ทำแบบทดสอบก่อนเรียน<br />ต้องการทำแบบทดสอบก่อนเรียนหรือไม่ ?</strong>',
			'class'=>'btn-warning',
			'yes'=>'index.php?mod=student&name=aftertest&majorId='.$_GET['majorId'].'&lessonId='.$_GET['lessonId'],
			'no'=>'',
	);
	ShowProcess($ms);
exit();
}
CloseDB();
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
<style type="text/css">
	label#title{
		font-weight:bold;
		text-align:center;
	}
	div#title{
		font-weight:bold;
		text-align:right;
	}
</style>
<div id="title">
  <select onchange="location.href='index.php?mod=student&name=lesson&majorId=<?php echo $_GET['majorId'];?>&lessonId='+this.value;">
	<?php
	ConnectDB();
	$sql="SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['majorId']."'";
	$query = QueryDB($sql);
	while($les = FetchDB($query)):
	?>
	<option value="<?php echo $les['id'];?>" <?php echo Correct($les['id'],$_GET['lessonId'],'s');?>>บทที่ <?php echo $les['chapter'].' '.$les['title'];?></option>
	<?php
	endwhile;
	CloseDB();
	?>
  </select>
</div>
<!-- แสดงเนื้อหา -->
<label id="title">บทที่&nbsp;<?php echo $rs['chapter'].'&nbsp;'.$rs['title'];?></label>
<?php echo DeCodeText($rs['content']);?>

<?php
//ตรวจสอบว่าได้ทำแบบทดสอบหลังเรียนรึยัง ถ้าทำแล้วจะไม่แสดงปุ่ม
ConnectDB();
$sql = "SELECT sc.beforetest FROM ".STADY." As st INNER JOIN ".SCORE." As sc ON(st.id=sc.id) WHERE st.major_id='".$_GET['majorId']."' AND st.author_id='".$_SESSION['_id']."' AND sc.lsid='".$_GET['lessonId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();

if($rs['beforetest']==''):
?>
<div id="title">
<script> 
<!-- 
var milisec=0;
var seconds=0;
function display(){ 
	if (milisec>=9){ 
		milisec=0 
		seconds+=1 
	}else 
		milisec+=1
	//ครบ 5 นาที จะแสดงปุ่ม	
	if(seconds==10){
		$('span#tip').remove();
		$('#btnBefore').attr('style','display: show;');
	}
	$('label#time').text('เวลา : '+seconds+"."+milisec+' วิ.');
	setTimeout("display()",100) 
} 
display(); 
//--> 
</script>
<span id="tip" style="color:red;">นักเรียนต้องเรียนในบทเรียนนี้ให้ได้ 5 นาที<br/>เมื่อถึงเวลาจะแสดงปุ่มทำแบบทดสอบหลังเรียนให้นักเรียนเห็น</span>
<label id="time"></label>
<a class="btn btn-info" id="btnBefore" style="display: none;" href="index.php?mod=student&name=beforetest&majorId=<?php echo $_GET['majorId'];?>&lessonId=<?php echo $_GET['lessonId'];?>"><i class="icon-plus-sign icon-white"></i> แบบทดสอบหลังเรียน</a>
</div>
<?php
endif;
?>