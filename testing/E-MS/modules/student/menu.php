<div class="alert alert-success">
	<strong>คุณ&nbsp;<?php echo $_SESSION['_fname'].'&nbsp;'.$_SESSION['_lname'];?>&nbsp;!</strong><br />
	<img src="images/avatar/<?php echo $_SESSION['_icon'];?>" title="<?php echo $_SESSION['_username'];?>"/>
</div>
<div style="padding: 8px 0;" class="well">
	<ul class="nav nav-list">
		<li class="active"><a href="index.php?mod=student"><i class="icon-home icon-white"></i> หน้าหลักนักเรียน</a></li>
		<li><a href="index.php?mod=student&name=score"><i class="icon-signal"></i> รายงานคะแนน</a></li>
		<li><a href="index.php?mod=student&name=profile"><i class="icon-edit"></i> ข้อมูลส่วนตัว</a></li>
		<li><a data-toggle="modal" href="#myModal"><i class="icon-off"></i> ออกจากระบบ</a></li>
	</ul>
</div>
<div id="myModal" class="modal hide fade" style="display: none;">
  <div class="modal-header">
    <a class="close" data-dismiss="modal" href="#">&times;</a>
    <h3>ยืนยันออกจากระบบ</h3>
  </div>
  <div class="modal-body">
    <p>คุณ <?php echo $_SESSION['_fname'];?> ต้องการจะออกจากระบบ หรือไม่ ?</p>
  </div>
  <div class="modal-footer">
	<a class="btn btn-primary" href="index.php?mod=logout">ตกลง</a>
	<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
 </div>
</div>
<!-- 
<pre>
_SESSION
<?php
print_r($_SESSION);
?>
</pre>

<pre>
_GET
<?php
print_r($_GET);
?>
</pre>

<pre>
_POST
<?php
print_r($_POST);
?>
</pre>
-->