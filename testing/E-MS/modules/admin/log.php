<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'A');
// ค่า action = add,insert,edit,update,delete
 ?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=admin">หน้าหลักผู้ดูแลระบบ</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=admin&name=log">ล็อกไฟล์</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">แสดงล็อก</a>
  </li>
</ul>
<?php

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _NUM_PAGE;

//WHERE
$feld = empty($_GET['feld'])? '' : $_GET['feld'];
//Active Class css
function btnActive($feld,$value){
	return ($feld===$value)? 'active' : '';
}

$where1 = empty($feld)? '' : "event='".$_GET['feld']."'";
$where2 = empty($feld)? '' : "WHERE event='".$_GET['feld']."'";

//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"",LOGS,$where1);
?>
<div data-toggle="buttons-radio" class="btn-group">
	<a class="btn btn-primary <?php echo btnActive($feld,'');?>" href="index.php?mod=admin&name=log">ทั้งหมด</a>
	<a class="btn btn-primary <?php echo btnActive($feld,'LI');?>" href="index.php?mod=admin&name=log&feld=LI">เข้าสู่ระบบ</a>
	<a class="btn btn-primary <?php echo btnActive($feld,'LO');?>" href="index.php?mod=admin&name=log&feld=LO">ออกจากระบบ</a>
</div>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <tr>
      <th>#</th>
      <th>เวลา</th>
      <th>ชื่อผู้ใช้</th>
      <th>สถานะ</th>
      <th>ไอพี</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT l.uid,l.atime,l.event,l.ipaddr,u.username,CONCAT(u.pname,u.fname,' ',u.lname) As fullname FROM ".LOGS." As l INNER JOIN ".USER." As u ON(l.uid=u.id) ".$where2." ORDER BY l.atime DESC LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><?php echo ThaiTimeConvert($rs['atime'],'','2');?></td>
      <td><a id="tooltip" href="#" rel="tooltip" data-original-title="<?php echo $rs['fullname'];?>"><?php echo $rs['username'];?></a></td>
      <td><?php echo $EVENTLOG[$rs['event']];?></td>
      <td><?php echo $rs['ipaddr'];?></td>
    </tr>
<?php
	$i++;
endwhile;

CloseDB();
?>
  </tbody>
</table>
<script type="text/javascript">
$('a#tooltip').tooltip('hide');
</script>
<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=admin&name=log&feld=".$feld);
?>