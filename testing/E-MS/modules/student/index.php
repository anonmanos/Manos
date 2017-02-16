<?php
	//เช็กว่ามีการล็อกอินมามัย
	EventLogin($_SESSION,'S');
	//ใช้ในการตรวจสอบการลงทะเบียนเรียน
	$time = time();
?>
<h3>รายวิชาแต่ละกลุ่มของนักเรียน</h3>
<div class="accordion" id="accordion">
<?php
ConnectDB();
//LEAR
$sql = "SELECT l.id,l.title FROM ".LEAR." As l INNER JOIN ".MAJOR." As m ON(l.id=m.lid) INNER JOIN ".STADY." As s ON(m.id=s.major_id) WHERE s.author_id='{$_SESSION['_id']}'";
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
?>
<div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>">
                  <?php echo $rs['title'];?>&nbsp;(<?php echo countAll(MAJOR." As M INNER JOIN ".STADY." As S ON(M.id=S.major_id)",'M.lid',"M.lid='{$rs['id']}' AND S.author_id ='{$_SESSION['_id']}' AND M.status='Y'",false,false);?>)
                </a>
              </div>
              <div id="collapse_<?php echo $i;?>" class="accordion-body collapse" style="height: 0px; ">
                <div class="accordion-inner">
                  <?php
				  //MAJOR
					$sql = "SELECT M.id,M.code,M.name,CONCAT(U.pname,U.fname,' ',U.lname) As fullname,M.stdate,M.endate FROM ".MAJOR." As M INNER JOIN ".USER." As U ON(M.author_id=U.id) INNER JOIN ".STADY." As S ON(M.id=S.major_id) WHERE M.lid='{$rs['id']}' AND S.author_id='{$_SESSION['_id']}' AND M.status='Y'";
					$que_m = QueryDB($sql);
					$j = 1;

					while($rm = FetchDB($que_m)):
						if((strtotime($rm['stdate'])<=time()) AND strtotime($rm['endate'])>=$time):
				  ?>
						<a href="index.php?mod=student&name=major&majorId=<?php echo $rm['id']?>">
						<label><?php echo $j;?>. (<?php echo $rm['code'];?>)&nbsp;<?php echo $rm['name'];?>&nbsp;(<?php echo countAll(LESS,"","mid='{$rm['id']}'",false,false);?>)&nbsp;&nbsp;&nbsp;&nbsp;ผู้สอน.&nbsp<?php echo $rm['fullname'];?></label>
						</a>
				  <?php
						else:
				  ?>
						<label><?php echo $j;?>. (<?php echo $rm['code'];?>)&nbsp;<?php echo $rm['name'];?>&nbsp;(<?php echo countAll(LESS,"","mid='{$rm['id']}'",false,false);?>)&nbsp;&nbsp;&nbsp;&nbsp;ผู้สอน.&nbsp<?php echo $rm['fullname'];?></label>
				  <?php
						endif;
						$j++;
					endwhile;
					unset($j);
				  ?>
                </div>
              </div>
            </div>
<?php
	$i++;
endwhile;
CloseDB();
?>	
</div>
<!-- <pre class="prettyprint linenums">
<ol class="linenums">
<li class="L0"></li>
<li class="L1"></li>
<li class="L2"></li>
<li class="L3"></li>
<li class="L4"></li>
</ol></pre> -->