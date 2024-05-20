<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">       
          <div class="col s12">
            <div>
              <form action="?action=manage_user&userId=<?php if (isset($data["user"])) {echo $data["user"]["username"];} else {echo "0";} ?>" method="post" enctype="multipart/form-data">
                <div class="card">
                  <div class="card-content">
                    <span class="card-title">
                      <?php echo $data["action"]; ?>
                    </span>
                    <?php if (isset($data["error"])) echo "<div class='red-text'>" . $data["error"] . "</div>"; ?>
                    <?php if (isset($data["success"])) echo "<div class='cyan-text'>" . $data["success"] . "</div>"; ?>
                    <input type="hidden" name="id" value="<?php if (isset($data["user"])) echo $data["user"]["username"]; ?>"/>
                    <div class="row">
                      <div class="input-field col m6 s12">
                        <select name="company" id="company">
                          <option value="" disabled <?php if (!isset($data["user"])) echo "selected"; ?>>Choose Company</option>
                          <option value="01" <?php if (isset($data["user"])) if($data["user"]["company"] == "01") echo "selected"; ?>>P.T. ISPAT INDO</option>
                          <option value="02" <?php if (isset($data["user"])) if($data["user"]["company"] == "02") echo "selected"; ?>>P.T. ISPAT WIRE PRODUCTS</option>
                          <option value="04" <?php if (isset($data["user"])) if($data["user"]["company"] == "04") echo "selected"; ?>>P.T. ISPAT PANCA PUTERA</option>
                          <option value="05" <?php if (isset($data["user"])) if($data["user"]["company"] == "05") echo "selected"; ?>>P.T. ISPAT BUKIT BAJA</option>
                        </select>
                      </div>
                      <div class="input-field col m4 s12">
                        <input name="payroll" type="text" id="payroll" value="<?php if (isset($data["user"])) echo $data["user"]["payroll"]; ?>" <?php if (isset($data["user"])) echo 'disabled="true"'; ?> >
                        <label for="payroll">Payroll Number</label>
                      </div>
                      <div class="input-field col m2 s12">
                        <?php if (!isset($data["user"])) { ?><button onclick="getEmployeeName()" type="button" class="btn btn-floating waves-effect pulse"><i class="material-icons">&#xE2C0;</i></button><?php } ?>
                      </div>
                      <div class="input-field col s12">
                        <input name="username" type="text" id="username" value="<?php if (isset($data["user"])) echo $data["user"]["username"]; ?>" <?php if (isset($data["user"])) echo 'disabled="true"'; ?> >
                        <label for="username">Username</label>
                      </div>
                      <div class="input-field col s12">
                        <input name="name" type="text" id="name" value="<?php if (isset($data["user"])) echo $data["user"]["name"]; ?>" <?php if (isset($data["user"])) echo 'disabled="true"'; ?>>
                        <label for="name">Name</label>
                      </div>
                      <?php if (!isset($data["user"])) { ?>
                      <div class="input-field col s12">
                        <blockquote>
                          Note :<br>
                          Password awal untuk user dengan nomor payroll adalah "<b>tanggal lahir+payroll</b>"(eg: <b>DDMMYYYYPPPP</b>)<br>
                          Password awal untuk user tanpa nomor payroll adalah "<b>welcome</b>" tanpa petik
                        </blockquote>
                      </div>
                      <?php } ?>
                    </div>                      
                  </div>
                  <?php if (!isset($data["user"])) { ?>
                  <div class="card-action">
                    <input type="submit" value="save" name="save" class="btn-flat waves-effect">
                    <button type="button" value="cancel" name="cancel" class="btn-flat waves-effect" onclick="location = 'index.php?action=manage_user'">CANCEL</button>
                  </div>
                  <?php } ?>
                </div>
              </form>
              <br>
              <?php if (isset($data["user"])) { ?>
                <div class="card">
                  <div class="card-content">
                    <div class="card-title">
                      User Role
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                        <select id="role-list">
                          <option value="" disabled selected>Choose Role</option>
                          <?php
                          if (isset($data["role_list"])) {
                            foreach ($data["role_list"] as $role_list) {
                              ?>
                              <option value="<?php echo $role_list["id"] ?>"><?php echo $role_list["name"] . " - " . $role_list["desc"] ?> </option>
                            <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6">
                        <button type="button" onclick="addRole('<?php if (isset($data["user"])) echo $data["user"]["username"]; ?>')" class="btn waves-effect waves-teal">
                          <i class="material-icons">add</i>
                        </button>
                      </div>
                    </div>
                    <table class="striped">
                      <tbody>
                        <?php
                        if (isset($data["role"])) {
                          foreach ($data["role"] as $role) {
                            ?>
                            <tr>
                              <td><?php echo $role["name"]; ?></td>
                              <td><?php echo $role["desc"]; ?></td>
                              <td><button onclick="deleteRole('<?php if (isset($data["user"])) echo $data["user"]["username"]; ?>', '<?php echo $role["id"]; ?>')" class="btn-flat"><i class="material-icons">delete</i></button></td>
                            </tr>
                            <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
<?php } ?>
            </div>
          </div>  
        </div>
      </div>
    </div>    

    <!--div class="modal" id="modal-reset-pass">
      <div class="modal-content">
        <h4>Reset Password</h4>
        <p>
          Please enter new password
        </p>
        <input type='hidden' name='username' id='dlg-username' value=''>
        <input type="password" name='password' id="dlg-password">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-flat" onclick="resetPassword()">Yes</button>
        <button type="button" class="btn-flat modal-close">No</button>
      </div>
    </div-->

<?php include 'common/footer.php' ?>
    <script>
      $(document).ready(function(){
        $('select').material_select();
      });
      
      function deleteRole(username, role_id) {
        location = "index.php?action=manage_user&deleteRole=true&userId=" + username + "&roleId=" + role_id;
      }

      function addRole(username) {
        var role_id = $("#role-list").val();
        location = "index.php?action=manage_user&addRole=true&userId=" + username + "&roleId=" + role_id;
      }
      
      function getEmployeeName() {
        $("#name").val("");
        var emp_no = $("#payroll").val();
        var comp_no = $("#company").val();
        if(emp_no.length > 0 && comp_no != null) {
          var comp_txt = "";
          if(comp_no == "01") {
            comp_txt = "IND";
          } else if(comp_no == "02") {
            comp_txt = "IWP";
          } else if(comp_no == "04") {
            comp_txt = "IPP";
          } else if(comp_no == "05") {
            comp_txt = "IBB";
          }
          var suggested_username = comp_txt+emp_no;
          $("#username").focus();
          $("#username").val(suggested_username);
          $.ajax({
            type: "POST",
            url: "index.php?action=manage_user&ajax_get_name=true",
            crossDomain: true,
            cache: false,
            data: {emp_no:emp_no,comp_no:comp_no},
            success: function (data) {
              var obj = $.parseJSON(data);
              if(obj.status == "ok") {                
                $("#name").focus();
                $("#name").val(obj.name);
              } else {
                $("#payroll").focus();
                Materialize.toast(obj.msg, 4000);
              }
            }
          });
        } else {
          $("#payroll").focus();
          Materialize.toast("Please Fill Company and Payroll Number", 4000);
        }
      }
    </script>
  </body>
</html>