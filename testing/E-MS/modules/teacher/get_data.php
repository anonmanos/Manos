<?php
ConnectDB();
//Major
$sql = "SELECT id,code,name,content,prerequisite,reference,create_time,update_time,stdate,endate FROM ".MAJOR." WHERE id='".$_GET['id']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
?>
<style type="text/css">
	label{font-weight:bold;}
</style>
<div class="modal-header">
	<a class="close" data-dismiss="modal">×</a>
	<h3>รายละเอียด</h3>
	<label>สร้างเมื่อ : <?php echo ThaiTimeConvert($rs['create_time']);?>&nbsp;&nbsp;&nbsp;&nbsp;ปรับปรุงเมื่อ : <?php echo ThaiTimeConvert($rs['update_time']);?></label>
</div>
<div class="modal-body">
<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#home" data-toggle="tab">เนื้อหา</a></li>
	<li class=""><a href="#profile" data-toggle="tab">สารบัญ&nbsp;(<?php echo countAll(LESS,'mid',"mid='".$_GET['id']."'",false);?>)</a></li>
</ul>
<!-- เนื้อหา -->
<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade active in" id="home">
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
<label>ระยะเวลาในการเรียนการสอน</label>
<?php echo ThaiTimeConvert($rs['stdate']);?>
&nbsp;-&nbsp;
<?php echo ThaiTimeConvert($rs['endate']);?>
<label>ชั้นเรียนที่การเรียนการสอน</label>
<?php
ConnectDB();
$sql = "SELECT CONCAT(education,'.',class,'/',room) As fullroom FROM ".MAROOM." WHERE id='".$_GET['id']."'";
$qm = QueryDB($sql);
while($rm = FetchDB($qm)){
?>
	<span><?php echo $rm['fullroom'];?></span>,
<?php
}
CloseDB();
?>
	</div>
<!-- 
สารบัญ
-->
	<div class="tab-pane fade" id="profile">
	<?php
ConnectDB();
//Lesson
$sql = "SELECT id,chapter,title FROM ".LESS." WHERE mid='".$_GET['id']."' ORDER BY chapter ASC";
$query = QueryDB($sql);
while($rs = FetchDB($query)):
?>
<label>บทที่&nbsp;<?php echo $rs['chapter'];?>&nbsp;<?php echo $rs['title'];?></label>
<?php
endwhile;
CloseDB();
?>
	</div>
</div>
</div>
<div class="modal-footer"></div>