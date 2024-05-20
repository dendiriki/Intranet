<?php

ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("error_log", "log/php-error.log");
ini_set("display_errors", true);

define("PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))"); //Local
define("DB_USERNAME", "hrpay");
define("DB_PASSWORD", "hrpay");
$conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

$run_date = date("Ymd");
$data_date = date("Y-n-j");
$srlno = 0;
$sql = "select nvl(max(CAST (srlno AS INTEGER)),0) as srlno from sapsr3.ZPP_SMS_EAF_DATA@dbsap_iip where erdat = '$run_date'";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $srlno = $row["SRLNO"];
    }
}
$i = 0;

try {
    //system('net use X: "\172.16.0.240\Apps" /user:sms12 Ispatindo /persistent:yes');
    $h = fopen('//172.16.0.240/Apps/EAF_' . $data_date . '.csv', "r");

    if ($h !== false) {


        while (($data = fgetcsv($h, 1000, ";")) !== FALSE) {
            // Each individual array is being pushed into the nested array
            if ($i > $srlno) {
                $srlno++;
                if (floatval(str_replace(",", ".", $data[2])) == 0 &&
                        floatval(str_replace(",", ".", $data[3])) == 0 &&
                        floatval(str_replace(",", ".", $data[4])) == 0 &&
                        floatval(str_replace(",", ".", $data[5])) == 0 &&
                        floatval(str_replace(",", ".", $data[6])) == 0 &&
                        floatval(str_replace(",", ".", $data[7])) == 0 &&
                        floatval(str_replace(",", ".", $data[11])) == 0 &&
                        floatval(str_replace(",", ".", $data[12])) == 0
                ) {
                    echo "Processing Row $srlno Empty Data" . PHP_EOL;
                } else {
                    $arr_time = explode(":", $data[1]);
                    $time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[1], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);

                    $arr_time = explode(":", $data[8]);
                    $arching_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[1], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);

                    $arr_time = explode(":", $data[9]);
                    $poweroff_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[1], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);

                    $arr_time = explode(":", $data[10]);
                    $t2t_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[1], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);

                    $arr_time = explode(":", $data[13]);
                    $tapping_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[1], 2, "0", STR_PAD_LEFT) . str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    echo "Processing Row $srlno " . PHP_EOL;

                    $heat_no = $data[19];
                    if (strlen($heat_no) == 4) {
                        $heat_no = "011".$heat_no;
                    } else {
                        $heat_no = str_pad($heat_no, 7, "0", STR_PAD_LEFT);
                    }
                    $order_no = 'X0'.$heat_no;
                    
                    // cek apakah heat sudah pernah di proses, jika ya maka data diupdate, beberapa value dijumlah
                    /*$data_lama = array();
                    $sql_s = "SELECT * FROM sapsr3.ZPP_SMS_EAF_DATA@dbsap_iip WHERE aufnr = '$order_no' and zheat = '$heat_no'";
                    $stmt = $conn->prepare($sql_s);
                    if ($stmt->execute()) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $data_lama = $row;
                        }
                    }
                    
                    if(!empty($data_lama)) {
                        $sql_i = "UPDATE sapsr3.ZPP_SMS_EAF_DATA@dbsap_iip "
                                . "SET DRIHP = (DRIHP + '" . str_replace(",", ".", $data[2]) . "'),"
                                . "";
                    } else {*/
                        $sql_i = "INSERT INTO sapsr3.ZPP_SMS_EAF_DATA@dbsap_iip "
                            . "( "
                            . "MANDT,"
                            . "ERDAT,"
                            . "ERZET,"
                            . "SRLNO,"
                            . "DRIHP,"
                            . "DRIUM,"
                            . "DOLOM,"
                            . "DOLUM,"
                            . "LIMEH,"
                            . "LIMUM,"
                            . "CARBN,"
                            . "CARUM,"
                            . "GASEA,"
                            . "GASUM,"
                            . "OXYEA,"
                            . "OXYUM,"
                            . "ARCTM,"
                            . "PWOFF,"
                            . "T2TTM,"
                            . "EAPWR,"
                            . "EPWUM,"
                            . "TPTMP,T"
                            . "PTUM,"
                            . "TPTTM,"
                            . "LIME,"
                            . "LIME_UOM,"
                            . "AMOR_GRAPH,"
                            . "FESI,"
                            . "FESI_UOM,"
                            . "SIMN,"
                            . "SIMN_UOM, "
                            . "AUFNR, "
                            . "ZHEAT "
                            . ") "
                            . "VALUES ("
                            . "'600',"
                            . "'$run_date',"
                            . "'" . $time . "',"
                            . "'$srlno',"
                            . "'" . str_replace(",", ".", $data[2]) . "',"
                            . "'TO',"
                            . "'" . str_replace(",", ".", $data[3]) . "',"
                            . "'TO',"
                            . "'" . str_replace(",", ".", $data[4]) . "',"
                            . "'TO',"
                            . "'" . str_replace(",", ".", $data[5]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[6]) . "',"
                            . "'M3',"
                            . "'" . str_replace(",", ".", $data[7]) . "',"
                            . "'M3',"
                            . "'" . $arching_time . "',"
                            . "'" . $poweroff_time . "',"
                            . "'" . $t2t_time . "',"
                            . "'" . str_replace(",", ".", $data[11]) . "',"
                            . "'MWH',"
                            . "'" . str_replace(",", ".", $data[12]) . "',"
                            . "'GC',"
                            . "'" . $tapping_time . "',"
                            . "'" . str_replace(",", ".", $data[15]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[16]) . "',"
                            . "'" . str_replace(",", ".", $data[17]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[18]) . "',"
                            . "'KG',"
                            . "'$order_no',"
                            . "'$heat_no' "
                            . ")";
                    /*}*/
                    
                    
                    $conn->exec($sql_i) or die($conn->errorInfo()[2]);
                }
            }
            $i++;
        }
    } else {
        $myfile = fopen("eaf_data_job_log.txt", "w") or die("Unable to open file!");
        $txt = "Job " . date("Y-m-d H:i:s") . " Error, Error Open File : Y:\\EAF_" . $data_date . ".csv : ";
        fwrite($myfile, $txt);
        fclose($myfile);
        die();
    }
    // Close the file
    fclose($h);
} catch (Exception $ex) {
    $myfile = fopen("eaf_data_job_log.txt", "w") or die("Unable to open file!");
    $txt = "Job " . date("Y-m-d H:i:s") . " Error, File : Y:\\EAF_" . $data_date . ".csv : " . $ex->getMessage();
    fwrite($myfile, $txt);
    fclose($myfile);
    die();
}


$myfile = fopen("eaf_data_job_log.txt", "w") or die("Unable to open file!");
$txt = "Job " . date("Y-m-d H:i:s") . " running $i data processed, File : Y:\\EAF_" . $data_date . ".csv \n";
fwrite($myfile, $txt);
fclose($myfile);
?>