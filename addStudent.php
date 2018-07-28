<?php
session_start();
require_once 'config.php';
// date_default_timezone_set('Asia/Bangkok');
$datenow= $_SESSION['user']['datenow'];
$data=$_POST;
//  print_r($data);
if ($data['std_code']!=''){
        $chk=validate($data['sem'],$data['std_code'],$data['subjId'],$datenow,$data['tid'],$data['stdGroupId']);
        // echo $chk;exit;
        if($chk==''){
                $sql = "INSERT INTO std_missed values('','".$data['sem']."','".$data['std_code']."','".$data['stdGroupId']."',
                '".$data['subjId']."','$datenow','".$data['tid']."') ;" ;
                $res = mysqli_query($conn,$sql);
        }  
       
}
$link="checkStudent.php?subjId=".$data['subjId']."&stdGroupId=".$data['stdGroupId']."&sem=".$data['sem']."&tid=".$data['tid'];
header("location:".$link); 
        

function validate($s,$std,$subj,$d,$t,$g){
        global $conn;
        // $row=array();
        $sql="SELECT * FROM `std_missed` 
                WHERE `sem`='$s' AND `std_code`='$std' 
                AND `subj_id`='$subj' AND `date`='$d' 
                AND `tid`='$t' AND stdGroupId='$g'";
//        echo $sql;exit();
        $res = mysqli_query($conn,$sql);
        $cnt=mysqli_num_rows($res);
        if ($cnt>0){
                
                return 'xxx';
        }else{
                return '';
        }   
}


