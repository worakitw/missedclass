<?php
//header('Content-Type: text/html; charset=utf-8');
// ------------------------------------
// html/config.php
// ------------------------------------
/*
DROP DATABASE IF EXISTS `missedclass`;
CREATE DATABASE `missedclass`;
use `missedclass`;
-- --------------------------------------------------------
-- user is `missedclass`
-- password is missedclass123
GRANT ALL PRIVILEGES ON missedclass.* TO missedclass@localhost IDENTIFIED BY 'missedclass123';

*/
$servername = 'localhost';
$username = 'missedclass';
$password = 'missedclass123';
$dbname = 'missedclass';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn,"utf8");




function getGroup($c){
    $sql = "SELECT * FROM student where code='$c'";
//	echo $sql;
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res))
        return $row['u_group'];
}

function getName($c){
    $sql = "SELECT * FROM student where code='$c'";
//	echo $sql;
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res))
        return $row['name'].'  '.$row['lastname'];
}

function getTName($c){
    $sql = "SELECT * FROM teacher where teaId13='$c'";
//	echo $sql;
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res))
        return $row['teaName'];
}

//แบ่งหน้า
function page_navi($page, $limit, $range, $count, $send=NULL, $current_style="navi_on", $other_style="navi_out", $target="_self"){
	$output = "";
	$total = ceil($count/$limit);
	$navi_start = $page-$range;
	$navi_end = $page+$range;
	
	$send .= (!empty($send))? "&" : NULL;
		
	if($navi_start <= 0) $navi_start = 1;
	if($navi_end >= $total) $navi_end = $total;
	
	if($page>1){
		$navi_back = $page-1;
		if($page > 2)
		$output .= "<a href=\"?" . $send . "page=1\" target=\"" . $target . "\" class=\"" . $other_style . "\"><strong>&laquo;</strong></a> ";
		$output .= "<a href=\"?" . $send . "page=" . $navi_back . "\" target=\"" . $target . "\" class=\"" . $other_style . "\"><strong>&#8249;</strong></a> ";
	}
	for($i = $navi_start; $i <= $navi_end; $i++){
		if($i == $page)
		$output .= "<a href=\"?" . $send . "page=" . $i . "\" target=\"" . $target . "\" class=\"" . $current_style . "\"><strong><font color=\"" . $other_style . "\">$i</font></strong></a> ";
		else
		$output .= "<a href=\"?" . $send . "page=" . $i . "\" target=\"" . $target . "\" class=\"" . $other_style . "\">$i</a> ";
	}
	if($page < $total){
		$navi_next = $page+1;
		$output .= "<a href=\"?" . $send . "page=" . $navi_next . "\" target=\"" . $target . "\" class=\"" . $other_style . "\"><strong>&#8250;</strong></a> ";
		if(($page+1) < $total)
		$output .= "<a href=\"?" . $send . "page=" . $total . "\" target=\"" . $target . "\" class=\"" . $other_style . "\"><strong>&raquo;</strong></a>";
	}
	if($navi_start>$navi_end) 
		$output .= "<a href=\"?" . $send . "page=" . $page . "\" target=\"" . $target . "\" class=\"" . $other_style . "\"><strong>$page</strong></a> ";
	return $output;
}

function getDepName($c){
    $sql = "SELECT * FROM depart where depId='$c'";
//	echo $sql;
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res))
        return $row['depName'];
}

function getTeaName($c){
    $sql = "SELECT * FROM teacher where teaId='$c'";
//	echo $sql;
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res))
        return $row['teaName'];
}
//เพิ่มเลข 0 ถ้าไม่ถึง 10  // 3 >> 0000003
function ins0($s){
    if ($s<10){
        $r="000000".$s;
    }else if ($s<100){
        $r="00000".$s;    
    }
    return $r;
}
?>

