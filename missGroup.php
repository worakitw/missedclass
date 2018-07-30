<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once ("head.php") ?>
<style type="text/css">
body {
    font-size: 12px;
}
.textAlignVer{
    display:block;
    filter: flipv fliph;
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    transform: rotate(-90deg); 
    position:relative;
    width:20px;
    white-space:nowrap;
    font-size:12px;
    margin-bottom:10px;
}
h3{
    text-align:center;
}
</style>
<body>
<?php 
include_once ("nevBar.php") ;
include_once ("function.php") ;

$g_id=$_GET['id'];
$sql="SELECT * FROM `studing` WHERE `stdGroupId` = '$g_id' group by `subjId` ORDER BY `subjId`";
$res=mysqli_query($conn, $sql);
$arr_subj=array();
$arr_hsubj=array();
if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        $arr_hsubj[]=$row['subjId']." - ". $row['subjName'];
        $arr_subj[]=$row['subjId'];
    }
}
$countSubj=count($arr_subj);
// print_r($arr_subj);
$sql="SELECT code,concat(name,' ',lastname) as na FROM `student` WHERE `u_group`='$g_id'";
$res=mysqli_query($conn, $sql);
?>
<div class="container">    
    <div class="row">
        <div class="col-md-2 col-xs-2">
        </div>
        <div class="col-md-8 col-xs-12">
            <h3>จำนวนครั้งขาดเรียน</h3>
            <h3>รหัสกลุ่ม <?php echo $g_id?>   ชื่อกลุ่ม <?php echo getGName($g_id)?></h3>
            <table  width="80%" border="1" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td colspan='2'>&nbsp;</td>
                    <?php 
                    foreach($arr_hsubj as $k => $v) {
                        ?>
                        <td height="250" align="center" valign="bottom"><span class="textAlignVer"><?php echo $v?></span></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td align="center"><?php echo $row['code']?></td>
                        <td ><?php echo $row['na']?></td>
                        <?php
                        for ($i=0;$i<$countSubj;$i++){
                            ?>
                            <td align="center"><?php echo getSumMiss($row['code'],$arr_subj[$i])?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>  


        </div>
    </div>
</div>
<footer class="container-fluid text-center">
  <p>Copyright © 2018 MissedClass by Worakit Wiriyakasamongkol</p>  
</footer>
<?php
function getSumMiss($cid,$sid){
    // echo $cid."-".$sid;
    global $conn;
    $sql="SELECT sum FROM `summiss` WHERE `std_code` = '$cid' AND `subj_id` = '$sid'";
    // echo $sql;exit();
    $res = mysqli_query($conn,$sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        return $row['sum'];
    }
    else{
        return 0;
    }  
}




