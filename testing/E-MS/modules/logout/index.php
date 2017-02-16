<?php
ConnectDB();
$sql = array(
		"uid"=>$_SESSION['_id'],
		"atime"=>TIMES,
		"event"=>'LO',
		"ipaddr"=>IPADDRESS,
);
if(InsertDB(LOGS,$sql));
$sql="UPDATE ".USER." SET login='F' WHERE id='{$_SESSION['_id']}' LIMIT 1";
$dbquery = QueryDB($sql);
CloseDB();
session_destroy();                        
//unset($_SESSION['s_ip'],$_SESSION['s_id'],$_SESSION['s_fname'],$_SESSION[''],$_SESSION['s_lname'],$_SESSION['s_sname'],$_SESSION['s_status'],$_SESSION['adminlink'],$_SESSION['admintext']);

?>
<meta http-equiv="refresh" content="0;url=index.php">