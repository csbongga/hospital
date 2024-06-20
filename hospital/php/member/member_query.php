<?php
include("../conDB.php");
if($_GET["method"]=="showdata"){
    echo "<pre>";
    print_r($_GET);
    print_r($_POST);
    print_r($_FILES);   
    echo "</pre>";
}

//เพิ่มข้อมูล
if($_GET["method"]=="insert"){
    //echo "เพิ่มข้อมูล";
    
    if(move_uploaded_file($_FILES["member_img"]["tmp_name"],"img/".$_FILES["member_img"]["name"])){
      $member_img = $_FILES["member_img"]["name"];
    }
    else{//กรณีไม่ได้เลือกรูป
      $member_img = "nopic.png";
    }
  
  
    $sql = "INSERT INTO tbl_member(
      member_id,
      member_prefix,
      member_name,
      member_lastname,
      member_address,
      member_tel,
      member_email,
      member_img
    ) VALUES(
      '".$_POST["member_id"]."',
      '".$_POST["member_prefix"]."',
      '".$_POST["member_name"]."',
      '".$_POST["member_lastname"]."',
      '".$_POST["member_address"]."',
      '".$_POST["member_tel"]."',
      '".$_POST["member_email"]."',
      '".$member_img."'
    )";
    $obj = mysqli_query($conn,$sql);
    echo $obj?"เพิ่มข้อมูลเรียบร้อยแล้ว":"ผิดพลาด".mysqli_error($conn);
  }
?>