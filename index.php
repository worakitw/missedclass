<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Missed Class Student</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="js/jquery.js"></script>	
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <script src="js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<!-- <div class="jumbotron">
  <div class="container text-center">
    <h1>Online Store</h1>      
    <p>Mission, Vission & Values</p>
  </div>
</div> -->

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
        <li class="active"><a href="#">Home</a></li>
        <li><a href="re_01.php">รายงานการขาดเรียน</a></li>
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
    <?php 
    echo "aa".$_SESSION['user'];
    if (!isset($_SESSION['user'])){
      ?>
      <div class="col-md-4 col-xs-12">
        <div class="panel panel-primary">
          <div class="panel-heading">LOGIN</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-3 col-xs-1"></div>
              <div class="col-sm-6 col-xs-10">
                <img src="./img/login.gif" class="img-rounded" alt="Cinque Terre" width="100%" >
              </div>
            </div>

            <form action="processLogin.php" method="post">
              <div class="form-group">
                <label for="uname">username:</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
              </div><br>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button><br><br>
            </form>
            login ด้วยรหัสประชาชน 13 หลัก ทั้ง username และ password
            หรือ login ด้วยรหัสครูตัดเกรด 7 หลัก
          </div><!-- panel-body -->
        </div><!-- panel panel-primary -->
      </div>
      <?php
    }else{
      header('Location: selectSubject.php');
    }
    ?>
  </div>
</div><br>
</div><br><br>

<footer class="container-fluid text-center">
  <p>Online Store Copyright</p>  
</footer>

</body>
</html>
