<?php
header('Content-Type: text/html; charset=UTF-8');

// echo $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once ("head.php") ?>

<body>


<?php 
include_once ("nevBar.php") ;
include_once ("function.php") ;
// date_default_timezone_set('Asia/Bangkok');
$datenow= $_SESSION['user']['datenow'];
$data=$_GET;

// if(isset($_GET['stdGroupId']) && isset($_GET['subjId'])){
//     // $stdGroupId=$_GET['stdGroupId'];
//     // $subjId=$_GET['subjId'];
//     // $stdGroupId=$_GET['stdGroupId'];
//     // $sem=$_GET['sem'];
//     // $tid=$_GET['tid'];
//     $data=$_GET ;
// }
$stdGroupId=$data["stdGroupId"];
$stdMiss=getMissStudent($datenow,$data['subjId'],$data['tid'],$stdGroupId);
// echo "<pre>";print_r($stdMiss);echo "</pre>";
?>

<div class="container">    
    <div class="row">
        <div class="col-md-4"></div>  
            <div class="col-md-6 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">วิชา <?php echo $data['subjId'];?> &nbsp;&nbsp; <?php echo getGName($data['stdGroupId']);?> </div>
                        <div class="panel-body">
                        <?php
                        if(!empty($stdMiss)){
                            ?>
                            <label >นักเรียนที่ขาดเรียน :</label>
                            <div>
                            <?php
                            foreach ($stdMiss as $k => $value){
                                $stdCode=$value['std_code'];
                                echo "<div>";
                                echo  $stdCode."   ";   
                                echo getNameStudent($value['std_code'])." &nbsp; &nbsp;";
                                $link="delMissStd.php?stdCode=".$stdCode."&subjId=".$value['subj_id']."&stdGroupId=".$value['std_group_id'].
                                "&sem=".$value['sem']."&tid=".$value['tid'];
                                echo "<a href='$link'>";
                                echo "<img src='./img/delete.png' class='img-circle' width='30px'>";  
                                echo "</a></div>";  
                            }
                            ?>
                            <a href="selectSubject.php">
                            <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('ข้อมูลถูกต้อง')">ยืนยันข้อมูล</button>
                            </a>
                            <hr>
                          
                        </div>     
                        <?php
                        }
                        ?>  
                        <!-- //============================== -->
                        <form action="addStudent.php" method="post" >
                        <!-- <input type="text" id=stdcode> -->
                            <input type="hidden" name="sem" value="<?php echo $_GET['sem']?>">
                            <input type="hidden" name="stdGroupId" value="<?php echo $_GET['stdGroupId']?>">
                            <input type="hidden" name="subjId" value="<?php echo $_GET['subjId']?>">
                            <input type="hidden" name="tid" value="<?php echo $_GET['tid']?>">

                        <label for="std">เลือกนักเรียน:</label>
                        <select class="form-control" id="std" name="std_code">
                        <?php
                        $sql="SELECT * FROM `student` WHERE `u_group`='$stdGroupId'";
                        $res = mysqli_query($conn, $sql);
                        // echo $sql;
                        ?>
                        <option value=""></option>
                        <option value="0000000000">ไม่มีนักเรียนขาดเรียน</option>
                        <?php
                        while ($row = mysqli_fetch_row($res)) {
                            echo "<option value=".$row[1]." ".$sel.">".$row[1]." - ".$row[2]." ".$row[3]."</option>";
                        }
                        ?>
                        
                        </select>
                        <button type="submit" class="btn btn-success btn-block">บันทึก</button>                        
                        </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>

    <table align="center">
      <tr>
        <td><a href="selectSubject.php"><button class="btn btn-danger btn-lg">
            <span class="glyphicon glyphicon-arrow-left"></span> Back</button></a></td>
      </tr>
    </table>
</div><br>



<script>
$(document).ready(function(){
    // $("#std").change(function(){
    //     // $("#test").hide();
    //     let a=$('#std').val();
    //     // $('#stdcode').val(a);
    //     // text="<input type='text' value='"+a+"'>"+a;
    //     // $("form").append(text);
    //     $.get("addStudent.php?code="+a, function(data, status){
    //     alert("Data: " + data + "\nStatus: " + status);
    // });
    // });
});
</script>
<?php include_once ("footer.php") ?>
</body>
</html>