<?php
$act = empty($_GET['act'])? 'view' : $_GET['act'];

if($act==='view'):
?>
<script type="text/javascript">
function showcomment(){
	comment1.style.display = 'none';
	comment2.style.display = '';
}
function closecomment(){
	comment1.style.display = '';
	comment2.style.display = 'none';
}
function showemotion() {
	emotion1.style.display = 'none';
	emotion2.style.display = '';
}
function closeemotion() {
	emotion1.style.display = '';
	emotion2.style.display = 'none';
}

function emoticon(theSmilie) {

	document.form2.content.value += ' ' + theSmilie + ' ';
	document.form2.content.focus();
}
</script>


<a href="index.php"><img src="images/icon24/Home.png" width="15" height="15" >หน้าหลัก</a>&nbsp;<img src="images/sep.jpg" width="2" height="15">&nbsp;<a href="index.php?mod=webboard"><img src="images/icon/icon_folder.gif" >หน้าเว็บบอร์ด</a>
<?php
#--------------------------------------------------------
ConnectDB();
// เพิ่มการเข้าชม
$update_page="UPDATE ".WEBBOARD." SET views=views+1 WHERE id='".$_GET['id']."' ";
QueryDB($update_page);


	$db_query=QueryDB("SELECT b.id,b.title,b.content,b.author_id,b.create_time,b.update_time,b.views,u.username As name,u.icon FROM ".WEBBOARD." As b INNER JOIN ".USER." As u ON(b.author_id=u.id) WHERE b.id='".$_GET['id']."' LIMIT 1");
	$result = FetchDB($db_query);

?>
<table class="well" style="width:100%">
<tr>
	<td align="center" valign="top" rowspan="2">
	<img src="images/avatar/<?php echo $result['icon'];?>"/>
	<br/>
	<strong><?php echo $result['name'];?></strong>
	<br/>
	<?php
	//เจ้าของกระทู้สามารถแก้ไขได้
	if(!empty($_SESSION['_id']) AND $_SESSION['_id']===$result['author_id']):
	?>
	<a href="index.php?mod=webboard&name=post&act=edit&id=<?php echo $result['id'];?>" title="แก้ไขกระทู้"><i class="icon-edit"></i></a>
	<?php
	endif;
	?>
	<?php
	//ผู้ดูแลระบบที่สามารถลบกระทู้ได้
	if(!empty($_SESSION['_level']) AND $_SESSION['_level']==='A'):
	?>
	<a data-toggle="modal" href="#delete_post" title="ลบกระทู้"><i class="icon-share"></i></a>
	<!-- box alert -->
		<div id="delete_post" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการลบข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการลบกระทู้ หัวข้อ : <u><?php echo $result['title'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=webboard&name=post&act=delete&id=<?php echo $_GET['id'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
	<?php
	endif;
	?>
	</td>
	<td style="border-bottom:2px dotted #000;">
	<strong><?php echo $title=$result['title'];?></strong>
		<label></label>
		<strong>เมื่อ : </strong><?php echo  ThaiTimeConvert($result['create_time'],"1","1");?>
	</td >
</tr>
<tr>
	<td>
	<?php 
	include('includes/function.board.php');
	echo (CHANGE_EMOTICON(BBCODE($result['content'])));
	?>
	</td>
</tr>
</table>

<?php

	// กำหนดส่วนที่ 1
	$page=empty($_GET['page'])?1:$_GET['page'];
	$each=_NUM_PAGE;
// กำหนดส่วนที่ 2 แสดงข้อความคอมเมน

	List($goto,$page_total) = SelectPage($page,$each,"",COMMENT,"topicid='".$_GET['id']."'");
	ConnectDB();
	$sql = "SELECT b.id,b.topicid,b.title,b.content,b.create_time,b.update_time,b.author_id,u.username As name,u.icon FROM ".COMMENT." As b INNER JOIN ".USER." As u ON(b.author_id=u.id) WHERE b.topicid='".$_GET['id']."' ORDER BY b.id ASC LIMIT ".$goto.",".$each;
	$query=QueryDB($sql);
	$num_rows= RowsDB($query);

//if($num_rows>0){ 
	$i=1;
	while($rs = FetchDB($query)){
		$id=$rs['id'];
		$topicid=$rs['topicid'];
		$idmember=$rs['author_id'];
		$topic=$rs['title'];
		$content=$rs['content'];
		$name=$rs['name'];
		$date=$rs['create_time'];
  ?>
<table class="well" style="width:100%">
<tr>
	<td align="center" valign="top" rowspan="2">
	<img src="images/avatar/<?php echo $rs['icon'];?>"/>
	<br/>
	<strong><?php echo $name;?></strong>
	<br/>	
	<?php
	//ผู้ดูแลระบบที่สามารถลบกระทู้ได้
	if(!empty($_SESSION['_id']) AND $_SESSION['_id']===$idmember):
	?>
	<a href="index.php?mod=webboard&name=read&act=edit&topicid=<?php echo $id;?>&id=<?php echo $_GET['id']?>" title="แก้ไขคอมเม้น"><i class="icon-edit"></i></a>
	<?php
	endif;
	?>
	<?php
	//ผู้ดูแลระบบที่สามารถลบกระทู้ได้
	if(!empty($_SESSION['_level']) AND $_SESSION['_level']==='A'):
	?>
	<a data-toggle="modal" href="#delete_<?php echo $i;?>" title="ลบกระทู้"><i class="icon-share"></i></a>
	<!-- box alert -->
		<div id="delete_<?php echo $i;?>" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการลบข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการลบคอมเม้นที่ <?php echo ($i + (($each * $page) - $each));?> หัวข้อ : <u><?php echo $rs['title'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=webboard&name=read&act=delete&topicid=<?php echo $id.'&id='.$_GET['id'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
	<?php
	endif;
	?>
	</td>
	<td style="border-bottom:2px dotted #000;">
	<strong><?php echo $topic;?></strong>
		<label></label>
		<strong>ตอบ #<?php echo ($i + (($each * $page) - $each));?> : </strong><?php echo  ThaiTimeConvert($date,"1","1");?>
	</td >
</tr>
<tr>
	<td>
	<?php 
	//include('includes/function.board.php');
	echo (CHANGE_EMOTICON(BBCODE($content)));
	?>
	</td>
</tr>
</table>
<?php
	 $i++;
	} // close loop while
//} //close if comment
//CloseDB();

CLoseDB();

//ตอบกระทู้ต้องเป็นสมาชิก
if(!empty($_SESSION['_ip'])):
?>
<a href="javascript:showcomment();" id="comment1"><b>ตอบกระทู้</b></a>
<div id="comment2" style="display:none;">
<a href="javascript:closecomment();"><b>ปิดกระทู้</b></a>
<form name="form2" method="post" action="index.php?mod=webboard&name=read&act=comment&id=<?php echo $_GET['id']?>" enctype="multipart/form-data"  onSubmit="return formCheck();">
<table class="webboaedread">
<tr>
	<td align="right">Re&nbsp;หัวข้อ&nbsp;:</td>
	<td><input type="text" name="title" style="width:300px;height:20px;" value="Re:<?php echo $title;?>"></td>
</tr>
<tr>
	<td align="right" valign="top">ไอคอน&nbsp;:</td>
	<td>
<div id="emotion1">
	<a href="javascript:showemotion();">ใช้ไอคอน</a><br>
</div>
<div id="emotion2" style="display: none;">
<a href="javascript:emoticon(':emo1:');"><img src="images/emotion/angel_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo2:');"><img src="images/emotion/angry_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo3:');"><img src="images/emotion/broken_heart.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo4:');"><img src="images/emotion/cake.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo5:');"><img src="images/emotion/confused_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo6:');"><img src="images/emotion/cry_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo7:');"><img src="images/emotion/devil_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo8:');"><img src="images/emotion/embaressed_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo9:');"><img src="images/emotion/envelope.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo10:');"><img src="images/emotion/heart.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo11:');"><img src="images/emotion/kiss.gif" ></a>&nbsp; <br>
<a href="javascript:emoticon(':emo12:');"><img src="images/emotion/lightbulb.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo13:');"><img src="images/emotion/omg_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo14:');"><img src="images/emotion/regular_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo15:');"><img src="images/emotion/sad_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo16:');"><img src="images/emotion/shades_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo17:');"><img src="images/emotion/teeth_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo18:');"><img src="images/emotion/thumbs_down.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo19:');"><img src="images/emotion/thumbs_up.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo20:');"><img src="images/emotion/tounge_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo21:');"><img src="images/emotion/whatchutalkingabout_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo22:');"><img src="images/emotion/wink_smile.gif" ></a>&nbsp;<BR>
<a href="javascript:emoticon(':emo23:');"><img src="images/emotion2/001.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo24:');"><img src="images/emotion2/002.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo25:');"><img src="images/emotion2/003.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo26:');"><img src="images/emotion2/004.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo27:');"><img src="images/emotion2/005.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo28:');"><img src="images/emotion2/006.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo29:');"><img src="images/emotion2/007.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo30:');"><img src="images/emotion2/008.gif" ></a>&nbsp; 
<a href="javascript:emoticon('::emo31:');"><img src="images/emotion2/009.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo32:');"><img src="images/emotion2/010.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo33:');"><img src="images/emotion2/011.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo34:');"><img src="images/emotion2/012.gif" ></a>&nbsp; <BR>
<a href="javascript:emoticon(':emo35:');"><img src="images/emotion2/013.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo36:');"><img src="images/emotion2/014.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo37:');"><img src="images/emotion2/015.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo38:');"><img src="images/emotion2/016.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo39:');"><img src="images/emotion2/017.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo40:');"><img src="images/emotion2/018.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo41:');"><img src="images/emotion2/019.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo42:');"><img src="images/emotion2/020.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo43:');"><img src="images/emotion2/021.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo44:');"><img src="images/emotion2/022.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo45:');"><img src="images/emotion2/023.gif" ></a>&nbsp; <BR>
<a href="javascript:emoticon(':emo46:');"><img src="images/emotion2/024.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo47:');"><img src="images/emotion2/025.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo48:');"><img src="images/emotion2/026.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo49:');"><img src="images/emotion2/027.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo50:');"><img src="images/emotion2/028.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo51:');"><img src="images/emotion2/029.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo52:');"><img src="images/emotion2/030.gif" ></a>&nbsp; 
&nbsp;&nbsp;&nbsp;<a href="javascript:closeemotion();">ปิด</a>
</div>

<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดง','http://'); 
	if(temp) setsmile('[img]'+temp+'[/img]');
}

function setBold()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}
function setLeft()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดซ้าย',''); 
	if(temp) setsmile('[left]'+temp+'[/left]');
}
function setCenter()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดกลาง',''); 
	if(temp) setsmile('[center]'+temp+'[/center]');
}
function setRight()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดขวา',''); 
	if(temp) setsmile('[right]'+temp+'[/right]');
}
function setsup()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวยก',''); 
	if(temp) setsmile('[sup]'+temp+'[/sup]');

}
function setsub()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวห้อย',''); 
	if(temp) setsmile('[sub]'+temp+'[/sub]');
}
function setglow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเรืองแสง',''); 
	if(temp) setsmile('[glow]'+temp+'[/glow]');
}
function setshadow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวอักษรมีเงา',''); 
	if(temp) setsmile('[shadow]'+temp+'[/shadow]');
}
function setItalic()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}
function setWinamp()
{
	var temp = window.prompt('ใส่ URL ของไฟล์เพลงที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[media]'+temp+'[/media]');
}
function setVideo()
{
	var temp = window.prompt('ใส่ URL ของไฟล์วีดีโอคลิปที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[movie]'+temp+'[/movie]');
}
function setlink()
{
	var temp = window.prompt('ใส่ URL ของเว็บไซต์ที่ต้องการทำลิงก์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}
function setEmail()
{
	var temp = window.prompt('ใส่ อีเมล์ของท่าน',''); 
	if(temp) setsmile('[email]'+temp+'[/email]');
}
function setFlash()
{
	var temp = window.prompt('ใส่ URL ของไฟล์ Flash ที่ท่านต้องการนำมาแสดง','http://'); 
	if(temp) setsmile('[flash=200,200]'+temp+'[/flash]');
}

function setsmile(what)
{
	document.form2.content.value = document.form2.elements.content.value+" "+what;
	document.form2.content.focus();
}
</script>
<a href="javascript:setsmile('[---]')"><img src="images/icon/indent.gif"  alt="ย่อหน้า"></a> 
<a href="javascript:setLeft()"><img src="images/icon/left.gif"  alt="จัดซ้าย"></a> 
<a href="javascript:setCenter()"><img src="images/icon/center.gif"  alt="จัดกลาง"></a> 
<a href="javascript:setRight()"><img src="images/icon/right.gif"  alt="จัดขวา"></a> 
<a href="javascript:setBold()"><img src="images/icon/b.gif"  alt="ตัวหนา"></a> 
<a href="javascript:setItalic()"><img src="images/icon/i.gif"  alt="ตัวเอียง"></a> 
<a href="javascript:setUnderline()"><img src="images/icon/u.gif"  alt="เส้นใต้"></a> 
<a href="javascript:setsup()"><img src="images/icon/sup.gif"  alt="ตัวยก"></a> 
<a href="javascript:setsub()"><img src="images/icon/sub.gif"  alt="ตัวห้อย"></a> 
<a href="javascript:setglow()"><img src="images/icon/glow.gif"  alt="ตัวหนังสือเรืองแสง"></a> 
<a href="javascript:setshadow()"><img src="images/icon/shadow.gif"  alt="ตัวหนังสือมีเงา"></a> 
<a href="javascript:setColor('#FF0000','แดง')"><img src="images/icon/redcolor.gif"  alt="สีแดง"></a> 
<a href="javascript:setColor('#009900','เขียว')"><img src="images/icon/greencolor.gif"  alt="สีเขียว"></a> 
<a href="javascript:setColor('#0000FF','น้ำเงิน')"><img src="images/icon/bluecolor.gif"  alt="สีน้ำเงิน"></a> 
<a href="javascript:setColor('#FF6600','ส้ม')"><img src="images/icon/orangecolor.gif"  alt="สีส้ม"></a> 
<a href="javascript:setColor('#FF00FF','ชมพู')"><img src="images/icon/pinkcolor.gif"  alt="สีชมพู"></a> 
<a href="javascript:setColor('#999999','เทา')"><img src="images/icon/graycolor.gif"  alt="สีเทา"></a>
<BR><a href="javascript:setsmile('[quote][/quote]')"><img src="images/icon/quote.gif"  alt="อ้างอิงคำพูด"></a>
<a href="javascript:setWinamp()"><img src="images/icon/winamp.gif"  alt="เพิ่มเพลง"></a> 
<a href="javascript:setVideo()"><img src="images/icon/video.gif"  alt="เพิ่มวีดีโอคลิป"></a> 
<a href="javascript:setImage()"><img src="images/icon/tree.gif"  alt="เพิ่มรูปภาพ"></a>
<a href="javascript:setFlash('')"><img src="images/icon/flash.gif"  alt="เพิ่มไฟล์ Flash"></a>
<a href="javascript:setlink()"><img src="images/icon/link.gif"  alt="เพิ่มลิงก์"></a>
<a href="javascript:setEmail()"><img src="images/icon/email.gif"  alt="เพิ่มอีเมล์"></a>
	</td>
</tr>
<tr>
	<td align="right" valign="top">รายละเอียด&nbsp;:</td>
	<td><textarea name="content" style="width:350px; height:150px;"></textarea></td>
</tr>
<tr>
	<td align="right">ชื่อของท่าน&nbsp;:</td>
	<td><input type="text" name="name" style="width:100px;height:20px;" value="<?php echo $_SESSION['_username']?>" readonly></td>
</tr>
<tr>
	<td colspan="2" align="right"><button type="submit" class="btn">[แสดงความคิดเห็น]</button>
	<input type="hidden" name="topicid" value="<?php echo $_GET['id']?>"></td>
</tr>
</table>
</form>
</div>
<?php 
endif;
//ปิดการตรวจสอบการตอบกระทู้
	
// กำหนดส่วนที่ 3
echo SplitPage($page,$page_total,"index.php?mod=webboard&name=read&id=".$_GET['id']);

?>
<br/><br/>
<a href="index.php"><img src="images/icon24/Home.png" width="15" height="15" >หน้าหลัก</a>&nbsp;<img src="images/sep.jpg" width="2" height="15">&nbsp;<a href="index.php?mod=webboard"><img src="images/icon/icon_folder.gif" >หน้าเว็บบอร์ด</a>
<?php
endif;

if($act==='comment'):
	ConnectDB();
		$sql = array(
			"title"=>$_POST['title'],
			"topicid"=>$_GET['id'],
			"content"=>EnCodeText($_POST['content']),
			"create_time"=>time(),
			"update_time"=>time(),
			"author_id"=>$_SESSION['_id']
		);

		if(InsertDB(COMMENT,$sql)){
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการทำรายการต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=webboard&name=read&id='.$_GET['id'],
				'no'=>'index.php?mod=webboard',
			);
			ShowProcess($ms);
		}else{
			$ms = array(
				'message'=>' <strong>ไม่สามารถบันทึกข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
			);
			ShowProcess($ms);
		}
	CloseDB();
endif;


if($act==='edit'):
ConnectDB();
$sql = "SELECT title,content FROM ".COMMENT." WHERE id='".$_GET['topicid']."' LIMIT 1";
$query = QueryDB($sql) ;
$rs = FetchDB($query);
CloseDB();
?>
<script type="text/javascript">
function showcomment(){
	comment1.style.display = 'none';
	comment2.style.display = '';
}
function closecomment(){
	comment1.style.display = '';
	comment2.style.display = 'none';
}
function showemotion() {
	emotion1.style.display = 'none';
	emotion2.style.display = '';
}
function closeemotion() {
	emotion1.style.display = '';
	emotion2.style.display = 'none';
}

function emoticon(theSmilie) {

	document.form2.content.value += ' ' + theSmilie + ' ';
	document.form2.content.focus();
}
</script>
<form name="form2" method="post" action="index.php?mod=webboard&name=read&act=update&topicid=<?php echo $_GET['topicid']?>&id=<?php echo $_GET['id']?>" enctype="multipart/form-data"  onSubmit="return formCheck();">
<table class="webboaedread">
<tr>
	<td align="right">Re&nbsp;หัวข้อ&nbsp;:</td>
	<td><input type="text" name="title" style="width:300px;height:20px;" value="<?php echo $rs['title'];?>"></td>
</tr>
<tr>
	<td align="right" valign="top">ไอคอน&nbsp;:</td>
	<td>
<div id="emotion1">
	<a href="javascript:showemotion();">ใช้ไอคอน</a><br>
</div>
<div id="emotion2" style="display: none;">
<a href="javascript:emoticon(':emo1:');"><img src="images/emotion/angel_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo2:');"><img src="images/emotion/angry_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo3:');"><img src="images/emotion/broken_heart.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo4:');"><img src="images/emotion/cake.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo5:');"><img src="images/emotion/confused_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo6:');"><img src="images/emotion/cry_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo7:');"><img src="images/emotion/devil_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo8:');"><img src="images/emotion/embaressed_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo9:');"><img src="images/emotion/envelope.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo10:');"><img src="images/emotion/heart.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo11:');"><img src="images/emotion/kiss.gif" ></a>&nbsp; <br>
<a href="javascript:emoticon(':emo12:');"><img src="images/emotion/lightbulb.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo13:');"><img src="images/emotion/omg_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo14:');"><img src="images/emotion/regular_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo15:');"><img src="images/emotion/sad_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo16:');"><img src="images/emotion/shades_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo17:');"><img src="images/emotion/teeth_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo18:');"><img src="images/emotion/thumbs_down.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo19:');"><img src="images/emotion/thumbs_up.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo20:');"><img src="images/emotion/tounge_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo21:');"><img src="images/emotion/whatchutalkingabout_smile.gif" ></a>&nbsp; <a href="javascript:emoticon(':emo22:');"><img src="images/emotion/wink_smile.gif" ></a>&nbsp;<BR>
<a href="javascript:emoticon(':emo23:');"><img src="images/emotion2/001.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo24:');"><img src="images/emotion2/002.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo25:');"><img src="images/emotion2/003.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo26:');"><img src="images/emotion2/004.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo27:');"><img src="images/emotion2/005.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo28:');"><img src="images/emotion2/006.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo29:');"><img src="images/emotion2/007.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo30:');"><img src="images/emotion2/008.gif" ></a>&nbsp; 
<a href="javascript:emoticon('::emo31:');"><img src="images/emotion2/009.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo32:');"><img src="images/emotion2/010.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo33:');"><img src="images/emotion2/011.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo34:');"><img src="images/emotion2/012.gif" ></a>&nbsp; <BR>
<a href="javascript:emoticon(':emo35:');"><img src="images/emotion2/013.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo36:');"><img src="images/emotion2/014.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo37:');"><img src="images/emotion2/015.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo38:');"><img src="images/emotion2/016.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo39:');"><img src="images/emotion2/017.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo40:');"><img src="images/emotion2/018.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo41:');"><img src="images/emotion2/019.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo42:');"><img src="images/emotion2/020.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo43:');"><img src="images/emotion2/021.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo44:');"><img src="images/emotion2/022.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo45:');"><img src="images/emotion2/023.gif" ></a>&nbsp; <BR>
<a href="javascript:emoticon(':emo46:');"><img src="images/emotion2/024.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo47:');"><img src="images/emotion2/025.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo48:');"><img src="images/emotion2/026.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo49:');"><img src="images/emotion2/027.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo50:');"><img src="images/emotion2/028.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo51:');"><img src="images/emotion2/029.gif" ></a>&nbsp; 
<a href="javascript:emoticon(':emo52:');"><img src="images/emotion2/030.gif" ></a>&nbsp; 
&nbsp;&nbsp;&nbsp;<a href="javascript:closeemotion();">ปิด</a>
</div>

<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดง','http://'); 
	if(temp) setsmile('[img]'+temp+'[/img]');
}

function setBold()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}
function setLeft()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดซ้าย',''); 
	if(temp) setsmile('[left]'+temp+'[/left]');
}
function setCenter()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดกลาง',''); 
	if(temp) setsmile('[center]'+temp+'[/center]');
}
function setRight()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการจัดขวา',''); 
	if(temp) setsmile('[right]'+temp+'[/right]');
}
function setsup()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวยก',''); 
	if(temp) setsmile('[sup]'+temp+'[/sup]');

}
function setsub()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวห้อย',''); 
	if(temp) setsmile('[sub]'+temp+'[/sub]');
}
function setglow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเรืองแสง',''); 
	if(temp) setsmile('[glow]'+temp+'[/glow]');
}
function setshadow()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวอักษรมีเงา',''); 
	if(temp) setsmile('[shadow]'+temp+'[/shadow]');
}
function setItalic()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}
function setWinamp()
{
	var temp = window.prompt('ใส่ URL ของไฟล์เพลงที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[media]'+temp+'[/media]');
}
function setVideo()
{
	var temp = window.prompt('ใส่ URL ของไฟล์วีดีโอคลิปที่ท่านต้องการแทรกในข้อความของท่าน','http://'); 
	if(temp) setsmile('[movie]'+temp+'[/movie]');
}
function setlink()
{
	var temp = window.prompt('ใส่ URL ของเว็บไซต์ที่ต้องการทำลิงก์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}
function setEmail()
{
	var temp = window.prompt('ใส่ อีเมล์ของท่าน',''); 
	if(temp) setsmile('[email]'+temp+'[/email]');
}
function setFlash()
{
	var temp = window.prompt('ใส่ URL ของไฟล์ Flash ที่ท่านต้องการนำมาแสดง','http://'); 
	if(temp) setsmile('[flash=200,200]'+temp+'[/flash]');
}

function setsmile(what)
{
	document.form2.content.value = document.form2.elements.content.value+" "+what;
	document.form2.content.focus();
}
</script>
<a href="javascript:setsmile('[---]')"><img src="images/icon/indent.gif"  alt="ย่อหน้า"></a> 
<a href="javascript:setLeft()"><img src="images/icon/left.gif"  alt="จัดซ้าย"></a> 
<a href="javascript:setCenter()"><img src="images/icon/center.gif"  alt="จัดกลาง"></a> 
<a href="javascript:setRight()"><img src="images/icon/right.gif"  alt="จัดขวา"></a> 
<a href="javascript:setBold()"><img src="images/icon/b.gif"  alt="ตัวหนา"></a> 
<a href="javascript:setItalic()"><img src="images/icon/i.gif"  alt="ตัวเอียง"></a> 
<a href="javascript:setUnderline()"><img src="images/icon/u.gif"  alt="เส้นใต้"></a> 
<a href="javascript:setsup()"><img src="images/icon/sup.gif"  alt="ตัวยก"></a> 
<a href="javascript:setsub()"><img src="images/icon/sub.gif"  alt="ตัวห้อย"></a> 
<a href="javascript:setglow()"><img src="images/icon/glow.gif"  alt="ตัวหนังสือเรืองแสง"></a> 
<a href="javascript:setshadow()"><img src="images/icon/shadow.gif"  alt="ตัวหนังสือมีเงา"></a> 
<a href="javascript:setColor('#FF0000','แดง')"><img src="images/icon/redcolor.gif"  alt="สีแดง"></a> 
<a href="javascript:setColor('#009900','เขียว')"><img src="images/icon/greencolor.gif"  alt="สีเขียว"></a> 
<a href="javascript:setColor('#0000FF','น้ำเงิน')"><img src="images/icon/bluecolor.gif"  alt="สีน้ำเงิน"></a> 
<a href="javascript:setColor('#FF6600','ส้ม')"><img src="images/icon/orangecolor.gif"  alt="สีส้ม"></a> 
<a href="javascript:setColor('#FF00FF','ชมพู')"><img src="images/icon/pinkcolor.gif"  alt="สีชมพู"></a> 
<a href="javascript:setColor('#999999','เทา')"><img src="images/icon/graycolor.gif"  alt="สีเทา"></a>
<BR><a href="javascript:setsmile('[quote][/quote]')"><img src="images/icon/quote.gif"  alt="อ้างอิงคำพูด"></a>
<a href="javascript:setWinamp()"><img src="images/icon/winamp.gif"  alt="เพิ่มเพลง"></a> 
<a href="javascript:setVideo()"><img src="images/icon/video.gif"  alt="เพิ่มวีดีโอคลิป"></a> 
<a href="javascript:setImage()"><img src="images/icon/tree.gif"  alt="เพิ่มรูปภาพ"></a>
<a href="javascript:setFlash('')"><img src="images/icon/flash.gif"  alt="เพิ่มไฟล์ Flash"></a>
<a href="javascript:setlink()"><img src="images/icon/link.gif"  alt="เพิ่มลิงก์"></a>
<a href="javascript:setEmail()"><img src="images/icon/email.gif"  alt="เพิ่มอีเมล์"></a>
	</td>
</tr>
<tr>
	<td align="right" valign="top">รายละเอียด&nbsp;:</td>
	<td><textarea name="content" style="width:350px; height:150px;"><?php echo $rs['content'];?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="right"><button type="submit" class="btn">[แสดงความคิดเห็น]</button>
</tr>
</table>
</form>
<?php
endif;
if($act==='update'):
	ConnectDB();
	$sql = array(
		"title"=>$_POST['title'],
		"content"=>EnCodeText($_POST['content']),
		"update_time"=>time(),
	);

	if(UpdateDB(COMMENT,$sql,"id='".$_GET['topicid']."'")){
		$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=webboard&name=read&act=edit&topicid'.$_GET['topicid'].'&id='.$_GET['id'],
				'no'=>'index.php?mod=webboard&name=read&id='.$_GET['id'],
		);
		ShowProcess($ms);
	}else{
		$ms = array(
				'message'=>' <strong>ไม่สามารถแก้ไขข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
		);
		ShowProcess($ms);
	}
	CloseDB();
endif;
# end update
if($act==='delete'):
	ConnectDB();
	if(DeleteDB(COMMENT,"id='".$_GET['topicid']."'")){
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=webboard&name=read&id='.$_GET['id'].'">';
	}else{
		$ms = array(
				'message'=>' <strong>ไม่สามารถลบข้อมูลได้<br />กรุณาตรวจสอบอีกครั้ง</strong>',
				'class'=>'btn-danger',
				'yes'=>'',
				'no'=>'',
		);
		ShowProcess($ms);
	}
	CloseDB();
endif;
#end delete
?>