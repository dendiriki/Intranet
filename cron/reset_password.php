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
                <span>User File</span>
                <input name="user" type="file">
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
          $the_file = $_FILES["user"];
          $uploaded_file = $the_file["tmp_name"];
          $handle = fopen($uploaded_file, "r");
          $row = 0;
          $sql = "INSERT ALL ";
          while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            if ($row == 0) {
              $row++;
            } else {
              $sql .= " INTO INT_MST_USER VALUES('".strtoupper($data[3])."','".md5($data[4])."','0','1','EX','".strtoupper(trim($data[1]." ".$data[2]))."',NULL,NULL) ";
              $row++;
            }
          }
          $sql .= " SELECT * FROM dual";
          fclose($handle);
          
          $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN);
          
          $st = oci_parse($conn, $sql);
          oci_execute($st) or die(oci_error($conn)["message"]);
          
          oci_free_statement($st);
          
          oci_close($conn);
          
          echo "<h5>Done Import User</h5>";
        }

        ?>
      </div>        
    </div>
    <script src="../templates/vendor/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../templates/vendor/materialize/js/materialize.min.js" type="text/javascript"></script>
  </body>
</html>