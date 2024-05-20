<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <form action="?action=manage_menu&menuId=<?php if (isset($data["menu"])) echo $data["menu"]["id"]; ?>" method="post">
              <div class="card">
                <div class="card-content">
                  <div class="card-title">
                    <?php echo $data["action"]; ?>
                  </div>
                
                  <?php if(isset($data["error"])) echo "<div class='red-text'>".$data["error"]."</div>"; ?>
                  <input type="hidden" name="id" value="<?php if (isset($data["menu"])) echo $data["menu"]["id"]; ?>"/>
                  <div class="input-field">
                    <input name="name" type="text" id="name" value="<?php if (isset($data["menu"])) echo $data["menu"]["name"]; ?>" required="required"/>
                    <label for="name">Menu Name</label>
                  </div>
                  <div class="input-field">
                    <input name="long_name" type="text" id="long_name" value="<?php if (isset($data["menu"])) echo $data["menu"]["long_name"]; ?>" required="required"/>
                    <label for="name">Menu Name</label>
                  </div>
                  <div class="input-field">
                    <input name="link" type="text" id="link" value="<?php if (isset($data["menu"])) echo $data["menu"]["link"]; ?>" required="required"/>
                    <label for="link">Link</label>
                  </div>
                  <div class="input-field">
                    <input name="icon" type="text" id="icon" value="<?php if (isset($data["menu"])) echo htmlspecialchars($data["menu"]["icon"]); ?>" />
                    <label for="icon">Material Icon Name</label>
                  </div>
                  <div class="input-field">
                    <select name='type'>
                      <option value="G" <?php if (isset($data["menu"])) {if($data["menu"]["type"]=="G"){echo "selected";}} ?>>Global</option>
                      <option value="U" <?php if (isset($data["menu"])) {if($data["menu"]["type"]=="U"){echo "selected";}} ?>>User Specific</option>
                      <option value="A" <?php if (isset($data["menu"])) {if($data["menu"]["type"]=="A"){echo "selected";}} ?>>Authorization Object(Not Shown)</option>
                    </select>
                    <label>Type</label>
                  </div>
                  <div class="input-field">
                    <select name='active'>
                      <option value="Y" <?php if (isset($data["menu"])) {if($data["menu"]["active"]=="Y"){echo "selected";}} ?>>Active</option>
                      <option value="N" <?php if (isset($data["menu"])) {if($data["menu"]["active"]=="N"){echo "selected";}} ?>>Inactive</option>
                    </select>
                    <label>Active ?</label>
                  </div>
                </div>
                <div class="card-action">
                  <button type="submit" value="submit" name="save" class="btn-flat waves-effect">SAVE</button>
                  <button type="button" value="cancel" name="cancel" class="btn-flat waves-effect" onclick="window.history.back()">CANCEL</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  
    <script>
      $(document).ready(function() {
        $('select').material_select();
      });
    </script>
  </body>
</html>