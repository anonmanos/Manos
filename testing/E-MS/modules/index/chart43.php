<a href="index.php">กลับ</a>
<table border='1' style="width:50%;">
<tr>
	<th>HN</th>
	<th>ชื่อ-นามกุล</th>
	<th>ที่อยู่</th>
	<th>สิทธิบัตร</th>
</tr>
<?php
ConnectDB();
/*
TB_PATIENT
TB_PTTYPE
TB_OVST
*/
$sql="SELECT a.hn,CONCAT(a.pname,a.fname,' ',a.lname) As fullname,CONCAT(a.addr_no,'/',a.amp,' ต.',a.tumb,' จ.',a.province) As adds,c.pttypename FROM ".TB_PATIENT." As a INNER JOIN ".TB_PTTYPE." As c ON(a.pttype=c.code) WHERE a.tumb='03' AND a.sex='ญ' ORDER BY a.hn ASC";
$query = QueryDB($sql);

while($rs = FetchDB($query)){

?>
<tr>
	<td><?php echo $rs['hn']; ?></td>
	<td><?php echo $rs['fullname']; ?></td>
	<td><?php echo $rs['adds']; ?></td>
	<td><?php echo $rs['pttypename']; ?></td>
</tr>
<?php
}
CloseDB();
?>
</table>
<a href="index.php">กลับ</a>