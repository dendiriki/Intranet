<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <?php if (isset($results['errorMessage'])) { ?>
              <div class="red-text text-darken-1 center"><?php echo $results['errorMessage'] ?></div>
            <?php } ?>
              <form action="index.php?action=login&last_action=<?php echo $last_action ?>" method="POST">
              <input type="hidden" name="login" value="true" />

              <div class="card">
                <div class="card-content">
                  <span class="card-title">Please Login</span>
                  <div class="input-field">
                    <input name="username" placeholder="Username" id="username" type="text" class="validate" required="required">
                    <label for="username">Username</label>
                  </div>
                  <div class="input-field">
                    <input name="password" id="password" type="password" class="validate" required="required">
                    <label for="password">Password</label>
                  </div>
                </div>
                <div class="card-action">
                  <button class="waves-effect waves-teal btn-flat" type="submit" value="login" name="login">
                    Log In
                  </button>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>