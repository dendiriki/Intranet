<html>
  <head>
    <link href="../templates/vendor/roboto-fonts/roboto.css" rel="stylesheet" type="text/css"/>
    <link href="../templates/vendor/material-icons/material-icons.css" rel="stylesheet" type="text/css"/>
    <link href="../templates/vendor/materialize/css/materialize.min.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <form class="container" action="#" method="post" enctype="multipart/form-data">
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="file-field col s6">
              <div class="btn">
                <span>Telp. File</span>
                <input name="telp" type="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload Files Here">
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <button class="btn btn-flat" type="submit" name="save" value="save">SAVE</button>
        </div>
      </div>
    </form>
    <div class="container">
      <div class="card-panel">
        <?php
        include '../config.php';
        if(isset($_POST["save"])) {
          $the_file = $_FILES["telp"];
          $telp = $the_file["tmp_name"];
          $handle = fopen($telp, "r");
          $row = 0;
          $sql = "INSERT ALL";
          while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            if ($row == 0) {
              $row++;
            } else {
              $sql .= " INTO int_mst_user_telp VALUES('".$data[0]."','".$data[1]."')";
              $row++;
            }
          }
          $sql .= " SELECT * FROM dual";
          echo $sql;
          fclose($handle);
        }

        ?>
      </div>        
    </div>
    <script src="../templates/vendor/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../templates/vendor/materialize/js/materialize.min.js" type="text/javascript"></script>
  </body>
</html>