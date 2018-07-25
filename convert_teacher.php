<?php
/* ------------------------------------
// โอนข้อมูลจากไฟล์ลงฐานข้อมูล
// ------------------------------------
//teacher.txt to database teacher
//โอนข้อมูลจาก txt file
 * 
 CREATE TABLE`teacher` (
 `teaId` VARCHAR( 10)NOT NULL ,
 `teaName` VARCHAR( 100)NOT  NULL ,
  teaId13 varchar(15),
 PRIMARYKEY (`teaId`) 
);
 * 
 */
require_once 'config.php';
// require_once 'header.php';
header('Content-Type: text/html; charset=UTF-8');
		$count =0;
		$fopen = fopen( './file/teacher.txt',"r" );
		if ( feof ($fopen)){ exit("cannot open file") ; }
		$strsql = "insert into `teacher` values";
		while ( !feof ($fopen)) {
			$show = fgets($fopen); 
			//**********************************
			$_show= iconv('TIS-620', 'UTF-8', $show); //แปลง ansi เป็น utf-8
			$data=explode(',',$_show);
			// echo "<pre>";
			//  print_r($data);
			//  echo "</pre>";
			//  exit();
			//    echo $data[13]."-".strlen($data[13])." <br>";
			if (strlen($data[13])==15){
				$t_id=$data[13];
				$arr[] = "(".$data[0].",".$data[1].",".$t_id.")"; 
			}
			// else{
			// 	$t_id=$data[14];
			// }		      
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
			// echo $strsql;
			$res = mysqli_query($conn, $strsql);
	//		if(!$res)
	//			echo mysql_error();

			if ($res === false) { //ตรวจสอบว่า insert เข้าหรือไม่
				echo "ข้อมูลนำเข้าไม่ได้ <BR>";
				echo $strsql."<br>";
			}
			else {echo 'insert ข้อมูลจำนวน  '.$count.'  record';}
		}
		fclose($fopen);
// require_once 'footer.php';

