<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <?php if(isset($data["success"])) echo "<div class='light-green-text text-darken-3'>".$data["success"]."</div>"; ?>
            <div>
              <table class="bordered striped">
                <thead>
                  <tr class="blue-grey lighten-2">
                    <td colspan="3"><h5>Manage Role</h5></td>
                    <td>
                      <a class="btn-flat" href="index.php?action=manage_role&roleId=0"><i class="material-icons left">add</i> New Role</a>
                    </td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($role_list as $list) {
                    ?>
                    <tr>
                      <td><?php echo $list["id"] ?></td>
                      <td><?php echo $list["name"] ?></td>
                      <td><?php echo $list["desc"] ?></td>
                      <td><button class="btn-flat" onclick="location = 'index.php?action=manage_role&roleId=' + <?php echo $list["id"] ?>"><i class="material-icons">mode_edit</i></button></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>