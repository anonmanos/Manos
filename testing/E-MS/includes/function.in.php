<?php
//ตรวจสอบสิทธิการใช้งาน
function EventLogin($session="",$level=""){
    if(!empty($session)){
	    if((!empty($session['_ip']) != session_id()) OR ($session['_id']===null) OR  ($session['_level']!==$level)){ 
			$ms = array(
				'message'=>'สาเหตุ<br />
						1.คุณอาจจะไม่มีสิทธิ์เข้าหน้านี้<br />
						2.คุณอาจจะไม่ได้ล็อกอินเข้าระบบ',
				'class'=>'btn-warning',
			);
			ShowProcess($ms);
	    }
    }else{
		$ms = array(
				'message'=>' <strong>คุณกำลังดำเนินการอะไรบางอย่างที่ไม่ถูกต้อง</strong>',
				'class'=>'btn-danger',
				'yes'=>'index.php?mod=logout',
		);
		ShowProcess($ms);
	}
}

//Icon News
function iconNews($ctime="",$utime=""){
	if($ctime < $utime){
		return "<img src=\"images/update.gif\">";
	}else if($ctime === $utime){
		$day = ((TIMES-$ctime)/86400);
		if($day<=7){
			return "<img src=\"images/new.gif\">";
		}
		
	}else{
		return false;
	}
	
}

//ตัดช่องว่างก่อนและหลังข้อความ
function trimRequest($req=null){
	if(!empty($req)):
		$_req = array();
		foreach($req as $k=>$v):
			if(is_array($v)):
				foreach($v as $a=>$b):
					$_req[$k][$a] = trim($b);
				endforeach;
			else:
				$_req[$k] = trim($v);
			endif;
			
		endforeach;
		return $_req;
	endif;
}
function SelectMemu($mod="index",$name="index"){
	if($mod==$name)
		return 'current_page_item';
}
function EnCodeText($txt){
	$txt = trim(htmlspecialchars($txt));
	//$txt = trim(addslashes(htmlspecialchars($txt)));
	return $txt;
}
function DeCodeText($txt){
	$txt = htmlspecialchars_decode($txt);
	//$txt = htmlspecialchars_decode(stripslashes($txt));
	return $txt;
}

// การเลือกรายการใน Select box
function Correct($key="",$id="",$e=""){
	$opt = array("s"=>"selected","c"=>"checked","r"=>"readonly","d"=>"disabled");
	if($key===$id)
		$value = $opt[$e];
	else
		$value = "";
	return $value;
}
//แสดงการดำเนินงาน
function ShowProcess($ms=array()){
	$ms['message'] = empty($ms['message'])?'รายการไม่ถูกต้อง':$ms['message'];
	$ms['class'] = empty($ms['class'])?'btn-primary':$ms['class'];
	$ms['yes'] = empty($ms['yes'])?'javascript:history.go(-1);':$ms['yes'];
	$ms['no'] = empty($ms['no'])?'#':$ms['no'];
	echo '
		<div id="myModal" class="modal show '.$ms['class'].'">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" href="#">&times;</a>
				<h3>ข้อความแจ้งเตือน</h3>
			</div>
			<div class="modal-body">
				<p>'.$ms['message'].'</p>
			</div>
			<div class="modal-footer">	
				<a class="btn btn-primary" href="'.$ms['yes'].'">ตกลง</a>
				<a data-dismiss="modal" class="btn" href="'.$ms['no'].'">ยกเลิก</a>
			</div>
		</div>';
	exit();
}

/*function SaveComment($Time="",$URL="",$Message=""){
}*/
//ส่งเมล์

function format_email($info, $file){

	//set the root
	$root = _ROOT.'/template_email';
	//grab the template content
	$template = file_get_contents($root.'/'.$file);
			
	//replace all the tags
	foreach($info As $key => $val){
		$template = preg_match($key, $val, $template);
	}
	/*$template = ereg_replace('{USERNAME}', $info['username'], $template);
	$template = ereg_replace('{EMAIL}', $info['email'], $template);
	$template = ereg_replace('{KEY}', $info['key'], $template);
	$template = ereg_replace('{SITEPATH}','http://site-path.com', $template);*/
		
	//return the html of the template
	return $template;

}
//include the swift class
				
//Function Sendmail
function SendMail($send="",$subject="",$info="",$file="",$from="no-reply@uru.ac.th"){

	$body = format_email($info,$file);
	
	include("includes/mimemail.inc.php");
    $mail = new MIMEMAIL("HTML"); // ส่งแบบ HTML
    $mail->senderName = "sAcIw"; // ชื่อผู้ส่ง
    $mail->senderMail = $from; // อีเมลล์ผู้ส่ง
    //$mail->bcc = "bcc@email"; // ส่งแบบ bind carbon copy
    $mail->subject = $subject; // หัวข้ออีเมลล์
    $mail->body = $body;   // ข้อความ หรือ HTML ก็ได้
    //$mail->attachment[] = "path_to_file1/filename1"; // ระบุตำแหน่งไฟล์ที่จะแนบ
    $mail->create();
    //$mail->send($email); // เมลล์ผู้รับ

	/* and now mail it */
	if($mail->send($send)){
		return true ;
	}else{
		return false ;
	}
} 
/*
<div class="pagination">
  <ul>
    <li><a href="#">&lt;&lt;</a></li>
    <li class="active"><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">&gt;&gt;</a></li>
  </ul>
</div>
*/
//ทำการแบ่งหน้า
function SplitPage($page="",$totalpage="",$option=""){
    $option .= "&page=";
    $box = '<div class="pagination">';
                //แสดงรายละเอียด
				$box .= '<ul>';
                //ปุ่มหน้าแรก
                $box .= '<li><a href="'.$option.'1" title="หน้าแรก">&laquo;</a></li>';
                //ปุ่มกดไปก่อนหน้า
                if($page>1){
                        $box .= '<li><a href="'.$option.($page-1).'" title="ย้อนหลัง">&lsaquo;</a></li>';
                }
                //แสดงจุดไข่ปลา
                if(($page-2)>1){
                    $box .= '<li><a href="#">...</a></li>';
                }
                //แสดงเลขก่อนหน้าปัจจุบัน
                $last = ($page-2);
                for($i=$last;$i<$page;$i++){
                    if($i>=1){
                        $box .= '<li><a href="'.$option.$i.'" title="หน้า '.$i.'">'.$i.'</a></li>';
                    }  
                }
                //แสดงหน้าปัจจุบัน
                $box .= '<li class="active"><a href="#" title="หน้าปัจจุบัน">'.$page.'</a></li>';
                //แสดงเลขหลังหน้าปัจจุบัน
                $next = ($page+2);
                for($i=$page+1;$i<=$next;$i++){
                    if($i<=$totalpage){
                        $box .= '<li><a href="'.$option.$i.'" title="หน้า '.$i.'">'.$i.'</a></li>';
                    }
                }
                //แสดงจุดไข่ปลา
                if(($page+3)<$totalpage){
                    $box .= '<li><a href="#">...</a></li>';
                }
                if($totalpage>1){
                    if($page!=$totalpage){
                        $box .= '<a href="'.$option.($page+1).'" title="ถัดไป">&rsaquo;</a>';
                    }
                }
                $box .= '<a href="'.$option.$totalpage.'" title="หน้าสุดท้าย">&raquo;</a>';
    $box .= '</div>';
    return $box;
}

//แปลงเวลาเป็นภาษาไทย
function ThaiTimeConvert($timestamp="",$full="",$showtime=""){
	global $SHORT_MONTH, $FULL_MONTH, $DAY_SHORT_TEXT, $DAY_FULL_TEXT;
	$list = explode("-",$timestamp);
	if(@$list[1]>0)
		$timestamp = strtotime($timestamp);

	$day = date("l",$timestamp);
	$month = date("n",$timestamp);
	$year = date("Y",$timestamp);
	$time1 = date("H:i:s",$timestamp);
	$time2 = date("H:i",$timestamp);
	if($full){
		$ThaiText = $DAY_FULL_TEXT[$day]." ที่ ".date("j",$timestamp)." เดือน ".$FULL_MONTH[$month]." พ.ศ.".($year+543) ;
	}else{
		$ThaiText = date("j",$timestamp)." / ".$SHORT_MONTH[$month]." / ".($year+543);
	}

	if($showtime == "1"){
		return $ThaiText." เวลา ".$time1;
	}else if($showtime == "2"){
		$ThaiText = date("j",$timestamp)." ".$SHORT_MONTH[$month]." ".($year+543);
		return $ThaiText." : ".$time2;
	}else{
		return $ThaiText;
	}
}

//แปลงรหัสผ่าน
function PassEnCode($password=""){
	return base64_encode(base64_encode(base64_encode(trim($password))));
}
function PassDeCode($password=""){
	return base64_decode(base64_decode(base64_decode(trim($password))));
}

function ExpDate($date="",$number="",$mark=""){
 $datstr=strtotime($date); // ทำให้ข้อความเป็นวินาที
 $tod=$number*86400; // รับจำนวนวันมาคูณกับวินาทีต่อวัน
 if($mark=="+"){
    $ndate=$datstr+$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา
 }elseif($mark=="-"){
    $ndate=$datstr-$tod; // นับบวกไปอีกตามจำนวนวันที่รับมา    
 }
 return $ndate; // ส่งค่ากลับ
}

function GetURL($url,$get){
     $explode = explode("?",$url);
    if(count($explode) > 1){
        $path = $url."&".$get;
    }else{
        $path = $url."?".$get;
    }
    return $path;
 }

?>