<?php
require_once 'config.php';
$data=$_GET;
$code=$data['stdCode'];
$sql="DELETE FROM `missedclass`.`std_missed` WHERE std_code='$code'";
$res = mysqli_query($conn,$sql);
$link="checkStudent.php?subjId=".$data['subjId']."&stdGroupId=".$data['stdGroupId']."&sem=".$data['sem']."&tid=".$data['tid'];
header("location:".$link);
