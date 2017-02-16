<?php
/*Programming by. sAcIw*/

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _NUM_PAGE;

//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"",NEWS,"");

ConnectDB();
//NEWS
$sql = "SELECT N.id,N.title,N.content,N.create_time,N.update_time,N.views,CONCAT(U.pname,U.fname,' ',U.lname) As fullname FROM ".NEWS." As N LEFT JOIN ".USER." As U ON(N.author_id=U.id) ORDER BY N.update_time DESC LIMIT ".$goto.",".$each;
$query = QueryDB($sql);

while($rs = FetchDB($query)):
 ?>
<label><a data-toggle="modal" href="#myNews" id="newsEvent" class="<?php echo $rs['id'];?>"><i class="icon-leaf"></i>&nbsp;<?php echo $rs['title']?>&nbsp;@&nbsp;<?php echo ThaiTimeConvert($rs['create_time'],'','2');?></a></label>

<?php
endwhile;
CloseDB();

echo SplitPage($page,$totalpage,"index.php?mod=news");
?>

<!-- detial News -->
<div id="myNews" class="modal hide fade" style="display: none; left:40%; width:860px;"></div>
<script  type="text/javascript">
$(document).ready(function(){
	
	$('a#newsEvent').click(function(){
		id = $(this).attr('class');
		$.get(
			'json.php',
			{mod:'news',name:'get_data',id:id},
			function(data){
				$('#myNews').html(data);
			},
			'html'
		);		
 
	});
});
</script>