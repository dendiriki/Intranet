<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <table class="bordered striped">
              <thead class="blue-grey lighten-2">
                <tr>
                  <th colspan="2"><h5>Manage Menu</h5></th>
                  <th colspan="3">
                    <a class="btn-flat" href="index.php?action=manage_menu&menuId=0"><i class="material-icons left">add</i>New Menu</a>
                  </th>
                </tr>
                <tr>
                  <th colspan="2">Menu</th>
                  <th>Link</th>
                  <th>Icon</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($menu_list as $list) {
                  ?>
                  <tr>
                    <td><?php echo $list["id"] ?></td>
                    <td><?php echo $list["name"] ?></td>
                    <td><?php echo $list["link"] ?></td>
                    <td><i class="material-icons"><?php echo $list["icon"] ?></i></td>
                    <td><button class="btn-flat" onclick="location = 'index.php?action=manage_menu&menuId='+<?php echo $list["id"] ?>"><i class="material-icons">mode_edit</i></button></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>