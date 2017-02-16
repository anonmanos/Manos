<?php
if(!empty($_GET['id'])):
	ConnectDB();
	$sql = "UPDATE ".NEWS." SET views=views+1 WHERE id='".$_GET['id']."'";
	QueryDB($sql);

	//NEWS
	$sql = "SELECT N.title,N.content,N.create_time,N.update_time,N.views,CONCAT(U.pname,U.fname,' ',U.lname) As fullname FROM ".NEWS." As N LEFT JOIN ".USER." As U ON(N.author_id=U.id) WHERE N.id='".$_GET['id']."' LIMIT 1";
	$query = QueryDB($sql);
	$rs = FetchDB($query);
?>		
<script type="text/javascript">
	$(document).ready(function(){
		set2title("<?php echo $rs['title'];?>");
	});
</script>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3><?php echo $rs['title'];?></h3>
		<hr style="margin:1px;">
		 โดย&nbsp;:&nbsp;<?php echo $rs['fullname'];?>&nbsp;&nbsp;
		เมื่อ&nbsp;:&nbsp;<?php echo ThaiTimeConvert($rs['create_time']);?>&nbsp;&nbsp;
		ปรับปรุง&nbsp;:&nbsp;<?php echo ThaiTimeConvert($rs['update_time']);?>&nbsp;&nbsp;
	</div>
	<div class="modal-body">
		<?php echo DeCodeText($rs['content']);?>
		<hr>
		จำนวนผู้ชม&nbsp;: <?php echo $rs['views'];?>
	</div>
	<div class="modal-footer"></div>

<?php
CloseDB();
endif;
?>