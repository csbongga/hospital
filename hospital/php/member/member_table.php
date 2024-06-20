<?php
include("../conDB.php");

$sql="SELECT*FROM tbl_member";
$obj= mysqli_query($conn,$sql);
echo $obj?"แสดงข้อมูลได้":"ไม่สามารถแสดงข้อมูล".mysqli_error($conn);
?>
<h2>ข้อมูลสมาชิก</h2>
<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>รหัส</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ที่อยู่</th>
                  <th>เบอร์โทร</th>
                  <th>อีเมล</th>
                  <th>รูปภาพ</th>
                  <th>แก้ไข</th>
                  <th>ลบ</th>
                </tr>
                </thead>
                <tbody>

<?php
  while($row = mysqli_fetch_array($obj)){
?>
                <tr>
                  <td><?=$row["member_id"]?></td>
                  <td><?=$row["member_prefix"]?><?=$row["member_name"]?> <?=$row["member_lastname"]?></td>
                  <td><?=$row["member_address"]?></td>
                  <td><?=$row["member_tel"]?></td>
                  <td><?=$row["member_email"]?></td>
                  <td>
                    <img style="width:100px;" src="php/member/img/<?=$row["member_img"]?>">
                  </td>
                  <td><a href="#" class="btn_update" data1="<?=$row["member_id"]?>"  data-toggle="modal" data-target="#myModal">แก้ไข</a></td>
                  <td><a href="#" class="btn_delete" data1="<?=$row["member_id"]?>">ลบ</a></td>
                </tr>

<?php }?>
                
                </tfoot>
              </table>