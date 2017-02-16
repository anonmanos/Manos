<h3>รายวิชาแต่ละกลุ่ม</h3>
<div class="accordion" id="accordion">
<?php
ConnectDB();
//LEAR
$sql = "SELECT id,title FROM ".LEAR."";
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
					$sql = "SELECT M.id,M.code,M.name,CONCAT(U.pname,U.fname,' ',U.lname) As fullname FROM ".MAJOR." As M INNER JOIN ".USER." As U ON(M.author_id=U.id) WHERE M.lid='{$rs['id']}'";
					$que_m = QueryDB($sql);
					while($rm = FetchDB($que_m)):
				  ?>
						<label><a data-toggle="modal" href="#myMajor" id="majorEvent" class="<?php echo $rm['id'];?>">(<?php echo $rm['code'];?>)&nbsp;<?php echo $rm['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;ผู้สอน.&nbsp<?php echo $rm['fullname'];?></a></label>
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

<!-- detial News -->
<div id="myMajor" class="modal hide fade" style="display: none; left:35%; width:1000px;"></div>
<script  type="text/javascript">
$(document).ready(function(){
	
	$('a#majorEvent').click(function(){
		id = $(this).attr('class');
		$.get(
			'json.php',
			{mod:'course',name:'get_data',id:id},
			function(data){
				$('#myMajor').html(data);
			},
			'html'
		);		
 
	});
});
</script>
