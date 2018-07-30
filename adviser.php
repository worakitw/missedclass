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

$tea_id=$_SESSION['user']['tea_id'];
$sem='1/2561';
$add='';
if (isset($_GET['act']) ){
    if ($_GET['act']=='del'){
        $id=$_GET['id'];
        delAdviser($id);
    }
    if ($_GET['act']=='add'){
        $add='OK';
    }
}
if (isset($_POST['gr'])){
    $gr=$_POST['gr'];
    addAdviser($gr,$sem,$tea_id);
}
$sql="SELECT * FROM `adviser` WHERE `tea_id`='$tea_id'";
$res=mysqli_query($conn, $sql);
?>
<div class="container">    
    <div class="row">
        <div class="col-md-3 col-xs-2">
        </div>
        <div class="col-md-6 col-xs-12">
            <?php
            if (mysqli_num_rows($res) > 0) {
                ?>    
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        กลุ่มที่ปรึกษา
                    </div>
                    <div class="panel-body">
                        <?php
                        while($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <h3>
                                <a href="missGroup.php?id=<?php echo $row['gro_id']?>" class="btn btn-default">
                                    <?php echo $row['gro_id']." => ".getGName($row['gro_id'])?>
                                </a>
                                 &nbsp;&nbsp;&nbsp; 
                                 <a href="adviser.php?act=del&id=<?php echo $row['id']?>" 
                                 class="btn btn-danger" >ลบ</a>
                            </h3>
                            <?php    
                        }
                        ?>
                        <a href="adviser.php?act=add" class="btn btn-success btn-block" >เพิ่มกลุ่มที่ปรึกษา</a>
                    </div>

                </div>
                <?php
            }
            if(mysqli_num_rows($res) == 0 || $add == 'OK'){
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        เลือกกลุ่มที่ปรึกษา 
                    </div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <select name="gr" id="">
                                <?php
                                $sql="SELECT * FROM `gro` order by gro_code";
                                echo gen_option($sql,'');
                                ?>
                            </select>
                            <input type="submit" value=" บันทึก ">
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
function addAdviser($gr,$sem,$tea_id){
    global $conn;
    $sql="Insert into adviser value('','$sem','$tea_id','$gr')";
    // echo $sql;exit();
    if (mysqli_query($conn, $sql)) {
        header('Location: adviser.php');
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function delAdviser($id){
    global $conn;
    $sql="DELETE FROM `adviser` WHERE `id`='$id'";
    if (mysqli_query($conn, $sql)) {
        // echo "Record deleted successfully";
        header('Location: adviser.php');
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}