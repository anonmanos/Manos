<?php
	//เช็กว่ามีการล็อกอินมามัย
	EventLogin($_SESSION,'T');
?>
<h3>รายงานผลการเรียนการสอน</h3>
<div class="accordion" id="accordion">
<?php
ConnectDB();
//LEAR
$sql = "SELECT L.id,L.title FROM ".LEAR." As L INNER JOIN ".MAJOR." As M ON(L.id=M.lid) WHERE M.author_id='{$_SESSION['_id']}' GROUP BY M.lid";
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
?>
<div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>">
                  <?php echo $rs['title'];?>&nbsp;(<?php echo countAll(MAJOR,'lid',"lid='{$rs['id']}'",false,false);?>)
                </a>
              </div>
              <div id="collapse_<?php echo $i;?>" class="accordion-body collapse" style="height: 0px; ">
                <div class="accordion-inner">
                  <?php
				  //MAJOR
					$sql = "SELECT id,code,name FROM ".MAJOR." WHERE lid='{$rs['id']}' AND author_id='{$_SESSION['_id']}'";
					$que_m = QueryDB($sql);
					while($rm = FetchDB($que_m)):
				  ?>
						<label><a href="index.php?mod=teacher&name=room&majorId=<?php echo $rm['id'];?>">(<?php echo $rm['code'];?>)&nbsp;<?php echo $rm['name'];?></a></label>
				  <?php
					endwhile;
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























<!-- <div class="input-prepend">
	<span class="add-on"><i class="icon-envelope"></i></span>
	<input type="text" id="inputIcon" class="span2">
</div> 

<div class="span4">
      <div style="margin-bottom: 9px" class="btn-toolbar">
        <!-- <div class="btn-group">
          <a href="#" class="btn"><i class="icon-align-left"></i></a>
          <a href="#" class="btn"><i class="icon-align-center"></i></a>
          <a href="#" class="btn"><i class="icon-align-right"></i></a>
          <a href="#" class="btn"><i class="icon-align-justify"></i></a>
      </div>
		<div class="btn-group">
          <a href="#" class="btn btn-primary"><i class="icon-user icon-white"></i> User</a>
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
            <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
            <li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="i"></i> Make admin</a></li>
          </ul>
        </div>
      </div>
      <p>
        <a href="#" class="btn"><i class="icon-refresh"></i> Refresh</a>
        <a href="#" class="btn btn-success"><i class="icon-shopping-cart icon-white"></i> Checkout</a>
        <a href="#" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</a>
      </p>
      <p>
        <a href="#" class="btn btn-large"><i class="icon-comment"></i> Comment</a>
        <a href="#" class="btn btn-small"><i class="icon-cog"></i> Settings</a>
        <a href="#" class="btn btn-small btn-info"><i class="icon-info-sign icon-white"></i> More Info</a>
      </p>
</div> -->