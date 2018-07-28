<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'config.php';
include_once ("function.php");
// echo $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once ("head.php") ?>

<body>


<?php 
// include_once ("nevBar.php") ;
// include_once ("function.php") ;
// date_default_timezone_set('Asia/Bangkok');
// $datenow= date("Y-m-d");
// $data=getMissStudent();


?>
<style>
th{
    text-align:center;
}

</style>
<div class="container">    
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <?php
            if (isset($_POST['week'])){
                $week=$_POST['week'];
                $major=$_POST['major'];
                $level=substr($major,0,1);
                // echo $level;
                $data_week=getWeek($week);
                $start=$data_week['start_day'];
                $end=$data_week['end_day'];
                // $sum_miss_week=getDataMissWeek($start,$end);
                // $res_miss=getDataMiss();

                // $sql_miss="SELECT * FROM `summiss`  WHERE `std_code` != '0000000000'";
                // // $sql_miss="SELECT * FROM `summiss`";
                // echo $sql_miss;
                // $res_miss = mysqli_query($conn,$sql_miss);

                $sql_miss_week="SELECT m.`std_code` ,concat(s.`name`,'  ',s.lastname) as na,m.`subj_id`,count(*) as c 
                    FROM `std_missed` m
                    left join student s ON m.`std_code`=s.`code`
                    WHERE `date` BETWEEN '$start' AND '$end' 
                    AND `std_code` != '0000000000' 
                    AND substr(`std_group_id`,3,4)='$major'
                    group by `std_code`,`subj_id`";
                // echo $sql_miss_week   ; 
                $res_miss_week = mysqli_query($conn,$sql_miss_week);

            ?>
            <h3 style="text-align:center">สรุปรายชื่อนักเรียน-นักศึกษาขาดเรียน</h3>
            <h3 style="text-align:center">ระดับ <?php echo getLevel($level)?>  สาขาวิชา <?php echo getMajorName($major)?></h3>
            <h3 style="text-align:center">สัปดาห์ที่ <?php echo $week?> </h3>
            <h5 style="text-align:center">ระหว่างวันที่ <?php echo chDay3($start)?> - <?php echo chDay3($end)?></h5>
            <table align="center" border='1' cellpadding="0" cellspacing="0">
                <tr>
                    <th>ลำดับ</th>
                    <th>รหัส</th>
                    <th>ชื่อ-สกุล</th>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>รวม<br>ทุกสัปดาห์</th>
                </tr>
                <?php
                $num=0;
                while($row = mysqli_fetch_assoc($res_miss_week)) {
                    $num++;
                ?>
                <tr>
                    <td align="center"><?php echo $num ?></td>
                    <td><?php echo $row['std_code'] ?></td>
                    <td><?php echo $row['na'] ?></td>
                    <td><?php echo $row['subj_id'] ?></td>
                    <td><?php echo getSubjectName($row['subj_id']) ?></td>
                    <td align="center"><?php getSumMiss($row['std_code'],$row['subj_id'])?></td>
                </tr>
                <?php
                }
                ?>

            </table>  
            <?php
            }else{
            ?>  
                <div style="text-align:center">
                <h3>เลือกสัปดาห์ที่รายงาน</h3>
                <form action="#" method="post">
                    <select name="week" id="">
                        <?php 
                        genOptionWeek(); 
                        ?>
                    </select>
                <hr>
                <h3>เลือกสาขาวิชา</h3>
                    <select name="major" id="">
                        <?php 
                        genOptionMajor(); 
                        ?>
                    </select>
                    <br><br>
                    <input type="submit" value="OK">
                </form>
                </div>

            <?php
            }
            ?>
            </div>
        </div>
    </div><br>

    
</div><br>



<script>

</script>

</body>
</html>
<?php

function genOptionWeek(){
    global $conn;
    $sql="select * from week";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)) {
        $k=$row['week_no'];
        $v="สัปดาห์ที่ ".$k." -- ( ".chDay3($row['start_day'])."-".chDay3($row['end_day'])." )";
        echo "<option value='".$k."'>".$v."</option>";
    }
}
function genOptionMajor(){
    global $conn;
    $sql="select * from major order by depcode";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)) {
        $k=$row['depcode'];
        $v=$row['depcode']." --> ".$row['depname'];
        echo "<option value='".$k."'>".$v."</option>";
    }
}

function getWeek($week){
    global $conn;
    $sql="select * from week where week_no='$week' ";
    $res = mysqli_query($conn,$sql);
    return mysqli_fetch_assoc($res);
}

// function getDataMissWeek($start,$end){
//     global $conn;
//     $sql="SELECT std_code,count(*)	as c
//     FROM `std_missed` m
//     WHERE `date` BETWEEN '$start' AND '$end' 
//     group by m.`std_code`,m.`subj_id`";
//     $res = mysqli_query($conn,$sql);
//     return mysqli_fetch_assoc($res);
// }

function getSubjectName($id){
    global $conn;
    $sql="SELECT * FROM `subject` WHERE `subjId` = '$id'";
    // echo $sql;
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    return $row['subjName'];
}

function getSumMiss($std,$subj){
    global $conn;
    $sql="SELECT * FROM `summiss` WHERE `std_code`='$std' AND `subj_id`='$subj'  ";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    echo $row['sum'];
}

function getLevel($s){
    if ($s==2){
        return "ปวช.";
    }
    if ($s==3){
        return "ปวส.";
    }
}

function getMajorName($s){
    global $conn;
    $sql="SELECT * FROM `major` WHERE `depcode`='$s'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    echo $row['depname'];
}