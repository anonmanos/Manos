<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'A');
?>
<style type="text/css">
	.thumbnail{
		text-align: center;
		font-weight: bold;
		font-size: 14px;
	}
</style>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=admin">หน้าหลักผู้ดูแลระบบ</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=admin&name=setting">จัดการระบบ</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">เมนู</a>
  </li>
</ul>
<!-- แสแสดงระบบ -->
<ul class="thumbnails">
  <li class="span2">
    <a href="index.php?mod=admin&name=admin" class="thumbnail">
      <img src="images/icon/user.gif" title="ผู้ดูแลระบบ">ผู้ดูแลระบบ
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=teacher" class="thumbnail">
      <img src="images/icon/user.gif" title="ครูผู้สอน">ครูผู้สอน
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=student" class="thumbnail">
      <img src="images/icon/user.gif" title="นักเรียน">นักเรียน
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=learning" class="thumbnail">
      <img src="images/icon/learning.gif" title="กลุ่มสาระการเรียนรู้">กลุ่มสาระการเรียนรู้
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=news" class="thumbnail">
      <img src="images/icon/news.gif" title="ข่าวสาร">ข่าวสาร
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=about" class="thumbnail">
      <img src="images/icon/forum.gif" title="หน้าเพจเกี่ยวกับเรา">หน้าเพจเกี่ยวกับเรา
    </a>
  </li>
  <li class="span2">
    <a href="index.php?mod=admin&name=log" class="thumbnail">
      <img src="images/icon/log.gif" title="ล็อกไฟล์">ล็อกไฟล์
    </a>
  </li>
</ul>