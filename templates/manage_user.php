<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">       
          <div class="col s12">
            <div class="card-panel">
            <?php if (isset($data["success"])) echo "<div class='green-text'>" . $data["success"] . "</div>"; ?>
              <table class="bordered striped table-ticket">
                <thead class="blue-grey lighten-4">
                  <tr>
                    <th colspan='2'><h5>Manage User</h5></th>
                    <th colspan='2'>
                      <a href="index.php?action=manage_user&userId=0" class="waves-effect waves-teal btn-flat"><i class="material-icons left">add</i> New User</a>
                    </th>
                  </tr>
                  <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Reset</th>
                    <th>Role</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($user_list as $list) {
                    ?>
                    <tr>
                      <td><?php echo $list["username"] ?></td>
                      <td><?php echo $list["name"] ?></td>
                      <td><button class="waves-effect waves-teal btn-flat" onclick="openDialogResetPassword('<?php echo $list["username"] ?>')"><i class="material-icons">refresh</i></button></td>
                      <td><button class="waves-effect waves-teal btn-flat" onclick="manageRole('<?php echo $list["username"] ?>')"><i class="material-icons">extension</i></button></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>  
        </div>
      </div>
    </div>    

    <div class="modal" id="modal-reset-pass">
      <div class="modal-content">
      <h4>Reset Password</h4>
        <p>
          Please enter new password
        </p>
        <input type='hidden' name='username' id='dlg-username' value=''>
        <p><input type="password" name='password' id="dlg-password"></p>
        <p>
          <input type="checkbox" class="filled-in" id="filled-in-box" onclick='showPassword()' />
          <label for="filled-in-box">Show Password</label>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-flat" onclick="resetPassword()">Yes</button>
        <button type="button" class="btn-flat modal-close">No</button>
      </div>
    </div>

    <?php include 'common/footer.php' ?>
    <script>
      function showPassword() {
        var x = document.getElementById("dlg-password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
      
      function openDialogResetPassword(userid) {
        $("#dlg-username").val("");
        $("#dlg-username").val(userid);
        $('#modal-reset-pass').modal('open');
      }

      function resetPassword() {
        var username = $("#dlg-username").val();
        var password = $("#dlg-password").val();
        if (password.length > 0) {
          $.ajax({
            type: "POST",
            url: "index.php?action=manage_user&ajax_reset_pass=true",
            crossDomain: true,
            cache: false,
            data: {username: username, password: password},
            success: function (data) {
              var obj = $.parseJSON(data);
              if (obj.status == "ok") {
                $("#dlg-username").val("");
                $("#dlg-password").val("");
                Materialize.toast('Password has been Reset', 4000);
                $('#modal-reset-pass').modal('close');
              } else {
                $("#dlg-username").val("");
                $("#dlg-password").val("");
                Materialize.toast(obj.msg, 4000);
              }
            }
          });
        }
      }

      function manageRole(userid) {
        location = "index.php?action=manage_user&userId=" + userid;
      }

    </script>
  </body>
</html>