<?php

session_start();
// ------------------------------------
// html/connect2.php โอนข้อมูลจากไฟล์ลงฐานข้อมูล
// ------------------------------------
//student.txt to database user
//โอนข้อมูลจาก txt file
/*
  CREATE TABLE `student` (
  std_id INT	NOT NULL AUTO_INCREMENT,
  code VARCHAR(10)	NOT NULL,
  name VARCHAR(100)	NOT NULL,
  lastname VARCHAR(100)	NOT NULL,
  u_group VARCHAR(8)	NOT NULL,
  PRIMARY KEY (std_id)
  )ENGINE=MyISAM;

 */
require_once 'config.php';
// require_once 'header.php';
header('Content-Type: text/html; charset=UTF-8');

$count = 0;
$fopen = fopen('./file/student.txt', "r");
if (feof($fopen)) {
    exit("cannot open file");
}
$strsql = "insert into `user` values";
while (!feof($fopen)) {
    $show = fgets($fopen);
//**********************************
    $_show = iconv('TIS-620', 'UTF-8', $show); //แปลง ansi เป็น utf-8
    $std_data = explode(',', $_show);

    /*                       
      echo "<pre>";
      print_r($std_data);
      echo "</pre>";
      exit();
      */

//ใช้ข้อมูล student จากข้อมูลรายบุคคล  72 รายการ===================
//โดยการ export ไฟล์ std_รหัสสถานศึกษา.dbf เป็น .txt
    /* รูปแบบ
      "2554","1","1320026101","20006","1249900184501","002","กิตติทัต","อัธยาศัย","1","08/12/2532","099","100/97","3","-","200116","00","168","45","ชัชชัย","อัธยาศัย","00","01",25000,"05","พิมล","อัธยาศัย","00","01",15000,"01","1",0,0,"ชัชชัย","อัธยาศัย",25000,"05","2548","06","210202","19","010102",1.75,"00","4821020210","48210207","นิค","พุทธ","20","2","038387181","038387181","A","1","1","1","1","เครื่องมือกลและซ่อมบำรุง","เขียนแบบเครื่องกล","20010612386","2551","1","01","1"," ","","",0," ",""," ","01","00"
     */
    if ($std_data[8]!=''){
        if ($std_data[8]=='"1"')$serName='"นาย';
        if ($std_data[8]=='"2"')$serName='"น.ส.';
        $name=$serName.substr($std_data[6],1);
    //   $ch = getValidate($std_data[44]);
    //   if (ch == '') {
        $strsql = "insert into `student` values(null,$std_data[44],$name,$std_data[7],$std_data[45])";
        // echo 'sql = '.$strsql.'<br>';
        $res = mysqli_query($conn, $strsql);
        if ($res == false) { //ตรวจสอบว่า insert เข้าหรือไม่
            echo "ข้อมูล" . $std_data[0] . "นำเข้าไม่ได้ <BR>";
            echo $strsql . "<br>";
        } else {
            $count+=1;
        }
        if (feof($fopen)) {
            break;
        }
    }
}//close while

fclose($fopen);
echo 'insert ข้อมูลจำนวน  '.$count.'  record';

// function getValidate($s) {
//    // require_once 'config.php';
//     $sql = "SELECT * FROM student where code=$s";
// //	echo $sql;
//     $res = mysql_query($sql);
//     if ($row_c = mysql_fetch_assoc($res))
//         return $row_c;
// }

