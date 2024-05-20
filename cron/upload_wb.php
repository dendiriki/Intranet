<?php
set_time_limit(0);
?>
<html>
  <head>
    
  </head>
  <body>
    <form action="#" method="post" enctype="multipart/form-data">      
			<span>WB File</span>
			<input name="excel" type="file">
			<button type="submit" name="save" value="save">SAVE</button>              
    </form>
    <div>
        <?php
        if(isset($_FILES["excel"])) {
					require('spreadsheet-reader/php-excel-reader/excel_reader2.php');
					require('spreadsheet-reader/SpreadsheetReader.php');
					
          $row = 0;
					$excel = $_FILES["excel"];
					$Reader = new SpreadsheetReader($excel["tmp_name"]);
					
          $sql = "";
          foreach ($Reader as $data) {
            if ($row == 0) {
              $row++;
            } else {
							$wsnum = str_pad($data[1], 12, "0", STR_PAD_LEFT);
							$weigh_f = $data[7].".000";
							$wtmnt_time_f = str_replace(":","",$data[6])."00";
							$machine_f = str_pad($data[7], 6, "0", STR_PAD_LEFT);
							$weigh_s = $data[9].".000";
							$wtmnt_time_s = str_replace(":","",$data[8])."00";
							$machine_s = str_pad($data[9], 6, "0", STR_PAD_LEFT);
							$netwt = $data[10].".000";
              $sql .= "INSERT INTO sapsr3.ZMM_WB_HDR@dbsap_iip (mandt, bukrs, wsnum, trtyp, vehicle_no, ebelp, budat, lifnr, name1, meins, weight_f, wtmnt_date_f, wtmnt_time_f, wtmnt_pers_f, machine_f, weight_s, wtmnt_date_s, wtmnt_time_s, wtmnt_pers_s, machine_s, netwt, wbsta, wtrel, rb1) "
											. "VALUES ('600','INDO','$wsnum','D','".$data[3]."','00010','".$data[0]."','".$data[4]."','".$data[5]."','KG','$weigh_f','".$data[0]."','$wtmnt_time_f','WB.LOG','$machine_f','$weigh_s','".$data[0]."','$wtmnt_time_s','WBLOG','$machine_s','$netwt','S','Y','X');<BR>";
              $row++;
            }
          }
          echo $sql;
        }
        ?>      
    </div>
  </body>
</html>