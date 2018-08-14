<?php
header('Content-Type: text/html; charset=UTF-8');

// echo $_SESSION['user'];
?>

<head>
<?php include_once ("head.php") ;?>
</head>
<body>
<?php 
include_once ("config.php") ;
include_once ("function.php") ;
include_once ("nevBar.php") ;

date_default_timezone_set('Asia/Bangkok');
$date=date('Y-m-d');
$n_day=date('N');
if(isset($_POST['newdate'])){
  $d=strtotime($_POST['newdate']);
  $n_day=date("N",$d);
  $date=date("Y-m-d", $d);
  // echo "Created date is " . date("Y-m-d", $d);
  // echo "n=".date("N",$d);
}
$_SESSION['user']['datenow']=$date;
// echo date("N");
// echo $_SESSION['user']['tea_name'];
$tid= $_SESSION['user']['tea_id'];
$data=getSubject($tid,$n_day);
// echo "<pre>"; print_r($data);




?>
<div class="container">    
  <div class="row">
  <div class="col-md-3 col-xs-2"></div>  

  <div class="col-md-6 col-xs-12">
    <div class="panel panel-primary text-center">
      <?php echo $_SESSION['user']['tea_name'] ?>
    </div>
    <div class="panel panel-primary text-center">
      เลือกวันที่
      <?php
      $d=date("Y-m-d");
      $d1=strtotime($d);
      // $d2=strtotime("-1 days", $d1);
      // echo date("Y-m-d",$d2);
      $arr_day=array() ;
      for ($i=1;$i<6;$i++){
        $d3=strtotime("-".$i." days", $d1); 
        $arr_day[date("Y-m-d",$d3)]=date("Y-m-d",$d3);
      }
      // print_r($arr_day);
      ?>
      <form method="post" action =''>
        <select name="newdate" id="">
          <?php echo gen_option($arr_day,$date)?>
        </select>
        <input type="submit" value="OK">
      </form>
      
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading">เลือกรายวิชา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo chDay3($date)?></div>
      <div class="panel-body">
        <?php
        foreach($data as $k => $v) {
          $chk=chkMissValue($data[$k]['sem'],$date,$data[$k]['stdGroupId'],$data[$k]['subjId']);
          if($chk!=''){
            $color='primary';
            $txt='(บันทึกข้อมูลแล้ว)';
          }else{
            $color='success';
            $txt='';
          }
          $link="checkStudent.php?subjId=".$data[$k]['subjId']."&stdGroupId=".$data[$k]['stdGroupId']
          ."&sem=".$data[$k]['sem']."&tid=".$tid;
          ?>
          <a href="<?php echo $link ?>" class="btn btn-<?php echo $color?> btn-sm btn-block"> 
              <h4>วิชา <?php echo $data[$k]['subjId'] ." ".$data[$k]['subjName'] ?> </h4>
              <h4><?php echo getGroupName($data[$k]['stdGroupId'])?></h4>
              <h4><?php echo getPeriod(substr($data[$k]['dayLearn'],2,2),'s') ." น. - "
                .getPeriod(substr($data[$k]['dayLearn'],4,2),'n')." น."?></h4>
                <?php echo "<h4 style='color:Tomato;'>".$txt."</h4>"?>
          </a>
          <?php 
        } 
        ?>    
      </div><!-- >panel-body -->
    </div>  <!-- panel panel-primary -->
    
    <table align="center">
      <tr>
        <td><a href="logout.php"><button class="btn btn-danger">logout</button></a></td>
      </tr>
    </table>

    
    </div>
  </div><!-- col-md-6 col-xs-12 -->
  </div><!-- row -->
</div><!-- container -->
<br><br>

<?php include_once ("footer.php") ?>

</body>
</html>
<?php
function getSubject($tid,$n){
    global $conn;
    $data = array();
    $sql = "SELECT * FROM `studing` WHERE `teaId`='$tid' AND substr(`dayLearn`,1,1)='$n' 
          group by   `subjId`,`stdGroupId` order by dayLearn " ;
	// echo $sql;
    $res = mysqli_query($conn,$sql) or die("Error Qeury [".$res."]");
    
    while($row = mysqli_fetch_assoc($res)) {
        $data[]=$row;
    }
    // echo mysqli_num_rows($res);
    return $data ;
}
function getGroupName($gid){
    global $conn;
    $sql="SELECT `g_name` FROM `gro` WHERE `gro_code`='$gid'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    return $row['g_name'];
}

function getPeriod($p,$a){
  global $conn;
  $sql="SELECT * FROM `period` WHERE `p_id`='$p'";
  $res = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($res);
  if ($a=='s')
    return $row['time1'];
  else if($a=='n')  
    return $row['time2'];
  else 
    return '-';  
}

function chkMissValue($sem,$date,$gr,$subj){
  global $conn;
  $sql="SELECT * FROM `std_missed` WHERE `sem`='$sem' AND `date`='$date' AND `std_group_id`='$gr' AND `subj_id`='$subj' ";
  // echo $sql;
  $res = mysqli_query($conn,$sql);
  $cnt=mysqli_num_rows($res);
  if ($cnt>0){        
    return 'xxx';
  }else{
    return '';
  }   

}