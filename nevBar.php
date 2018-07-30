<?php
session_start();
if($_SESSION['login'] !='ok'){
  header("location:index.php");
}
?>

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
        <li ><a href="adviser.php">อ.ที่ปรึกษา</a></li>
        <li><a href="stdMiss.php">รายบุคคล</a></li>
        <li ><a href="logout.php">Logout</a></li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['user']['tea_name'] ?> </li>
      </ul>
    </div>
  </div>
</nav>