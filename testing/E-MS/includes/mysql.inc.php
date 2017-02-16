<?php
//เชื่อมต่อด้าตาเบส
function ConnectDB(){
	mysql_connect('localhost','root','') or die("ไม่สามารถเชื่อมต่อ MySQL ได้");
	mysql_select_db('ems') or die("ไม่สามารถเลือกฐานข้อมูลที่ต้องการได้");
	mysql_query("SET NAMES UTF8");
	mysql_query("SET character_set_results=utf-8");
	return true;
}
//ปิดการเชื่อมด้าตาเบส
function CloseDB(){
	mysql_close() or die("ไม่สามารถตัดการเชื่อมต่อ MySQL ไม่ได้");
}
//เพิ่มข้อมูล
//InsertDB("table",array("field"=>"value"));
function InsertDB($table="", $data=""){
		$key = array_keys($data);
        $value = array_values($data);
		$sumdata = count($key);
		$i=0;
		while($i<$sumdata){
         if (empty($add)){
              $add="(";
         }else{
              $add.=",";
         }
         if (empty($val)){
              $val="(";
         }else{
              $val.=",";
         }
         $add.=$key[$i];
         $val.="'".$value[$i]."'";

		 $i++;
    }

    $add.=")";
    $val.=")";
    $sql="INSERT INTO ".$table." ".$add." VALUES ".$val;
    if (mysql_query($sql)){
         return true;
    }else{
         return false;
    }
}
//แก้ไขข้อมูลแบบหลายฟิลล์
//UpdateDB("tabel",array("field"=>"value"),"where");
function UpdateDB($table="",$data="",$where=""){
     $key = array_keys($data);
     $value = array_values($data);
     $sumdata = count($key);
     $set = "";
	 $i=0;
     while($i<$sumdata){
         if($set){ $set.=","; }
         $set.= $key[$i]."='".$value[$i]."'";
		 $i++;
     }
     $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;
    if(mysql_query($sql)){
         return true;
    }else{
         return false;
    }
}
//ลบข้อมูล
/*DeleteDB("table","where"); */
function DeleteDB($table="",$where=""){
    $sql="DELETE FROM ".$table." WHERE ".$where;
    if(mysql_query($sql)){
         return true;
    }else{
         return false;
    }
}
function DeleteMutiDB($table="",$post="",$filed=""){
	$filed = empty($filed)? "id" : $filed;
	$count = count($post);
	$i=0;
	while($i<=$count){
       if($post[$i] != ""){
		mysql_query("DELETE FROM ".$table." WHERE ".$filed."='".$post[$i]."'");
       }
	   $i++;
   }
   return true;
}
//$res = $db->select_query('SELECT field FROM table WHERE where');
#การQuery mysql และส่งค่ากลับ
function QueryDB($sql=""){
	if ($res = mysql_query($sql)){
       return $res;
    }else{
       return false;
    }
}
//แยกข้อมูล
function FetchDB($sql=""){
    if ($res = @mysql_fetch_assoc($sql)){
        return $res;
    }else{
        return false;
    }
    //return $res = mysql_fetch_array($sql);
}
//นับจำนวนแถวข้อมูล
function RowsDB($sql=""){
    if($res = @mysql_num_rows($sql)){
       return $res;
    }else{
       return false;
    }
}
//คำนวณหน้าที่จะเรียกใช้
function SelectPage($Pages="",$Eachs="",$Field="",$Table="",$Where=""){
    $Field = empty($Field)? "id" : $Field;
    $Where = empty($Where)? "" : "WHERE ".$Where;
    ConnectDB();
    $SQL = QueryDB("SELECT ".$Field." FROM ".$Table." ".$Where."");
    $Rows = RowsDB($SQL);
    $Totals = ceil($Rows/$Eachs);
    $Gotos=($Pages-1)* $Eachs;
    CloseDB();
    return array($Gotos,$Totals);
}

function countAll($tb="",$field="",$wh="",$grp,$db=true){
	if(empty($tb)):
		return false;
	else:
		if(!empty($db)) ConnectDB();
		$field = empty($field)?'id':$field;
		$wh = empty($wh)?'':'WHERE '.$wh;
		$grp = empty($grp)?'':'GROUP BY '.$grp;
		$sql = "SELECT count({$field}) As counts FROM {$tb} {$wh} {$grp}";
		$query = QueryDB($sql);
		$rs = FetchDB($query);
		if(!empty($db)) CloseDB();
		return $rs['counts'];
	endif;
}
?>
