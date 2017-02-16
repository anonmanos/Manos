<?php
/*Programming by. sAcIw*/
  //เช็กว่ามีการล็อกอินมามัย
  EventLogin($_SESSION,'T');
// ค่า action = add,insert,edit,update,delete
  $act = empty($_GET['act'])? 'view' : $_GET['act'];
 ?>
 <ul class="breadcrumb">
  <li>
    <a href="index.php?mod=teacher">หน้าหลักครูผู้สอน</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="index.php?mod=teacher&name=major">จัดการวิชา</a> <span class="divider">/</span>
  </li>
  <li class="active">
    <a href="#"><?php echo $ACTION[$act]; ?></a>
  </li>
</ul>
<?php

if($act==='view'):

//ส่วนที่ 1
$page = empty($_GET['page'])? 1 : $_GET['page'];
$each = _NUM_PAGE;

//ส่วนที่ 2
List($goto,$totalpage) = SelectPage($page,$each,"",MAJOR,"");
?>
<a href="index.php?mod=teacher&name=major&act=add" class="btn btn-success"><i class="icon-plus icon-white"></i> เพิ่มรายวิชาใหม่</a>
<table class="table table-striped table-bordered table-condensed">
  <thead>    
    <tr>
      <th>#</th>
      <th>ชื่อวิชา</th>
      <th colspan="2" style="text-align:center;">ระยะเวลาในการเรียนการสอน<br />วันเริ่มต้น<span style="margin:0 50px 0 50px;">-</span> วันสิ้นสุด</th>
      <th>สถานะ</th>
      <th>ส่วนจัดการ</th>
    </tr>
  </thead>
  <tbody>
<?php

//ส่วนที่ 3
ConnectDB();
$sql="SELECT a.id,a.code,a.name,a.stdate,a.endate,a.status FROM ".MAJOR." As a WHERE a.author_id='{$_SESSION['_id']}' LIMIT ".$goto.",".$each;
$query = QueryDB($sql);
$i = 1;
while($rs = FetchDB($query)):
  ?>
  
    <tr>
      <td><?php echo ($i + (($each * $page) - $each));?></td>
      <td><a data-toggle="modal" href="#myMajor" id="majorEvent" mId="<?php echo $rs['id'];?>"><?php echo '('.$rs['code'].')'.$rs['name'];?></a></td>
      <td><?php echo ThaiTimeConvert($rs['stdate']);?></td>
      <td><?php echo ThaiTimeConvert($rs['endate']);?></td>
      <td><?php echo $_STATUS[$rs['status']];?></td>
      <td>
		<div class="btn-group">
          <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">จัดการ <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?mod=teacher&name=major&act=edit&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขเนื้อหา</a></li>
            <li><a href="index.php?mod=teacher&name=major/lesson&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขบทเรียน</a></li>
            <li><a href="index.php?mod=teacher&name=major/aftertest&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขแบบทดสอบก่อนเรียน</a></li>
            <li><a href="index.php?mod=teacher&name=major/beforetest&id=<?php echo $rs['id'];?>"><i class="icon-pencil"></i> แก้ไขแบบทดสอบหลังเรียน</a></li>
            <li><a data-toggle="modal" href="#delete_<?php echo $i;?>"><i class="icon-trash"></i> ลบข้อมูล</a></li>
          </ul>
        </div>
		<!-- box alert -->
		<div id="delete_<?php echo $i;?>" class="modal hide fade" style="display: none;">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ยืนยันการลบข้อมูล</h3>
			</div>
			<div class="modal-body">
				<p>คุณต้องการลบข้อมูลวิชา หัวข้อ : <u><?php echo $rs['title'];?></u>  นี้หรือไม่ ?></p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" href="index.php?mod=teacher&name=major&act=delete&id=<?php echo $rs['id'];?>">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="#">ยกเลิก</a>
			</div>
		</div>
	  </td>
    </tr>
<?php
	$i++;
endwhile;

CloseDB();
?>
  </tbody>
</table>
<div id="myMajor" class="modal hide fade" style="display: none; left:35%; width:1000px;"></div>
<script  type="text/javascript">
$(document).ready(function(){
	
	$('a#majorEvent').click(function(){
		id = $(this).attr('mId');
		$.get(
			'json.php',
			{mod:'teacher',name:'get_data',id:id},
			function(data){
				$('#myMajor').html(data);
			},
			'html'
		);		
 
	});
});
</script>
<?php
//ส่วนที่ 4
echo SplitPage($page,$totalpage,"index.php?mod=teacher&name=major");

endif;
# end view

if($act==='add'):

?>
<link href="css/datepicker.css" rel="stylesheet">
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major&act=insert" name="saciw" onSubmit="return formCheck()">
  <label>กลุ่มวิชา</label>
  <div class="controls">
	<select name="lid">
		<?php
			ConnectDB();
			$sql="SELECT id,code,title FROM ".LEAR."";
			$query = QueryDB($sql);
			while($rsl = FetchDB($query)):
				echo '<option value="'.$rsl['id'].'" id="'.$rsl['code'].'">'.$rsl['title'].'</option>'."\n";
			endwhile;
			CloseDB();
		?>
	</select>
  </div>
  <label>รหัสวิชา</label>
  <input type="text" name="code" id="code" class="span1" size="16" placeholder="รหัสวิชา">
  <label>ชื่อรายวิชา</label>
  <input type="text" name="name" class="span3" size="16" placeholder="ชื่อรายวิชา">
  <label>เนื้อหา</label>
  <div class="controls">
	<textarea id="textarea1" name="content" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label>วัตถุประสงค์</label>
  <div class="controls">
	<textarea id="textarea2" name="prerequisite" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label>เอกสารอ้างอิง</label>
  <div class="controls">
	<textarea id="textarea3" name="reference" class="input-xlarge ckeditor" rows="5"></textarea>
  </div>
  <label>ข้อสอบแต่ละบท</label>
  บทเรียนละ&nbsp;<input type="text" name="final" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="จำนวน">&nbsp;ข้อ<span style="color:red;">*&nbsp;ตัวอย่าง : มีบทเรียนทั้งหมด 10 บท ถ้าใส่เลข 2 จะมีข้อสอบท้ายวิชา 20 ข้อ</span>
  <label>ชั้นเรียนที่จะเปิดการเรียนการสอน</label>
	<table id="choice">
	<tr>
		<th>&nbsp;#&nbsp;</th>
		<th>ตัวเลือกชั้นเรียน</th>
	</tr>
	<tr >
		<td>1</td>
		<td><select id="education" name="education[]" style="width:120px;">
			<option value="">เลือกการศึกษา</option> 
			<?php foreach($EDUC As $v=>$k): ?> 
				<option value="<?php echo $v; ?>"><?php echo $k; ?></option> 
			<?php endforeach; ?>
			</select>
			<select id="class" name="class[]" style="width:80px;">
			<option value="">เลือกชั้น</option>
			<?php for($i=1;$i<=6;$i++): ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor;?>
			</select>
			<span>ห้อง</span><input type="text" id="room" name="room[]" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="ห้อง">
		</td>
	</tr>
	</table>
	<div style="right:0;" class="btn-group">
	<button onclick="pChoice()" type="button" class="btn" title="เพิ่ม" ><i class="icon-plus"></i></button>
	<button onclick="mChoice()" type="button" class="btn" title="ลบ"><i class="icon-minus"></i></button>
  </div>
  <label></label>
  <div class="alert alert-error" id="alert" style="display: none;">
	<strong>Oh snap!</strong>
  </div>
  <label>ระยะเวลาในการเรียนการสอน</label>
  <div style="float: left; margin-right:30px;">วันเริ่มต้น.<a href="#" class="btn small" id="dp4" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>">คลิก</a>
  <br />
  <span id="startDate"><?php echo date('d').'/'.$SHORT_MONTH2[date('m')].'/'.(date('Y')+543);?></span>
  <input type="hidden" name="stdate" value="<?php echo date('Y-m-d');?>">
  </div>
  <div style="margin-left:30px;">วันสิ้นสุด.<a href="#" class="btn small" id="dp5" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>">คลิก</a>
  <br />
  <span id="endDate"><?php echo date('d').'/'.$SHORT_MONTH2[date('m')].'/'.(date('Y')+543);?></span>
  <input type="hidden" name="endate" value="<?php echo date('Y-m-d');?>">
  </div>
  <label></label>

  <label class="checkbox">
	<input type="checkbox" id="optionsCheckbox" name="status" value="Y">
	เปิดรายวิชานี้หรือไม่ ?
  </label>
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> บันทึก</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<script type="text/javascript">
	var startDate = new Date(<?php echo date('Y,').(date('m')-1).date(',d');?>);
	var endDate = new Date(<?php echo date('Y,').(date('m')-1).date(',d');?>);
</script>
<?php
endif;
#end add

if($act==='insert'):
	ConnectDB();
	$sql ="SELECT id FROM ".MAJOR." WHERE lid='".$_POST['lid']."' AND code='".$_POST['code']."' AND name='".$_POST['name']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>ข้อมูลซ้ำกันนะ<br />ปรับเปลี่ยนข้อมูล</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{
		$sql = array(
			"lid"=>$_POST['lid'],
			"code"=>$_POST['code'],
			"name"=>$_POST['name'],
			"content"=>EnCodeText($_POST['content']),
			"prerequisite"=>EnCodeText($_POST['prerequisite']),
			"reference"=>EnCodeText($_POST['reference']),
			"create_time"=>TIMES,
			"update_time"=>TIMES,
			"stdate"=>$_POST['stdate'],
			"endate"=>$_POST['endate'],
			"final"=>$_POST['final'],
			"status"=>empty($_POST['status'])?'N':$_POST['status'],
			"author_id"=>$_SESSION['_id'],
		);

		if(InsertDB(MAJOR,$sql)){
			$id = mysql_insert_id();
		  if(!empty($_POST['education'])){
			$education = $_POST['education'];
			$class = $_POST['class'];
			$room = $_POST['room'];
			$count = count($education);
			for($i=0;$i<=$count;$i++):
				if(!empty($education[$i])){
					$sql = array('id'=>$id,'education'=>$education[$i],'class'=>$class[$i],'room'=>$room[$i]);
					if(InsertDB(MAROOM,$sql));
				}
			endfor;
          }
			$ms = array(
				'message'=>' <strong>บันทึกข้อมูลเรียบร้อย<br />ต้องการสร้างบทเรียนต่อหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=teacher&name=major/lesson&act=add&id='.$id,
				'no'=>'index.php?mod=teacher&name=major',
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
	}// CLOSE IF NUM_ROWS
	CloseDB();
endif;
#end insert

if($act==='edit'):
ConnectDB();
$sql = "SELECT id,lid,code,name,content,prerequisite,reference,stdate,endate,final,status FROM ".MAJOR." WHERE id='".$_GET['id']."' LIMIT 1";
$quer = QueryDB($sql) ;
$rs = FetchDB($quer);
CloseDB();
?>
<!-- data-toggle="tab" -->
<ul class="nav nav-tabs" id="tab">
	<li class="active"><a href="index.php?mod=teacher&name=major&act=edit&id=<?php echo $_GET['id'];?>">เนื้อหา</a></li>
    <li><a href="index.php?mod=teacher&name=major/lesson&id=<?php echo $_GET['id'];?>">บทเรียน&nbsp;(<?php echo countAll(LESS,'mid',"mid='".$_GET['id']."'",false);?>)</a></li>     
    <li><a href="index.php?mod=teacher&name=major/aftertest&id=<?php echo $_GET['id'];?>">แบบทดสอบก่อนเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='A'",false);?>)</a></li>     
    <li><a href="index.php?mod=teacher&name=major/beforetest&id=<?php echo $_GET['id'];?>">แบบทดสอบหลังเรียน&nbsp;(<?php echo countAll(LESS.' As l INNER JOIN '.TEST.' As t ON(l.id=t.lsid)','l.mid',"l.mid='".$_GET['id']."' AND code='B'",false);?>)</a></li>     
</ul>
<link href="css/datepicker.css" rel="stylesheet">
<script src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<form class="well" method="post" action="index.php?mod=teacher&name=major&act=update&id=<?php echo $rs['id'];?>" name="saciw" onSubmit="return formCheck()">
  <label>กลุ่มวิชา</label>
  <div class="controls">
	<select name="lid">
		<?php
			ConnectDB();
			$sql="SELECT id,code,title FROM ".LEAR."";
			$query = QueryDB($sql);
			while($rsl = FetchDB($query)):
				echo '<option value="'.$rsl['id'].'" id="'.$rsl['code'].'" '.Correct($rsl['id'],$rs['lid'],'s').'>'.$rsl['title'].'</option>'."\n";
			endwhile;
			CloseDB();
		?>
	</select>
  </div>
  <label>รหัสวิชา</label>
  <input type="text" name="code" class="span1" size="16" value="<?php echo $rs['code'];?>"  placeholder="รหัสวิชา">
  <label>ชื่อรายวิชา</label>
  <input type="text" name="name" class="span3" size="16" value="<?php echo $rs['name'];?>" placeholder="ชื่อรายวิชา">
  <label>เนื้อหา</label>
  <div class="controls">
	<textarea id="textarea1" name="content" class="input-xlarge ckeditor" rows="5">
	<?php echo DeCodeText($rs['content']);?>
	</textarea>
  </div>
  <label>วัตถุประสงค์</label>
  <div class="controls">
	<textarea id="textarea2" name="prerequisite" class="input-xlarge ckeditor" rows="5">
	<?php echo DeCodeText($rs['prerequisite']);?>
	</textarea>
  </div>
  <label>เอกสารอ้างอิง</label>
  <div class="controls">
	<textarea id="textarea3" name="reference" class="input-xlarge ckeditor" rows="5">
	<?php echo DeCodeText($rs['reference']);?>
	</textarea>
  </div>
  <label>ข้อสอบแต่ละบท</label>
  บทเรียนละ&nbsp;<input type="text" name="final" value="<?php echo $rs['final'];?>" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="จำนวน">&nbsp;ข้อ<span style="color:red;">*&nbsp;ตัวอย่าง : มีบทเรียนทั้งหมด 10 บท ถ้าใส่เลข 2 จะมีข้อสอบท้ายวิชา 20 ข้อ</span>
  <label>ชั้นเรียนที่จะเปิดการเรียนการสอน</label>
	<table id="choice">
	<tr>
		<th>&nbsp;#&nbsp;</th>
		<th>ตัวเลือกชั้นเรียน</th>
	</tr>	
	<?php
		ConnectDB();
		$sql_="SELECT education,class,room FROM ".MAROOM." WHERE id='".$rs['id']."'";
		$query_ch = QueryDB($sql_);

		if(RowsDB($query_ch)===false):
	?>
	<tr >
		<td>1</td>
		<td><select id="education" name="education[]" style="width:120px;">
			<option value="">เลือกการศึกษา</option> 
			<?php foreach($EDUC As $v=>$k): ?> 
				<option value="<?php echo $v; ?>"><?php echo $k; ?></option> 
			<?php endforeach; ?>
			</select>
			<select id="class" name="class[]" style="width:80px;">
			<option value="">เลือกชั้น</option>
			<?php for($i=1;$i<=6;$i++): ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor;?>
			</select>
			<span>ห้อง</span><input type="text" id="room" name="room[]" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="ห้อง">
		</td>
	</tr>
	<?php
		else:
			$nChs = 1;
			while($ch = FetchDB($query_ch)):
	?>
	<tr class="<?php echo($nChs===1)?'':'nChoice';?>">
		<td><?php echo $nChs;?></td>
		<td><select id="education" name="education[]" style="width:120px;">
			<option value="">เลือกการศึกษา</option> 
			<?php foreach($EDUC As $v=>$k): ?> 
				<option value="<?php echo $v; ?>" <?php echo Correct($v,$ch['education'],'s');?>><?php echo $k; ?></option> 
			<?php endforeach; ?>
			</select>
			<select id="class" name="class[]" style="width:80px;">
			<option value="">เลือกชั้น</option>
			<?php for($i=1;$i<=6;$i++): ?>
				<option value="<?php echo $i; ?>" <?php echo Correct(sprintf($i),$ch['class'],'s');?>><?php echo $i; ?></option>
			<?php endfor;?>
			</select>
			<span>ห้อง</span><input type="text" id="room" name="room[]" class="span1" maxlength="2" value="<?php echo $ch['room']?>" onkeypress="check_number(event);" placeholder="ห้อง">
		</td>
	</tr>
	<?php
				$nChs++;
			endwhile;
		endif;
		CloseDB();
	?>
	</table>
	<div style="right:0;" class="btn-group">
	<button onclick="pChoice()" type="button" class="btn" title="เพิ่ม" ><i class="icon-plus"></i></button>
	<button onclick="mChoice()" type="button" class="btn" title="ลบ"><i class="icon-minus"></i></button>
  </div>
  <label></label>
  <div class="alert alert-error" id="alert" style="display: none;">
	<strong>Oh snap!</strong>
  </div>
  <label>ระยะเวลาในการเรียนการสอน</label>
  <div style="float: left; margin-right:30px;">วันเริ่มต้น.<a href="#" class="btn small" id="dp4" data-date-format="yyyy-mm-dd" data-date="<?php echo $rs['stdate'];?>">คลิก</a>
  <br />
  <span id="startDate">
  <?php $stdate = explode('-',$rs['stdate']);
  echo $stdate[2].'/'.$SHORT_MONTH2[$stdate[1]].'/'.($stdate[0]+543);?></span>
  <input type="hidden" name="stdate" value="<?php echo $rs['stdate'];?>">
  </div>
  <div style="margin-left:30px;">วันสิ้นสุด.<a href="#" class="btn small" id="dp5" data-date-format="yyyy-mm-dd" data-date="<?php echo $rs['endate'];?>">คลิก</a>
  <br />
  <span id="endDate">
  <?php $endate = explode('-',$rs['endate']);
  echo $endate[2].'/'.$SHORT_MONTH2[$endate[1]].'/'.($endate[0]+543);?></span>
  <input type="hidden" name="endate" value="<?php echo $rs['endate'];?>">
  </div>

  <label class="checkbox">
	<input type="checkbox" id="optionsCheckbox" name="status" value="Y" <?php echo Correct($rs['status'],'Y','c');?>>
	เปิดรายวิชานี้หรือไม่ ?
  </label>
  <label></label>
  <button type="submit" class=" btn btn-primary"><i class="icon-plus-sign icon-white"></i> แก้ไข</button>
  <a class="btn btn-info" href="javascript:history.go(-1);"><i class="icon-minus-sign icon-white"></i> ยกเลิก</a>
</form>
<script type="text/javascript">
	var startDate = new Date(<?php echo $stdate[0].','.($stdate[1]-1).','.$stdate[2];?>);
	var endDate = new Date(<?php echo $endate[0].','.($endate[1]-1).','.$endate[2];?>);
</script>
<?php
endif;
#end edit

if($act==='update'):
	ConnectDB();
	$id = $_GET['id'];
	$sql ="SELECT id FROM ".MAJOR." WHERE id !='".$id."' AND lid='".$_POST['lid']."' AND code='".$_POST['code']."' AND name='".$_POST['name']."'";
	$res = QueryDB($sql) ;
	$row = RowsDB($res) ;
	if($row>0){
		$ms = array(
			'message'=>' <strong>ข้อมูลซ้ำกันนะ<br />ปรับเปลี่ยนข้อมูล</strong>',
			'class'=>'btn-warning',
			'yes'=>'',
			'no'=>'',
		);
		ShowProcess($ms);
	}else{
		$sql = array(
			"lid"=>$_POST['lid'],
			"code"=>$_POST['code'],
			"name"=>$_POST['name'],
			"content"=>EnCodeText($_POST['content']),
			"prerequisite"=>EnCodeText($_POST['prerequisite']),
			"reference"=>EnCodeText($_POST['reference']),
			"update_time"=>TIMES,
			"stdate"=>$_POST['stdate'],
			"endate"=>$_POST['endate'],
			"final"=>$_POST['final'],
			"status"=>empty($_POST['status'])?'N':$_POST['status'],
		);
		

		if(UpdateDB(MAJOR,$sql,"id='".$id."'")){
			if(!empty($_POST['education'])){	
				if(DeleteDB(MAROOM,"id='".$id."'"));
				$education = $_POST['education'];
				$class = $_POST['class'];
				$room = $_POST['room'];
				$count = count($education);
				for($i=0;$i<=$count;$i++):
					if(!empty($education[$i])){
					$sql = array('id'=>$id,'education'=>$education[$i],'class'=>$class[$i],'room'=>$room[$i]);
					if(InsertDB(MAROOM,$sql));
				}
			endfor;
			}
			$ms = array(
				'message'=>' <strong>แก้ไขข้อมูลเรียบร้อย<br />ต้องการแก้ไขข้อมูลนี้อีกครั้งหรือไม่ ?</strong>',
				'class'=>'btn-success',
				'yes'=>'index.php?mod=teacher&name=major&act=edit&id='.$_GET['id'],
				'no'=>'index.php?mod=teacher&name=major',
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
	}
	CloseDB();
endif;
# end update

if($act==='delete'):
	ConnectDB();
	if(DeleteDB(MAJOR,"id='".$_GET['id']."'")){
		echo '<meta http-equiv="refresh" content="0;URL=index.php?mod=teacher&name=major">';
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



<?php
if(($act=='add') OR ($act=='edit')):
?>

<script language="Javascript" type="text/javascript">
//กำหนดค่า code กรณี ต้องการเปลี่ยนรหัส
<?php $code = empty($rs["code"])? '':explode('.',$rs["code"]);?>
var code = '<?php echo empty($code)?'':$code['1'];?>';

$('select[name^="lid"]').change(function () {
	$('select[name^="lid"] option:selected').each(function(i){
		$('input[name="code"]').val($(this).attr('id')+code);
	});
}).trigger('change');

//กำหนดค่าเริ่มให้กับการเลือกต่างๆ
var nChs= <?php echo empty($nChs)? 1 : ($nChs-1);?>;
function pChoice(){
	$("table#choice").append('<tr class="nChoice"><td>'+parseInt(nChs+1)+'</td><td><select id="education" name="education[]" style="width:120px;"><option value="" selected>เลือกการศึกษา</option> <?php foreach($EDUC As $v=>$k): ?> <option value="<?php echo $v; ?>"><?php echo $k; ?></option> <?php endforeach; ?></select><select id="class" name="class[]" style="width:80px;"><option value="" selected>เลือกชั้น</option><?php for($i=1;$i<=6;$i++): ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php endfor;?></select><span>ห้อง</span><input type="text" id="room" name="room[]" class="span1" maxlength="2" onkeypress="check_number(event);" placeholder="ห้อง"></td></tr>');
	nChs++;	
}
  
function mChoice() {
	$("table#choice tr.nChoice:last").remove();
	nChs--;
}

</script>

<script language="Javascript" type="text/javascript">
//<![CDATA[
	//defult ถ้าประกาศใน textarea id="textarea"
	CKEDITOR.replace( 'textarea1',{	
		height 	: 400
	} );
	CKEDITOR.replace( 'textarea2',{	
		height 	: 400
	} );
	CKEDITOR.replace( 'textarea3',{	
		height 	: 200
	} );
//]]>

//ตรวจสอบค่าว่าง
function formCheck() {
	
	var obj = document.saciw;
	if (obj.code.value.length < '3') {
		alert("กรุณากรอกรหัสวิชา");
		obj.code.focus();
		return false;
	}
	if (obj.name.value == false) {
		alert("กรุณากรอกชื่อรายวิชา");
		obj.name.focus();
		return false;
	}
	/*if (obj.content.value == false) {
		alert("กรุณากรอกเนื้อหา");
		obj.content.focus();
		return false;
	}
	if (obj.prerequisite.value == false) {
		alert("กรุณากรอกวัตถุประสงค์");
		obj.prerequisite.focus();
		return false;
	}
	if (obj.reference.value == false) {
		alert("กรุณากรอกเอกสารอ้างอิง");
		obj.reference.focus();
		return false;
	}*/	
	if(validation() == false){
		return false;
	}
}
//ตรวจสอบค่าว่างของตัวเลือก
function validation() {
		var err = "";				
		if(!educationVali()){
			err += "- เลือกระดับการศึกษาให้ถูกต้อง\n";
		}
		if(!classVali()){
			err += "- เลือกระดับชั้นให้ถูกต้อง\n";
		}
		if(!roomVali()){
			err += "- ใส่เลขห้องเรียน\n";
		}
		if(err.length == 0)
			return true;
		alert("กรุณาตรวจสอบความผิดผลาด\n"+err);
		return false;
}
function educationVali() {
		var ret = true;
		$('select[name^="education"]').change(function () {
			$('select[name^="education"] option:selected').each(function(i){
				if($(this).val().length == false)
					ret = false;
			});
		}).trigger('change');
		return ret;
}
function classVali() {
		var ret = true;
		$('select[name^="class"]').change(function () {
			$('select[name^="class"] option:selected').each(function(i){
				if($(this).val().length == false)
					ret = false;
			});
		}).trigger('change');
		return ret;
}
function roomVali() {
		var ret = true;
		$('input[name^="room"]').each(function(i){
			if($(this).val().length == false)
				ret = false;
		});
		return ret;
}
</script>

<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$(function(){
			window.prettyPrint && prettyPrint();
			/*
			var startDate = new Date(<?php date('Y,m,d');?>);
			var endDate = new Date(<?php date('Y,m,d');?>);
			*/
			var monthThai = <?php echo json_encode($SHORT_MONTH2);?>;
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('วันที่เริ่มต้นไม่สามารถที่มากขึ้นแล้ววันที่สิ้นสุด');
						$('button[type="submit"]').hide();
					} else {
						$('#alert').hide();
						$('button[type="submit"]').show();
						startDate = new Date(ev.date);
						date = $('#dp4').data('date').split("-");
						dateThai=date[2]+'/'+monthThai[date[1]]+'/'+(parseFloat(date[0])+parseFloat(543));
						$('#startDate').text(dateThai);
						$('input[name="stdate"]').val($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('วันที่สิ้นสุดไม่สามารถน้อยแล้ววันที่เริ่มต้น');
						$('button[type="submit"]').hide();
					} else {
						$('#alert').hide();
						$('button[type="submit"]').show();
						endDate = new Date(ev.date);
						date = $('#dp5').data('date').split("-");
						dateThai=date[2]+'/'+monthThai[date[1]]+'/'+(parseFloat(date[0])+parseFloat(543));
						$('#endDate').text(dateThai);
						$('input[name="endate"]').val($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});
		});
	</script>

<?php
endif;
?>