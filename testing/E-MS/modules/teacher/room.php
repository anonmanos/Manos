<?php
/*Programming by. sAcIw*/
  EventLogin($_SESSION,'T');
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
    <a href="index.php?mod=teacher">หน้าหลักครูผู้สอน</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=teacher&name=room&majorId=<?php echo $_GET['majorId'];?>">รายงานคะแนน</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#">รายงาน</a>
  </li>
</ul>
<!-- แสแสดงระบบ -->
<?php
//MAROOM
ConnectDB();
$sql = "SELECT code,name FROM ".MAJOR." WHERE id='".$_GET['majorId']."' LIMIT 1";
$query = QueryDB($sql);
$rs = FetchDB($query);
?>
<h3><?php echo $rs['code'].'.'.$rs['name'];?></h3>
<ul id="myTab" class="nav nav-tabs">
<?php
//MAROOM
//ConnectDB();
$sql = "SELECT education,class,room FROM ".MAROOM." WHERE id='".$_GET['majorId']."'";
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
	
?>
	<li class="<?php echo ($i==1)?'active':'';?>"><a id="list" majorId="<?php echo $_GET['majorId'];?>" href="#home" data-toggle="tab" education="<?php echo $rs['education'];?>" classed="<?php echo $rs['class'];?>" room="<?php echo $rs['room'];?>">ห้อง&nbsp;<?php echo $rs['education'].'.'.$rs['class'].'/'.$rs['room'];?></a></li>
<?php
	$i++;
endwhile;
CloseDB();
?>
</ul>
<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade active in" id="home"></div>
</div>

<script  type="text/javascript">
$(document).ready(function(){

	getData('li.active>a#list');
	$('a').click(function(){
		getData(this);
	});
function getData(idClick){
		majorId = $(idClick).attr('majorId');
		education = $(idClick).attr('education');
		classed = $(idClick).attr('classed');
		room = $(idClick).attr('room');
		$.get(
			'json.php',
			{mod:'teacher',name:'score',majorId:majorId,education:education,classed:classed,room:room},
			function(data){
				$('#home').html(data);
			},
			'html'
		);		
 
}
});
</script>