<!DOCTYPE html>
<html lang="en">
<?php include_once ("head.php") ?>
<body>
<style>
  h3 {
    text-align:center;
  }
</style>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><img src="./img/student3_1.PNG" alt=""></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="re_01.php">รายงานการขาดเรียน</a></li>
        <li><a href="stdMiss.php">รายบุคคล</a></li>
        <!-- <li><a href="#">Deals</a></li>
        <li><a href="#">Stores</a></li>
        <li><a href="#">Contact</a></li> -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Your Account</a></li>
        <!-- <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li> -->
      </ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-md-4"></div>  
        <div class="col-md-4 col-xs-12">
          <div class="panel panel-primary">
            <div class="panel-heading">ค้นหาการขาดเรียน รายบุคคล</div>
            <div class="panel-body">
              <h4>รหัสนักเรียน</h4>
              <form method='post' action="#">
                <input type="text" name="stdCode">
                <input type="submit" value="แสดงรายการ">
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php
    $sem='1/2561';//=====================ภาคเรียน==============
    include_once ("function.php") ;
    if (isset($_POST['stdCode'])){
      // getMiss();
      $std_code=$_POST['stdCode'];
      $std_group=getgId($std_code);
      $sql="SELECT * FROM `std_missed` 
        WHERE `std_code` = '$std_code' AND sem='$sem'";
      $res=mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) > 0) {
        ?>
        <!-- ================หัวรายการ===================== -->
        <h3 style="">รายการขาดเรียน ภาคเรียน <?php echo $sem ?><br>
          ชื่อ <?php echo getNameStudent($std_code)?> ชื่อกลุ่ม <?php echo getGName($std_group)?>
        </h3>

        <!-- ==========table แสดงผล=================== -->
        <div class="table-responsive">          
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>วันที่</th>
                <th>วิชา</th>
                <th>ครูผู้สอน</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $num=1;
              while($row = mysqli_fetch_assoc($res)){
                ?>
                <tr>
                  <td><?php echo $num++ ?></td>
                  <td><?php echo chDay3($row['date']) ?></td>
                  <td><?php echo getSubjName($row['subj_id']) ?></td>
                  <td><?php echo getTeaName($row['tid']) ?></td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <?php
      }
      else{
        ?>
        <h3>----ไม่มีข้อมูลการขาดเรียน----</h3>
        <?php
      }
    }
    ?>


    <?php
 
    ?>
    
    

  </div><br>
</div><br>

<footer class="container-fluid text-center">
  <p>Copyright © 2018 MissedClass by Worakit Wiriyakasamongkol</p>  
</footer>

</body>
</html>

<?php
function getgId($stdCode){
  global $conn;
  $sql="SELECT `std_group_id`  FROM `std_missed` WHERE `std_code`='$stdCode' ";
  $res = mysqli_query($conn,$sql);
  if (mysqli_num_rows($res) > 0) {
    $row=mysqli_fetch_assoc($res);
    return $row['std_group_id'];
  }else{
    return '';
  }
}
