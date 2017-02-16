<h4><i class="icon-th"></i>ข่าวสาร</h4>
<hr style="margin:1.5px;">
<?php
ConnectDB();
//NEWS
$sql = "SELECT N.id,N.title,N.content,N.create_time,N.update_time,N.views,CONCAT(U.pname,U.fname,' ',U.lname) As fullname FROM ".NEWS." As N LEFT JOIN ".USER." As U ON(N.author_id=U.id) ORDER BY N.update_time DESC LIMIT 7";
$query = QueryDB($sql);
#$i = 1;
while($rs = FetchDB($query)):
?>
<label><a data-toggle="modal" href="#myNews" id="newsEvent" class="<?php echo $rs['id'];?>"><i class="icon-leaf"></i>&nbsp;<?php echo $rs['title']?></a>&nbsp;<?php echo iconNews($rs['create_time'],$rs['update_time']);?></label>

<?php
endwhile;
CloseDB();
?>
<!-- END NEWS -->
<!-- detial News -->
<div id="myNews" class="modal hide fade" style="display: none; left:35%; width:1000px;"></div>
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