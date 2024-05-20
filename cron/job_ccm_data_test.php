<?php

ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("error_log", "log/php-error.log");
ini_set("display_errors", true);


define("PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))"); //Local
define("DB_USERNAME", "hrpay");
define("DB_PASSWORD", "hrpay");
$conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

$run_date = '20220201';//date("Ymd");
$data_date = '2022-2-1';//date("Y-n-j");
$srlno = 0;
$sql = "select nvl(max(CAST (srlno AS INTEGER)),0) as srlno from sapsr3.ZPP_SMS_CCM_DATA@dbsap_iip where erdat = '$run_date'";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $srlno = $row["SRLNO"];
    }
}
$i = 0;

try {
    //system('net use X: "\172.16.0.240\Apps" /user:sms12 Ispatindo /persistent:yes');
    $h = fopen('//172.16.0.240/Apps/CCM_'.$data_date.'.csv', "r");

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
                    $arr_time = explode(":",$data[1]);
                    $time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    $arr_time = explode(":",$data[2]);
                    $cast_s_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    $arr_time = explode(":",$data[3]);
                    $cast_e_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    echo "Processing Row $srlno " . PHP_EOL;
                    $sql_i = "INSERT INTO sapsr3.ZPP_SMS_CCM_DATA@dbsap_iip "
                            . "( "
                            . "MANDT, "
                            . "ERDAT, "
                            . "ERZET, "
                            . "SRLNO, "
                            . "CAST_S_TIME, "
                            . "CAST_E_TIME, "
                            . "CCM_1_TEMP, "
                            . "CCM_2_TEMP, "
                            . "CCM_3_TEMP, "
                            . "CCM_4_TEMP, "
                            . "CCM_5_TEMP, "
                            . "CCM_TEMP_UOM, "
                            . "\"SEQNO\" "
                            . ") "
                            . "VALUES ("
                            . "'600',"
                            . "'$run_date',"
                            . "'" . $time . "',"
                            . "'$srlno',"
                            . "'" . $cast_s_time . "',"
                            . "'" . $cast_e_time . "',"
                            . "'" . str_replace(",", ".", $data[4]) . "',"
                            . "'" . str_replace(",", ".", $data[5]) . "',"
                            . "'" . str_replace(",", ".", $data[6]) . "',"
                            . "'" . str_replace(",", ".", $data[7]) . "',"
                            . "'" . str_replace(",", ".", $data[8]) . "',"
                            . "'GC',"
                            . "'" . str_replace(",", ".", $data[9]) . "'"
                            . ")";
                    $conn->exec($sql_i) or die("SQL : ".$sql_i.PHP_EOL.$conn->errorInfo()[2]);
                }
            }
            $i++;
        }
    } else {
        $myfile = fopen("ccm_data_job_log.txt", "w") or die("Unable to open file!");
        $txt = "Job " . date("Y-m-d H:i:s") . " Error, Error Open File : Y:\\EAF_".$data_date.".csv : ";
        fwrite($myfile, $txt);
        fclose($myfile);
        die();
    }
    // Close the file
    fclose($h);
} catch (Exception $ex) {
    $myfile = fopen("ccm_data_job_log.txt", "w") or die("Unable to open file!");
    $txt = "Job " . date("Y-m-d H:i:s") . " Error, File : Y:\\EAF_".$data_date.".csv : ".$ex->getMessage();
    fwrite($myfile, $txt);
    fclose($myfile);
    die();
}


$myfile = fopen("eaf_data_job_log.txt", "w") or die("Unable to open file!");
$txt = "Job " . date("Y-m-d H:i:s") . " running $i data processed, File : Y:\\EAF_".$data_date.".csv \n";
fwrite($myfile, $txt);
fclose($myfile);
?>