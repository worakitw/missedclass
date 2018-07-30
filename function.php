<?php
include_once ("config.php");

//แปลง 2011-03-08 to 8 มีนาคม 2554
function chDay3($s){
	$d=explode("-",$s);
	//print_r($d);
	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
	$y=$d[0]+543;
	//$da=ins0($d[0]);
	return del0($d[2])." ".$arr_month[$d[1]-1]." ".$y;
}
//ตัดเลข 0 ถ้าไม่ถึง 10 // 08 >> 8
function del0($s){
    if ($s<10){
        $r=substr($s,1);
    }else{
        $r=$s;
    }
    return $r;
}

function getMissStudent($d,$sub,$t,$g){
    global $conn;
    $data = array();
    $sql="SELECT * FROM `std_missed` WHERE `date`='$d' AND `subj_id`='$sub' AND `tid`='$t' AND `std_group_id`='$g'";
    // echo $sql;
    $res = mysqli_query($conn,$sql) or die("Error Qeury [".$res."]");
    
    while($row = mysqli_fetch_assoc($res)) {
        $data[]=$row;
    }
    // echo mysqli_num_rows($res);
    return $data ;
}

function getNameStudent($id){
    if ($id=='0000000000'){
        return 'ไม่มีนักเรียนขาดเรียน';
    }
    else{
        global $conn;
        $sql="SELECT concat(`name`,'  ',`lastname`) as name FROM `student` WHERE `code`='$id'";
        $res = mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($res);
        return $row['name'];
    }
}

function getGName($id){
    global $conn;
    $sql="SELECT `g_name` FROM `gro` WHERE `gro_code`='$id'";
    $res = mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['g_name'];
}

function gen_option($sql, $def) {
    global $conn;
    if (is_array($sql)) {
        foreach ($sql as $k => $v) {
            $sel = $k == $def ? ' selected="selected"' : '';
            $a[] = "<option value=\"$k\"{$sel}>$v</option>";
        }
    } else {
        $res = mysqli_query($conn, $sql);
        $a = array();
        // $a[0] = "<option value="1001">00 - ไม่มีนักเรียนขาดเรียน</option>";
        while ($row = mysqli_fetch_row($res)) {
            $sel = $row[0] == $def ? ' selected="selected"' : '';
            $a[] = "<option value=".$row[1]." ".$sel.">".$row[1]." - ".$row[2]." ".$row[3]."</option>";
        }
    }
    return implode('', $a);
}
function getSubjName($id){
    global $conn;
    $sql="SELECT `subjName`  FROM `subject` WHERE `subjId`='$id'";
    $res = mysqli_query($conn,$sql);
    if (mysqli_num_rows($res) > 0) {
      $row=mysqli_fetch_assoc($res);
      return $row['subjName'];
    }else{
      return '';
    }
}
function getTeaName($id){
    global $conn;
    $sql="SELECT `tea_name`  FROM `teacher` WHERE `tea_id`='$id'";
    $res = mysqli_query($conn,$sql);
    if (mysqli_num_rows($res) > 0) {
      $row=mysqli_fetch_assoc($res);
      return $row['tea_name'];
    }else{
      return '';
    }
}