<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'T');
  //print_r($_GET);
?>
<style type="text/css">
	.tips{
		text-align: center;
		font-weight: bold;
		font-size: 14px;
		color:red;
	}
</style>
<!-- แสแสดงระบบ -->
<div style="overflow:scroll;">
<?php
if(!isset($_GET['exp'])){
?>
<a class="btn btn-info" href="excel.php?mod=teacher&name=score&majorId=<?php echo $_GET['majorId']?>&education=<?php echo $_GET['education']?>&classed=<?php echo $_GET['classed']?>&room=<?php echo $_GET['room']?>&exp"><i class="icon-download-alt"></i>ส่งออก(Excel)</a>
<?php }else{ //กำหนดไม่ให้แสดงเวลาส่งออก?>
<?php
ConnectDB();
$sql = "SELECT code,name FROM ".MAJOR." WHERE id='".$_GET['majorId']."'";
$q = QueryDB($sql);
$r = FetchDB($q);
CloseDB();
?>
<h3>คะแนนสอบวิชา<?php echo $r['name'].'('.$r['code'].')'?>  ห้อง <?php echo $_GET['education']?>.<?php echo $_GET['classed']?>/<?php echo $_GET['room']?></h3>
<?php } //กำหนดให้แสดงเวลาส่งออก?>
<table class="table table-striped table-bordered table-condensed" x:str="" border="1">
  <thead>    
    <tr>
      <th rowspan="2">#</th>
      <th rowspan="2">รายชื่อ</th>
<?php
ConnectDB();
//STADY,MAJOR
$sql = "SELECT id,chapter FROM ".LESS." WHERE mid='".$_GET['majorId']."' ORDER By chapter ASC";
$query = QueryDB($sql);
$col = '';
$colNum = 0;
while($rs = FetchDB($query)):
	$col .= "<th>ก่อน(".countAll(TEST,'id',"lsid='".$rs['id']."' AND code='A'",false,false).")</th>\n<th>หลัง(".countAll(TEST,'id',"lsid='".$rs['id']."' AND code='B'",false,false).")</th>\n";
	$colNum++;
?>
	<th colspan="2">บทที่&nbsp;<?php echo $rs['chapter'];?></th>
<?php
	//$col++;
endwhile;

//ดึงจำนวนข้อสอบขอ้แต่ละบท
$sql = "SELECT final FROM ".MAJOR." WHERE id='".$_GET['majorId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
?>
	 <th rowspan="2">คะแนนปิดรายวิชา<br/>(<?php echo $rs['final']*countAll(LESS,'mid',"mid='".$_GET['majorId']."'",false,false);?>)</th>
    </tr>
	<tr>
		<?php	echo $col;?>
	</tr>
  </thead>
  <tbody>
<?php
//ConnectDB();
//STADY,MAJOR
$sql = "SELECT st.id,st.final,CONCAT(us.pname,us.fname,' ',us.lname) As fullname FROM ".STADY." As st INNER JOIN ".USER." As us ON(st.author_id=us.id) WHERE st.major_id='".$_GET['majorId']."' AND us.education='".$_GET['education']."' AND us.class='".$_GET['classed']."' AND us.room='".$_GET['room']."'";
$query = QueryDB($sql);
$j = 1;
while($rs = FetchDB($query)):
?>
	<tr>
      <td><?php echo $j;?></td>
	  <td><?php echo $rs['fullname'];?></td>
	  <?php
	  //ดึงคะแนนบทเรียน
	  $sql = "SELECT aftertest,beforetest FROM ".SCORE." WHERE id='".$rs['id']."' ORDER BY lsid ASC";
	  $que = QueryDB($sql);
	  $c = 0;
      while($ls = FetchDB($que)):
	  ?>
	  <td><?php echo ($ls['aftertest']=='' OR $ls['aftertest']==false)?'-':$ls['aftertest'];?></td>
	  <td><?php echo ($ls['beforetest']=='' OR $ls['beforetest']==false)?'-':$ls['beforetest'];?></td>
	  <?php
	    $c++;
	  endwhile;
	  while($c<$colNum){
		echo '<td>-</td>';
		echo '<td>-</td>';
		$c++;
	  }
	  ?>	  
	  <td><?php echo ($ls['final']=='' OR $ls['final']==false)?'-':$ls['final'];?></td>
	</tr>
<?php
	$j++;
endwhile;

CloseDB();
?>
  </tbody>
</table>
</div>