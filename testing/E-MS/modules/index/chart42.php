<a href="index.php">กลับ</a>
<table border='1' style="width:50%;">
<tr>
	<th>HN</th>
	<th>ชื่อ-นามกุล</th>
	<th>ที่อยู่</th>
	<th>วันที่มา</th>
	<th>เวลา</th>
</tr>
<?php
ConnectDB();
/*
TB_PATIENT
TB_PTTYPE
TB_OVST
*/
$sql="SELECT a.hn,CONCAT(a.pname,a.fname,' ',a.lname) As fullname,CONCAT(a.addr_no,'/',a.amp,' ต.',a.tumb,' จ.',a.province) As adds,b.vstdate,b.vsttime FROM ".TB_PATIENT." As a INNER JOIN ".TB_OVST." As b ON(a.hn=b.hn) INNER JOIN ".TB_PTTYPE." As c ON(a.pttype=c.code) WHERE c.pttypename='จ่ายตรง' AND MONTH(b.vstdate)='01' AND YEAR(b.vstdate)='2012' ORDER BY b.vstdate ASC LIMIT 0, 30 ";
$query = QueryDB($sql);

while($rs = FetchDB($query)){

?>
<tr>
	<td><?php echo $rs['hn']; ?></td>
	<td><?php echo $rs['fullname']; ?></td>
	<td><?php echo $rs['adds']; ?></td>
	<td><?php echo DateConvert($rs['vstdate'],true); ?></td>
	<td><?php echo $rs['vsttime']; ?></td>
</tr>
<?php
}
CloseDB();
?>
</table>
<a href="index.php">กลับ</a>