<?php
if(!empty($_GET['id'])):
?>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>คะแนนบทเรียน</h3>
	</div>
	<div class="modal-body">
<!--  -->
<table class="table table-striped table-bordered table-condensed">
  <thead>    
    <tr>
      <th>บทเรียน</th>
      <th>คะแนนสอบก่อนเรียน<br/>(จำนวนข้อสอบ / คะแนน)</th>
      <th>คะแนนสอบหลังเรียน<br/>(จำนวนข้อสอบ / คะแนน)</th>
    </tr>
  </thead>
  <tbody>
<?php
	ConnectDB();
	//LESSON
	$sql = "SELECT sc.lsid,sc.aftertest,sc.beforetest,le.chapter,le.title FROM ".SCORE." As sc INNER JOIN ".LESS." As le ON(sc.lsid=le.id) WHERE sc.id='".$_GET['id']."' ORDER BY le.chapter ASC";
	$query = QueryDB($sql);
	while($rs = FetchDB($query)):
?>
	<tr>
	  <td>บทที่&nbsp;<?php echo $rs['chapter'];?>&nbsp;<?php echo $rs['title'];?></td>
	  <td><?php echo countAll(TEST,'lsid',"lsid='".$rs['lsid']."' AND code='A'",false,false);?>&nbsp;/&nbsp;<?php echo $rs['aftertest'];?></td>
	  <td><?php echo countAll(TEST,'lsid',"lsid='".$rs['lsid']."' AND code='B'",false,false);?>&nbsp;/&nbsp;<?php echo $rs['beforetest'];?></td>
	</tr>
<?php
endwhile;

CloseDB();
?>
  </tbody>
</table>
<!--  -->
	</div>
	<div class="modal-footer"></div>
<?php
endif;
?>