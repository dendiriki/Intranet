<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <div class="card-panel">
              <form action="index.php?action=<?php echo $data["action"] ?>" method="POST">
                <div class="orange-text text-accent-3">
                  Your password has been reset by admin, please set a new password
                </div>
                <div class="card">
                  <div class="card-content">
                  <div id="error_message" class="red-text text-accent-2">
                    <?php if (isset($data["error"])) echo $data["error"]; ?>
                  </div>
                  <table>
                    <tbody>
                      <tr>
                        <td>New Password</td>
                        <td>:</td>
                        <td>
                          <div class="input-field">
                            <input type="password" id="newpass1" name="newpass1" required="required">
                            <label for="newpass1">New Password</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Repeat New Password</td>
                        <td>:</td>
                        <td>
                          <div class="input-field">
                            <input type="password" id="newpass2" name="newpass2" required="required">
                            <label for="newpass2">Repeat New Password</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <div class="card-action">
                    <button type="submit" value="newpass" name="submit" class="waves-effect waves-light btn">Change My Password</button>
                  </div>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>