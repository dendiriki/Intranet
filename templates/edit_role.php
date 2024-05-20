<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12 card-panel">
            <form action="?action=manage_role&roleId=<?php if (isset($data["role"])) echo $data["role"]["id"]; ?>" method="post">
              <div class="card">
                <div class="card-content">
                  <div class="card-title">
                    <?php echo $data["action"]; ?>
                  </div>
                
                  <?php if (isset($data["error"])) echo "<div class='red-text'>" . $data["error"] . "</div>"; ?>
                  <?php if (isset($data["success"])) echo "<div class='light-green-text text-darken-3'>" . $data["success"] . "</div>"; ?>
                  <input type="hidden" name="id" value="<?php if (isset($data["role"])) echo $data["role"]["id"]; ?>"/>
                  <div class="input-field">
                    <input name="name" type="text" id="name" value="<?php if (isset($data["role"])) echo $data["role"]["name"]; ?>" required="required"/>
                    <label for="name">Role Name</label>
                  </div>
                  <div class="input-field">
                    <input name="desc" type="text" id="desc" value="<?php if (isset($data["role"])) echo $data["role"]["desc"]; ?>" required="required"/>
                    <label for="desc">Description</label>
                  </div>
                </div>
                <div class="card-action">
                  <button type="submit" value="submit" name="save" class="btn-flat">SAVE</button>
                  <button type="button" value="cancel" name="cancel" class="btn-flat" onclick="location = 'index.php?action=manage_role'">CANCEL</button>
                </div>
              </div>
              <br>
              <?php if (isset($data["role"])) { ?>
                <div class="card">
                  <div class="card-content">
                    <div class="card-title">
                      Menu
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                        <select id="menu-list">
                          <?php if (isset($data["menu_list"])) {
                            foreach ($data["menu_list"] as $menu_list) {
                              ?>
                              <option value="<?php echo $menu_list["id"] ?>"><?php echo $menu_list["name"] ?></option>
      <?php }
    } ?>
                        </select>
                      </div>
                      <div class="input-field col s12 m6">
                        <button type="button" onclick="addMenuRole('<?php if (isset($data["role"])) echo $data["role"]["id"]; ?>')" class="btn waves-effect waves-teal">
                          <i class="material-icons">add</i>
                        </button>
                      </div>
                    </div>
                    <table class="striped bordered">
                      <tbody>
                        <?php
                        if (isset($data["menu"])) {
                          foreach ($data["menu"] as $menu) {
                            ?>
                            <tr>
                              <td><?php echo $menu["name"]; ?></td>
                              <td><button type="button" onclick="deleteMenuRole('<?php if (isset($data["role"])) echo $data["role"]["id"]; ?>', '<?php echo $menu["id"]; ?>')" class="btn-flat"><i class="material-icons">delete</i></button></td>
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
            </form>
          </div>
        </div>
      </div>

    </div>
<?php include 'common/footer.php' ?>  
    <script>      
      $(document).ready(function(){
        $('select').material_select();
      });
      
      function deleteMenuRole(role_id, menu_id) {
        location = "index.php?action=manage_role&deleteMenu=true&roleId=" + role_id + "&menuId=" + menu_id;
      }

      function addMenuRole(role_id) {
        //preventDefault();
        var menu_id = $("#menu-list").val();
        //alert("index.php?action=manage_role&addMenu=true&roleId=" + role_id + "&menuId=" + menu_id);
        location = "index.php?action=manage_role&addMenu=true&roleId=" + role_id + "&menuId=" + menu_id;
      }
    </script>
  </body>
</html>

