<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php
require_once("../../mainfile.php");
if(isset($_GET['deltopic'])){
	echo "<br><br><center><img src=\"../../images/loading.gif\"><br><br><font size=\"3\" color=\"#009900\"><b>กำลังดำเนินการ</b></font></center><br><br>";
 ConnectDB();
 QueryDB("DELETE FROM ".TB_WEBBOARD." WHERE id='".$_GET['id']."'");
 @unlink("../../webboard_up/".$_GET['picture']);

$db_query=QueryDB("SELECT * FROM ".TB_WEBBOARD_COMMENT." WHERE topicid='".$_GET['id']."'");
$num_rows= RowsDB($db_query);

if($num_rows!=""){ 
	 for ($i=1;$i<=$num_rows;$i++){
		$result = FetchDB($db_query);
		$id = $result['id'];
		$picture = $result['picture'];
		QueryDB("DELETE FROM ".TB_WEBBOARD_COMMENT." WHERE id='".$id."'");
		@unlink("../../webboard_up/".$picture);
	 }
}
ShowProcess1("5","../../index.php?folder=webboard","ลบข้อมูล");
CloseDB();
}

if(isset($_GET['delcomment'])){
QueryDB("DELETE FROM ".TB_WEBBOARD_COMMENT." WHERE id='".$_GET['id']."'");
 @unlink("../../webboard_up/".$_GET['picture']);
echo"<meta http-equiv='refresh' content='5;URL=read.php?id=".$_GET['topic']."'>";
ShowProcess1("5","read.php?id=".$_GET['topic']."","ลบข้อมูล");
}
?>