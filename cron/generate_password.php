<?php

require( "../config.php" );

echo "Generating Initial User\n";
echo "=============================================\n";

$conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN);

$sql = "SELECT vc_emp_code FROM mst_employee "
        . "WHERE vc_comp_code = '01' AND dt_resignation_date IS NULL "
        . "ORDER BY vc_emp_code ASC";
$st = oci_parse($conn, $sql);

echo "Executing select query '.$sql.'\n";
oci_execute($st) or die(oci_error($conn)["message"]);
echo "Done executing select query, begin processing data\n";
$sql2 = "INSERT ALL ";
$i = 0;
while (($row = oci_fetch_assoc($st)) != false) {
  //echo $row["VC_EMP_CODE"]."\n";
  $i++;
  $sql2 .= "INTO int_mst_user (vc_emp_code, vc_emp_pass) VALUES ('" . $row["VC_EMP_CODE"] . "','" . md5($row["VC_EMP_CODE"]) . "') ";
}
$sql2 .= "SELECT * FROM dual";
echo "Done processing data\n";
oci_free_statement($st);

$st2 = oci_parse($conn, $sql2);
echo "Begin Executing insert query " . $i . " data\n";
//echo $sql2."\n";
$insert = oci_execute($st2, OCI_NO_AUTO_COMMIT);
echo "Done executing insert query\n";
if ($insert == true) {
  oci_commit($conn);
  echo "Insert Sukses, " . $i . " data\n";
} else {
  oci_rollback($conn);
  echo oci_error($conn)["message"];
}
oci_free_statement($st2);
oci_close($conn);
?>