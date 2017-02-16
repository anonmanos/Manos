<?php
ConnectDB();
//Major
$sql = "SELECT chapter,title,content,create_time,update_time FROM ".LESS." WHERE id='".$_GET['id']."'";
$query = QueryDB($sql);
$rs = FetchDB($query);
CloseDB();
?>
<style type="text/css">
	label{font-weight:bold;}
</style>
<div class="modal-header">
	<a class="close" data-dismiss="modal">×</a>
	<h3>บทที่ <?php echo $rs['chapter'].' '.$rs['title'];?></h3>
	<label>สร้างเมื่อ : <?php echo ThaiTimeConvert($rs['create_time']);?>&nbsp;&nbsp;&nbsp;&nbsp;ปรับปรุงเมื่อ : <?php echo ThaiTimeConvert($rs['update_time']);?></label>
</div>
<div class="modal-body">
<!-- เนื้อหา -->
<?php echo DeCodeText($rs['content']);?>

</div>
<div class="modal-footer"></div>