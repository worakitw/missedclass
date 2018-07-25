<?php
session_start();
// ------------------------------------
//  โอนข้อมูลจากไฟล์ลงฐานข้อมูล
// ------------------------------------
//group.txt to database gro
//โอนข้อมูลจาก txt file

// CREATE TABLE `gro` (
//     `gro_id` int(11) NOT NULL auto_increment,
//     `gro_code` varchar(8)  NOT NULL,
//     `g_name` varchar(80)  NOT NULL,
//     `g_job` varchar(80)  NOT NULL,
//     `g_dpart` varchar(80)  NOT NULL,
//     `g_adviser` varchar(100)  NOT NULL,
//     PRIMARY KEY  (`gro_id`)
//   )  ;

require_once 'config.php';
// require_once 'header.php';
header('Content-Type: text/html; charset=UTF-8');

if (isset($_POST['year'])){
    $year=$_POST['year'];
    $act=$_POST['act'];
    if ($act=='do' && $year !=''){
        $ch= getValidate($year);
        if ($ch==''){
            // เปิดแฟ้ม
            $count =0;
            $fopen = fopen( './file/group.txt',"r" );
            if ( feof ($fopen)){ exit("cannot open file") ; }

            while ( !feof ($fopen)) {
                $show = fgets($fopen); 
                //**********************************
                $_show= iconv('TIS-620', 'UTF-8', $show); //แปลง ansi เป็น utf-8
                $gro_data=explode(',',$_show);
                $dep='ไม่ระบุ';
            //echo '<pre>'.print_r($gro_data).'</pre>';
            //echo substr($gro_data[0],1,2)."<BR>";
            // "60310203","สชผ.2/3","ช่างเทคนิคการผลิต (สชผ.2/3)","นายมานพ  บุตรแวว",21,0,21,"1/256160310203","ผลิตชิ้นส่วนยานยนต์",""
                if (substr($gro_data[0],1,2)== $year && strlen($gro_data[8])>2){

                    $dep=c_dep($gro_data[8]);

                    $strsql = "insert into `gro` values(\"\",".$gro_data[0].",".$gro_data[2].",".$gro_data[8].",'".$dep."',".$gro_data[3].");";   /// คัดลอกข้อมูล

                    //echo '<br>';
                    //echo $strsql.'<br>';
                    $res = mysqli_query($conn, $strsql);
                    
                    if ($res == false) { //ตรวจสอบว่า insert เข้าหรือไม่
                        echo "ข้อมูล".$gro_data[0]."นำเข้าไม่ได้ <BR>";
                        echo $strsql."<br>";
                    }
                    else {$count+=1;	}
                    if ( feof ($fopen)){ break ; }
                }
            }

            fclose($fopen);
            echo 'insert ข้อมูลจำนวน  '.$count.'  record';
        }//close if ch=''
        if ($ch!=''){
            echo '<FONT SIZE="" COLOR="red">มีข้อมูลกลุ่มการเรียนของนักเรียนปีการศึกษานี้แล้ว</FONT>';
        }
    }// close if(act=do)
}
else {echo "เลือกปีสองตัวแรกที่จะทำการนำเข้าข้อมูล";}
?>

<TABLE width="60%" border='0' align='center'>
<tr align='center'><td><H2>นำเข้าข้อมูลกลุ่มการเรียน</H2>
<fieldset><legend> เลือกปีขึ้นต้นของกลุ่มการเรียน</legend>
<FORM METHOD=POST ACTION="">
	รหัสกลุ่ม ปี :
	<SELECT NAME="year">
		<OPTION VALUE=""> 

        <?php 
        $s=58;
        for ($i=$s;$i<=$s+5;$i++ ){
        ?>    
		<OPTION VALUE="<?php echo $i ?>"> <?php echo $i ?>
        <?php
        }
        ?>
	</SELECT><BR><BR>
	<INPUT TYPE="hidden" NAME="act" value="do">
	<INPUT TYPE="submit" value=' นำเข้าข้อมูล  '>
</FORM>
หมายเหตุ <FONT SIZE="" COLOR="#FF0099">ต้องมีไฟล์ข้อมูลกลุ่มการเรียน <FONT SIZE="" COLOR="#FF0000">group.txt</FONT> อยู่ใน server แล้ว</FONT>

</fieldset>	
</td></tr>
</TABLE>
<?php //require_once 'footer.php'; -->


function getValidate($y){
	global $conn;
	$sql = "SELECT * FROM gro where substr(gro_code,1,2)='".$y."';" ;
	// echo $sql;
    $res = mysqli_query($conn,$sql);
    if (mysqli_num_rows($res) > 0) {
	    return mysqli_num_rows($res);
    }
    else{
        return '';
    }
}

function c_dep($jj){
    $length=strlen($jj);
    $j=  substr($jj, 1, $length-2);

    if ($j=="ยานยนต์"){
        $r= "แผนกวิชาช่างยนต์" ;
    }
    else if ($j=="เทคนิคยานยนต์"){
        $r= "แผนกวิชาช่างยนต์" ;
    }
    else if ($j=="เครื่องมือกล"){
        $r= "แผนกวิชาช่างกลโรงงาน" ;
    }
    else if ($j=="แม่พิมพ์โลหะ"){
        $r= "แผนกวิชาช่างกลโรงงาน" ;
    }
    else if ($j=="เชื่อมโลหะ"){
        $r= "แผนกช่างเชื่อม" ;
    }
	else if ($j=="ผลิตภัณฑ์"){
        $r= "แผนกช่างเชื่อม" ;
    }
	else if ($j=="เทคโนโลยีงานเชื่อมโครงสร้างโลหะ"){
        $r= "แผนกช่างเชื่อม" ;
    }
    else if ($j=="เทคนิคการเชื่อมอุตสาหกรรม"){
        $r= "แผนกช่างเชื่อม" ;
    }
    else if ($j=="ติดตั้งไฟฟ้า"){
        $r= "แผนกช่างไฟฟ้า" ;
    }
    else if ($j=="เครื่องกลไฟฟ้า"){
        $r= "แผนกช่างไฟฟ้า" ;
    }
    else if ($j=="ไฟฟ้ากำลัง"){
        $r= "แผนกช่างไฟฟ้า" ;
    }
	else if ($j=="ไฟฟ้าควบคุม"){
        $r= "แผนกช่างไฟฟ้า" ;
    }
    else if ($j=="ระบบโทรคมนาคม"){
        $r= "แผนกช่างอิเล็กทรอนิกส์" ;
    }
    else if ($j=="อิเล็กทรอนิกส์"){
        $r= "แผนกช่างอิเล็กทรอนิกส์" ;
    }
    else if ($j=="อิเล็กทรอนิกส์อุตสาหกรรม"){
        $r= "แผนกช่างอิเล็กทรอนิกส์" ;
    }
    else if ($j=="เทคนิคคอมพิวเตอร์"){
        $r= "แผนกช่างอิเล็กทรอนิกส์" ;
    }
    else if ($j=="ก่อสร้าง"){
        $r= "แผนกช่างก่อสร้าง" ;
    }
    else if ($j=="เทคนิคการก่อสร้าง"){
        $r= "แผนกช่างก่อสร้าง" ;
    }
    else if ($j=="สถาปัตยกรรม"){
        $r= "แผนกสถาปัตยกรรม" ;
    }
    else if ($j=="เทคนิคสถาปัตยกรรม"){
        $r= "แผนกสถาปัตยกรรม" ;
    }
    else if ($j=="ออกแบบและเขียนแบบการผลิต"){
        $r= "แผนกช่างเขียนแบบเครื่องกล" ;
    }
    else if ($j=="เขียนแบบเครื่องกล"){
        $r= "แผนกช่างเขียนแบบเครื่องกล" ;
    }
    else if ($j=="ซ่อมบำรุงเครื่องจักรกล"){
        $r= "แผนกช่างเทคนิคอุตสาหกรรม" ;
    }
	else if ($j=="ซ่อมบำรุงอุตสาหกรรม"){
        $r= "แผนกช่างเทคนิคอุตสาหกรรม" ;
    }
    else if ($j=="ติดตั้งและบำรุงรักษา"){
        $r= "แผนกช่างเทคนิคอุตสาหกรรม" ;
    }
    
    else if ($j=="อุตสาหกรรมการผลิต"){
        $r= "แผนกช่างเทคนิคอุตสาหกรรม" ;
    }
    else if ($j=="เทคนิคการหล่อ"){
        $r= "แผนกช่างเทคนิคการหล่อ" ;
    }
    else if ($j=="เมคคาทรอนิกส์"){
        $r= "แผนกช่างแมคคาทรอนิกส์" ;
    }
    else if ($j=="เทคโนโลยีสารสนเทศ"){
        $r= "แผนกเทคโนโลยีสารสนเทศ" ;
    }
    else{
        $r= "ไม่ระบุ";
    }
   
    return $r;
}


