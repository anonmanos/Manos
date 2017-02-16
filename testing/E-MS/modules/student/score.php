<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'S');
?>
<style type="text/css">
	.tips{
		text-align: center;
		font-weight: bold;
		font-size: 14px;
		color:red;
	}
</style>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=student">หน้าหลักนักเรียน</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=student&name=score">รายงานคะแนน</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">รายงาน</a>
  </li>
</ul>
<!-- แสแสดงระบบ -->
<table class="table table-striped table-bordered table-condensed">
  <thead>    
    <tr>
      <th>#</th>
      <th>ชื่อวิชา</th>
      <th>คะแนนสอบปิดรายวิชา<br/>(จำนวนข้อสอบ / คะแนน)</th>
      <th>คะแนนบทเรียน</th>
    </tr>
  </thead>
  <tbody>
<?php
ConnectDB();
//STADY,MAJOR
$sql = "SELECT st.id,st.major_id,st.final as score,ma.code,ma.name,ma.final FROM ".STADY." As st INNER JOIN ".MAJOR." As ma ON(st.major_id=ma.id) WHERE st.author_id='{$_SESSION['_id']}'";
$query = QueryDB($sql);
$j = 1;
while($rs = FetchDB($query)):

?>
	<tr>
      <td><?php echo $j;?></td>
	  <td>(<?php echo $rs['code'];?>)<?php echo $rs['name'];?></td>
	  <td><?php echo $rs['final']*countAll(LESS,'mid',"mid='".$rs['major_id']."'",false,false);?>&nbsp;/&nbsp;<?php echo empty($rs['score'])?'-':$rs['score'];?></td>
	  <td><a data-toggle="modal" href="#myStady" id="stadyEvent" stadyid="<?php echo $rs['id'];?>" class="btn btn-inverse" title="ดูคะแนนบทเรียน"><i class="icon-search icon-white"></i></a></td>
	</tr>
<?php
	$j++;
endwhile;

CloseDB();
?>
  </tbody>
</table>
<span class="tips">หมายเหตุ</span>:<br/><span>วิชาไหนที่คะแนนสอบปิดรายวิชามีเครื่องหมาย - แสดงว่ายังเรียนไม่จบในวิชานั้นหรือยังไม่ได้ทดแบบทดสอบปิดรายวิชา</span>

<div id="myStady" class="modal hide fade" style="display: none; left:35%; width:1000px;"></div>
<script  type="text/javascript">
$(document).ready(function(){
	
	$('a#stadyEvent').click(function(){
		id = $(this).attr('stadyid');
		$.get(
			'json.php',
			{mod:'student',name:'get_data',id:id},
			function(data){
				$('#myStady').html(data);
			},
			'html'
		);		
 
	});
});
</script>