<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">        
          <div class="col s12">
            <div class="card">
              <div class="card-content">
                <h5 class="card-title center">
                  My Profile
                </h5>
                <table class="bordered">
                  <tbody>
                    <tr>
                      <td>Username</td>
                      <td>:</td>
                      <td><?php echo $data["username"] ?></td>
                      <td rowspan="8"><img width="300" src="viewimage.php?company=<?php echo $data["employee"]->company;  ?>&department=<?php echo $data["employee"]->department; ?>&img=<?php echo $data["employee"]->payroll; ?>.jpg"></td>
                    </tr>
                    <tr>
                      <td>Payroll Number</td>
                      <td>:</td>
                      <td><?php echo $data["employee"]->payroll ?></td>
                    </tr>
                    <tr>
                      <td>Department</td>
                      <td>:</td>
                      <td><?php echo $data["employee"]->department ?></td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td>:</td>
                      <td><?php echo $data["employee"]->name ?></td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td>:</td>
                      <td><?php echo $data["employee"]->address ?></td>
                    </tr>
                    <tr>
                      <td>Phone Number</td>
                      <td>:</td>
                      <td><?php echo $data["employee"]->phone ?></td>
                    </tr>
                    <tr>
                      <td>Extension Number</td>
                      <td>:</td>
                      <td><?php echo $data["ext"] ?></td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td><?php echo $data["email"] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-action">
                <button id="change_pwd" class="btn btn-flat" data-target="dialog_pwd" >Change My Password</button>
                <button id="change_tlp" class="btn btn-flat" data-target="dialog_telp" >Change My Extension</button>
                <a href="index.php?action=confirm_email&last_action=personal_data" class="btn btn-flat">Change My Email</a>
              </div> 
            </div>
          </div>  
        </div>
      </div>
    </div>
    
    <dialog class="modal" id="dialog_pwd">
      <div class="modal-content">
        <div class="red-text" id="dialog-alert"></div>
        <div class="input-field">
          <input class="validate" type="password" id="oldpass" placeholder="Password Lama">
          <label for="oldpass">Password Lama</label>
        </div>
        <div class="input-field">
          <input class="validate" type="password" id="newpass1" placeholder="Password Baru">
          <label for="newpass1">Password Baru</label>
        </div>
        <div class="input-field">
          <input class="validate" type="password" id="newpass2" placeholder="Ulangi Password Baru">
          <label for="newpass2">Ulangi Password Baru</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat" onclick="savePassword()">CONFIRM</button>
        <button type="button" class="btn btn-flat modal-close">CANCEL</button>
      </div>
    </dialog>
    
    <dialog class="modal" id="dialog_telp">
      <div class="modal-content">
        <div class="red-text" id="dialog-alert-telp"></div>
        <div class="input-field">
          <input class="validate" type="text" id="telp" placeholder="No Telp/Extension">
          <label for="telp">Extension</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-flat" onclick="saveExt()">CONFIRM</button>
        <button type="button" class="btn btn-flat modal-close">CANCEL</button>
      </div>
    </dialog>
    
    <?php include 'common/footer.php' ?>
    
    <script>
      function savePassword() {
        var oldpass = $("#oldpass").val();
        var newpass1 = $("#newpass1").val();
        var newpass2 = $("#newpass2").val();
        $.ajax({
          type: "POST",
          url: "index.php?action=personal_data&ajax_change_pass=true",
          crossDomain: true,
          cache: false,
          data: {oldpass: oldpass, newpass1: newpass1, newpass2: newpass2},
          success: function (data) {
            var obj = $.parseJSON(data);
            if (obj.status == "ok") {
              $("#dialog-alert").empty();
              Materialize.toast('Your Password Has Changed', 4000)
              $('#dialog_pwd').modal('close');
            } else {
              $("#dialog-alert").empty();
              $("#dialog-alert").append(obj.msg);
            }
          }
        });
      }
      
      function saveExt() {
        var ext = $("#telp").val();
        $.ajax({
          type: "POST",
          url: "index.php?action=personal_data&ajax_change_ext=true",
          crossDomain: true,
          cache: false,
          data: {ext:ext},
          success: function (data) {
            var obj = $.parseJSON(data);
            if (obj.status == "ok") {
              $("#dialog-alert-telp").empty();
              Materialize.toast('Your Extension Has Changed', 4000)
              $('#dialog_telp').modal('close');
              location.reload();
            } else {
              $("#dialog-alert-telp").empty();
              $("#dialog-alert-telp").append(obj.msg);
            }
          }
        });
      }
    </script>
  </body>
</html>

