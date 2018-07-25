<?php
session_start();
require_once 'config.php';

$user=$_POST['uname'];
$pass=$_POST['pwd'];

$sql = "SELECT * FROM teacher where tea_id13='".$user."' and tea_id13='$pass';" ;
	// echo $sql;
$res = mysqli_query($conn,$sql);

$sql2 = "SELECT * FROM teacher where tea_id='".$user."' and tea_id='$pass';" ;
$res2 = mysqli_query($conn,$sql2);

if (mysqli_num_rows($res) > 0) {
    $row= mysqli_fetch_assoc($res);
    $_SESSION['login']='ok';
    $_SESSION['user']=$row;
    header('Location: selectSubject.php');
}else if(mysqli_num_rows($res2) > 0){
    $row= mysqli_fetch_assoc($res2);
    $_SESSION['login']='ok';
    $_SESSION['user']=$row;
    header('Location: selectSubject.php');
}
else{

    header('Location: index.php');
}
