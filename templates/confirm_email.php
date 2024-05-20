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
              <form action="index.php?action=<?php echo $data["action"]; if(isset($_GET["last_action"])) {echo "&last_action=".$_GET["last_action"];}  ?>" method="POST">
                <div class="orange-text text-accent-3">
                  Please Confirm Your Corporate Email Address
                </div>
                <div class="card">
                  <div class="card-content">
                  <div id="error_message" class="red-text text-accent-2">
                    <?php if (isset($data["error"])) echo $data["error"]; ?>
                  </div>
                  <table>
                    <tbody>
                      <tr>
                        <td>Email Address</td>
                        <td>:</td>
                        <td>
                          <div class="input-field">
                            <input type="email" id="email1" name="email1" required="required" value="<?php if (isset($data["email1"])) echo preg_replace('/\s+/','',$data["email1"]); ?>">
                            <label for="email1">Email Address</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Repeat Email Address</td>
                        <td>:</td>
                        <td>
                          <div class="input-field">
                            <input type="email" id="email2" name="email2" required="required" value="<?php if (isset($data["email2"])) echo preg_replace('/\s+/','',$data["email2"]); ?>">
                            <label for="email2">Repeat Email Address</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Extension Number</td>
                        <td>:</td>
                        <td>
                          <div class="input-field">
                            <input type="number" id="ext" name="ext" value="<?php if (isset($data["ext"])) echo preg_replace('/\s+/','',$data["ext"]); ?>">
                            <label for="ext">Your Phone Extension Number</label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <div class="card-action">
                    <button type="submit" value="confirmmail" name="submit" class="waves-effect waves-light btn">Confirm My Email</button>
                    <button onclick="skipEmail()" type="button" value="skip" name="skip" class="waves-effect waves-light btn">Skip</button>
                  </div>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  
    <script>
      function skipEmail() {
        var r = confirm("If You Skip, you wont be able to receive email from intranet, continue?");
        if (r == true) {
          location = "index.php?action=confirm_email&skip=true";
        }       
      }
    </script>
  </body>
</html>