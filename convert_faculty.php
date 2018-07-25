<?php
/* ------------------------------------
// โอนข้อมูลจากไฟล์ลงฐานข้อมูล
// ------------------------------------
//faculty.txt to table depart
//โอนข้อมูลจาก txt file
 * 
 CREATE TABLE `depart` (
 `depId` VARCHAR( 10) NOT NULL ,
 `depName` VARCHAR( 100) NOT NULL ,
 PRIMARY KEY (`depId`) 
) ENGINE=MYISAM ;
 * 
 */
require_once 'config.php';
// require_once 'header.php';

		$count =0;
		$fopen = fopen( './file/faculty.txt',"r" );
		if ( feof ($fopen)){ exit("cannot open file") ; }
		$strsql = "insert into `depart` values";
		while ( !feof ($fopen)) {
			$show = fgets($fopen); 
			//**********************************
			//$_show= iconv('TIS-620', 'UTF-8', $show); //แปลง ansi เป็น utf-8
			$data=explode(',',$show);
			$status='"s"';

 /*
                     echo "<pre>";
                      print_r($data);
                      echo "</pre>";
                      exit();
 */
                        $arr[] = "(".$data[0].",".$data[1].")";       
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
			$res = mysqli_query($conn, $strsql);
	//		if(!$res)
	//			echo mysql_error();

			if ($res === false) { //ตรวจสอบว่า insert เข้าหรือไม่
				echo "ข้อมูลนำเข้าไม่ได้ <BR>";
				//echo $strsql."<br>";
			}
			else {echo 'insert ข้อมูลจำนวน  '.$count.'  record';}
		}
		fclose($fopen);


// require_once 'footer.php';

