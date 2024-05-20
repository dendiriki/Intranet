<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    
    <div class="section blue">
      <h5 class="center white-text">SAP User List</h5>
    </div>
    <div class="container white">
      <div class='row'>
        <div class='col s12'>
          <?php
          if(!empty($msg)) {
            echo "<p class='center ".$msg["class"]."'>".$msg["text"]."</p>";
          }
          ?>
        </div>
        <div class='col s12'>
          <table class="striped bordered table-ticket">
            <thead>
              <tr class="hide-on-med-and-down blue darken-1 white-text">
                <th>Username</th>
                <th>Name</th>
                <th>Unlock Account</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($user_list)) {
                  foreach($user_list as $ulist) {
                    ?>
              <tr><td><?php echo $ulist["BNAME"]; ?></td><td><?php echo htmlspecialchars($ulist["NAME_TEXT"]); ?></td><td><a class='btn btn-flat btn-small' href="?action=sap_user&reset=<?php echo $ulist["BNAME"]; ?>"><i class="material-icons">&#xE898;</i></a></td></tr>
                    <?php
                  } 
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>          
    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
