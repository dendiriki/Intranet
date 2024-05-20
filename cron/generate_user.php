<?php

require( "../config.php" );

echo "Generating Initial User\n";
echo "=============================================\n";

$conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN);

$sql = "SELECT vc_comp_code, vc_emp_code, to_char(dt_date_of_birth,'DDMMYYYY') AS bday, vc_first_name, vc_middle_name, vc_last_name FROM mst_employee "
        . "WHERE vc_comp_code IN ('01','02','04','05') AND dt_resignation_date IS NULL "
        . "ORDER BY vc_emp_code ASC";
$st = oci_parse($conn, $sql);

echo "Executing select query ".$sql."\n";
oci_execute($st) or die(oci_error($conn)["message"]);
echo "Done executing select query, begin processing data\n";
//$sql2 = "INSERT ALL ";
$i = 0;
while (($row = oci_fetch_assoc($st)) != false) {
  //echo $row["VC_EMP_CODE"]."\n";
  $i++;
  $company = null;
  if($row["VC_COMP_CODE"] == "01") {
    $company = "IND";
  } else if($row["VC_COMP_CODE"] == "02") {
    $company = "IWP";
  } else if($row["VC_COMP_CODE"] == "04") {
    $company = "IPP";
  } else if($row["VC_COMP_CODE"] == "05") {
    $company = "IBB";
  }
  
  $name = $row["VC_FIRST_NAME"]." ".$row["VC_MIDDLE_NAME"]." ".$row["VC_LAST_NAME"];
  echo "processing data for ".$name." Number ".$i."\n";
  $sql2 = "INSERT INTO int_mst_user ( vc_username, vc_emp_pass, vc_reset, vc_emp_code, vc_comp_code, vc_name ) "
          . "VALUES ('" . $company.$row["VC_EMP_CODE"] . "','" . md5($row["BDAY"].$row["VC_EMP_CODE"]) . "', '1', '".$row["VC_EMP_CODE"] ."', '".$row["VC_COMP_CODE"] ."', :name )";
  //echo $sql2."\n";
  $st2 = oci_parse($conn, $sql2);
  oci_bind_by_name($st2, ":name", $name, -1, SQLT_CHR);
  oci_execute($st2) or die(oci_error($conn)["message"]);
  oci_free_statement($st2);
}
//$sql2 .= "SELECT * FROM dual";
echo "Done processing data\n";
oci_free_statement($st);
oci_close($conn);
?>