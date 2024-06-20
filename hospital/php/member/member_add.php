<h2>เพิ่มข้อมูลสมาชิก</h2>
            <form id="form_add" enctype="multipart/form-data" class="form-horizontal" >
            <div class="box-body">
            <div class="form-group">
              <label class="control-label col-sm-3" for="member_id">รหัสสมาชิก :</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="member_id" name="member_id" placeholder="กรุณากรอกรหัสสมาชิก">
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-sm-3" for="member_perfix">คำนำหน้าชื่อ :</label>
              <div class="col-sm-4"> 
              <select class="form-control" id="member_perfix" name="member_prefix">
                  <option value="">เลือกคำนำหน้า</option>
                  <option value="นาย">นาย</option>
                  <option value="นาง">นาง</option>
                  <option value="นางสาว">นางสาว</option>
              </select>
              </div>
            </div>
          
          <div class="form-group"> 
              <label class="control-label col-sm-3" for="member_name">ชือ :</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="member_name" name="member_name" placeholder="กรุณากรอกชื่อ นามสกุล">
              </div>
            </div>

            <div class="form-group"> 
              <label class="control-label col-sm-3" for="member_lastname">นามสกุล :</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="member_lastname" name="member_lastname" placeholder="กรุณากรอกชื่อ นามสกุล">
              </div>
            </div>

          <div class="form-group"> 
              <label class="control-label col-sm-3" for="member_address">ที่อยู่ :</label>
              <div class="col-sm-5">
                  <textarea class="form-control" rows="5" id="member_address" name="member_address"></textarea>
              </div>
          </div>
          
            <div class="form-group">
              <label class="control-label col-sm-3" for="member_tel">เบอร์โทร :</label>
              <div class="col-sm-5">
                <input required type="text" class="form-control" id="member_tel" name="member_tel" placeholder="กรุณากรอกเบอร์โทร">
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-sm-3" for="member_email">อีเมล :</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="member_email" name="member_email" placeholder="กรุณากรอกอีเมล">
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-sm-3" for="member_img">รูปสมาชิก :</label>
              <div class="col-sm-5">
                <input type="file" class="form-control-file" id="member_img" name="member_img" placeholder="กรุณาเลือกรูป">
              
              </div>
            </div>
          
            <div class="form-group"> 
            <div class="col-sm-offset-3 col-sm-2">
              <button type="submit" class="btn btn-success">ตกลง</button>
            </div>
            <div class="">
              <button type="reset" class="btn btn-danger">ยกเลิก</button>
            </div>
          </div>
            </div>
          </form>
          <script>
    $(document).ready(()=>{

    //กดปุ่มตกลง
        $("#form_add").submit((e)=>{ 
            e.preventDefault(); // ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax
            var formData = new FormData($("#form_add")[0]);
            // ส่งค่าแบบ POST ไปยังไฟล์ member_add_q.php รูปแบบ ajax แบบเต็ม
            $.ajax({
                url: 'php/member/member_query.php?method=insert',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success:(data)=>{
                    alert(data);
                    //console.log(data);  // ทดสอบแสดงค่า  ดูผ่านหน้า console
                    //$("#myModal").modal('toggle');
                    $("#div_table").load("php/member/member_table.php");
                }
            }); 
        });

    });
</script>