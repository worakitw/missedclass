<?php
session_start();
/* ------------------------------------
// โอนข้อมูลจากไฟล์ลงฐานข้อมูล
// ------------------------------------
//studing.txt จากส่งออกข้อมูลตารางนักเรียนใน std2011
//โอนข้อมูลจาก txt file
 * 
 CREATE TABLE`studing` (
 `stuId` INT AUTO_INCREMENT PRIMARY KEY ,
 `sem` VARCHAR( 10)NOT NULL ,
 `subjId` VARCHAR( 10)NOT NULL ,
 `subjName` VARCHAR( 100)NOT NULL ,
 `stdGroupId` VARCHAR( 10)NOT NULL ,
 `dayLearn` VARCHAR( 15)NOT NULL ,
 `teaId` VARCHAR( 10)NOT NULL ,
 `teaName` VARCHAR( 100)NOT NULL 
);

 * 
 */
// require_once 'header.php';
require_once 'config.php';
header('Content-Type: text/html; charset=UTF-8');
		$count =0;
		$fopen = fopen( './file/studing.txt',"r" );
		if ( feof ($fopen)){ exit("cannot open file") ; }
		$strsql = "insert into `studing` values";
		while ( !feof ($fopen)) {
			$show = fgets($fopen); 
			//**********************************
			$_show= iconv('TIS-620', 'UTF-8', $show); //แปลง ansi เป็น utf-8
			$data=explode(',',$_show);
/* 
                     echo "<pre>";
                      print_r($data);
                      echo "</pre>";
                      exit();
*/
            $arr[] = "('',$data[0],$data[1],$data[8],$data[2],$data[3],$data[9],$data[7])";       
		}
		if (!$arr){
			echo "<FONT COLOR='red'>ไม่มีข้อมูล</FONT>"; 
		}else{
			foreach ($arr as $k => $v){
				$ex=explode(',',$v);
				$count+=1;	
			}
			$std=implode(',',$arr);
			$strsql .=$std;
			//echo $strsql;
			$res =  mysqli_query($conn, $strsql);
			if(!$res)
				echo mysql_error();

			if ($res === false) { //ตรวจสอบว่า insert เข้าหรือไม่
				echo "ข้อมูลนำเข้าไม่ได้ <BR>";
				echo $strsql."<br>";	
			}
			else {echo 'insert ข้อมูลจำนวน  '.$count.'  record';}
		}
		fclose($fopen);


// require_once 'footer.php';

