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
$sql = "select nvl(max(CAST (srlno AS INTEGER)),0) as srlno from sapsr3.ZPP_SMS_LRF_DATA@dbsap_iip where erdat = '$run_date'";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $srlno = $row["SRLNO"];
    }
}
$i = 0;

try {
    //system('net use X: "\172.16.0.240\Apps" /user:sms12 Ispatindo /persistent:yes');
    $h = fopen('//172.16.0.240/Apps/LRF_'.$data_date.'.csv', "r");

    if ($h !== false) {

        
        while (($data = fgetcsv($h, 1000, ";")) !== FALSE) {
            // Each individual array is being pushed into the nested array
            if ($i > $srlno) {
                $srlno++;
                if (floatval(str_replace(",", ".", $data[5])) == 0 &&
                        floatval(str_replace(",", ".", $data[6])) == 0 &&
                        floatval(str_replace(",", ".", $data[7])) == 0 &&
                        floatval(str_replace(",", ".", $data[8])) == 0 &&
                        floatval(str_replace(",", ".", $data[9])) == 0 &&
                        floatval(str_replace(",", ".", $data[10])) == 0 &&
                        floatval(str_replace(",", ".", $data[11])) == 0 &&
                        floatval(str_replace(",", ".", $data[12])) == 0 &&
                        floatval(str_replace(",", ".", $data[13])) == 0 &&
                        floatval(str_replace(",", ".", $data[14])) == 0 &&
                        floatval(str_replace(",", ".", $data[15])) == 0 &&
                        floatval(str_replace(",", ".", $data[16])) == 0 &&
                        floatval(str_replace(",", ".", $data[17])) == 0 &&
                        floatval(str_replace(",", ".", $data[18])) == 0 &&
                        floatval(str_replace(",", ".", $data[19])) == 0 &&
                        floatval(str_replace(",", ".", $data[20])) == 0 &&
                        floatval(str_replace(",", ".", $data[21])) == 0 &&
                        floatval(str_replace(",", ".", $data[22])) == 0 &&
                        floatval(str_replace(",", ".", $data[23])) == 0 &&
                        floatval(str_replace(",", ".", $data[24])) == 0 &&
                        floatval(str_replace(",", ".", $data[25])) == 0 &&
                        floatval(str_replace(",", ".", $data[26])) == 0 &&
                        floatval(str_replace(",", ".", $data[27])) == 0 &&
                        floatval(str_replace(",", ".", $data[28])) == 0 &&
                        floatval(str_replace(",", ".", $data[29])) == 0 &&
                        floatval(str_replace(",", ".", $data[30])) == 0 &&
                        floatval(str_replace(",", ".", $data[31])) == 0 &&
                        floatval(str_replace(",", ".", $data[32])) == 0
                ) {
                    echo "Processing Row $srlno Empty Data" . PHP_EOL;
                } else {
                    $arr_time = explode(":",$data[1]);
                    $time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    /*$arr_time = explode(":",$data[2]);
                    $parking_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                     * 
                     */
                    if ($data[2] == '') {
                        $parking_time = "0";
                    }
                    else {
                    $parking_time = $data[2];
                    
                    }
                    
                    $arr_time = explode(":",$data[3]);
                    $lrfin_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    $arr_time = explode(":",$data[4]);
                    $lrfout_time = str_pad($arr_time[0], 2, "0", STR_PAD_LEFT).str_pad($arr_time[1], 2, "0", STR_PAD_LEFT).str_pad($arr_time[2], 2, "0", STR_PAD_LEFT);
                    
                    echo "Processing Row $srlno " . PHP_EOL;
                    
                    $heat_no = $data[33];
                    if (strlen($heat_no) == 4) {
                        $heat_no = "011".$heat_no;
                    } else {
                        $heat_no = str_pad($heat_no, 7, "0", STR_PAD_LEFT);
                    }
                    $order_no = 'X0'.$heat_no;
                    
                    $sql_i = "INSERT INTO sapsr3.ZPP_SMS_LRF_DATA@dbsap_iip "
                            . "( "
                            . "MANDT,"
                            . "ERDAT,"
                            . "ERZET,"
                            . "SRLNO,"
                            . "PARKING_TIME,"
                            . "LRF_IN_TIME,"
                            . "LRF_OUT_TIME,"
                            . "LRF_POWER,"
                            . "LRF_POWER_UOM,"
                            . "LRF_F_TEMP,"
                            . "LRF_F_TEMP_UOM,"
                            . "LRF_L_TEMP,"
                            . "LRF_L_TEMP_UOM,"
                            . "LRF_P_F_TEMP,"
                            . "LRF_P_F_TEMP_UOM,"                            
                            . "LIME_HOPPER,"
                            . "LIME_HOPPER_UOM,"
                            . "AMGRAPH1,"
                            . "AMGRAPH2,"
                            . "SIMN_HOPPER6,"
                            . "SIMN_HOPPER6_UOM,"
                            . "SIMN_HOPPER7,"
                            . "SIMN_HOPPER7_UOM,"
                            . "FESI_HOPPER,"
                            . "FESI_HOPPER_UOM,"
                            . "RMH_SPONGE,"
                            . "RMH_SPONGE_UOM,"
                            . "RMH_ALU_WR,"
                            . "RMH_ALU_WR_UOM,"
                            . "RMH_AMOR_GRAPH,"
                            . "RMH_BR,"
                            . "RMH_BR_UOM,"
                            . "RMH_CAL_CR,"
                            . "RMH_CAL_CR_UOM,"
                            . "RMH_C,"
                            . "RMH_C_UOM,"
                            . "RMH_CORE_WR,"
                            . "RMH_CORE_WR_UOM,"
                            . "RMH_DOLOMITE,"
                            . "RMH_DOLOMITE_UOM,"
                            . "RMH_FE_CR,"
                            . "RMH_FE_CR_UOM,"
                            . "RMH_FE_MN,"
                            . "RMH_FE_MN_UOM,"
                            . "RMH_FE_SI,"
                            . "RMH_FE_SI_UOM,"
                            . "RMH_FE_TN,"
                            . "RMH_FE_TN_UOM,"
                            . "RMH_FLUOR,"
                            . "RMH_FLUOR_UOM,"
                            . "RMH_LIME,"
                            . "RMH_LIME_UOM,"
                            . "RMH_NI,"
                            . "RMH_NI_UOM,"
                            . "RMH_SI_MN,"
                            . "RMH_SI_MN_UOM,"
                            . "RMH_VN,"
                            . "RMH_VN_UOM, "
                            . "AUFNR, "
                            . "ZHEAT "
                            . ") "
                            . "VALUES ("
                            . "'600',"
                            . "'$run_date',"
                            . "'" . $time . "',"
                            . "'$srlno',"
                            . "'$parking_time',"
                            . "'$lrfin_time',"
                            . "'$lrfout_time',"
                            . "'" . str_replace(",", ".", $data[5]) . "',"
                            . "'KWH',"
                            . "'" . str_replace(",", ".", $data[6]) . "',"
                            . "'GC',"
                            . "'" . str_replace(",", ".", $data[7]) . "',"
                            . "'GC',"
                            . "'" . str_replace(",", ".", $data[8]) . "',"
                            . "'GC',"
                            
                            . "'" . str_replace(",", ".", $data[9]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[10]) . "',"
                            . "'" . str_replace(",", ".", $data[11]) . "',"
                            . "'" . str_replace(",", ".", $data[12]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[13]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[14]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[16]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[17]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[18]) . "',"
                            . "'" . str_replace(",", ".", $data[19]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[20]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[21]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[22]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[23]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[24]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[25]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[26]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[27]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[28]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[29]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[30]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[31]) . "',"
                            . "'KG',"
                            . "'" . str_replace(",", ".", $data[32]) . "',"
                            . "'KG',"
                            . "'$order_no',"
                            . "'$heat_no'"
                            . ")";
                    $conn->exec($sql_i) or die($conn->errorInfo()[2]);
                }
            }
            $i++;
        }
    } else {
        $myfile = fopen("lrf_data_job_log.txt", "w") or die("Unable to open file!");
        $txt = "Job " . date("Y-m-d H:i:s") . " Error, Error Open File : Y:\\EAF_".$data_date.".csv : ";
        fwrite($myfile, $txt);
        fclose($myfile);
        die();
    }
    // Close the file
    fclose($h);
} catch (Exception $ex) {
    $myfile = fopen("lrf_data_job_log.txt", "w") or die("Unable to open file!");
    $txt = "Job " . date("Y-m-d H:i:s") . " Error, File : Y:\\EAF_".$data_date.".csv : ".$ex->getMessage();
    fwrite($myfile, $txt);
    fclose($myfile);
    die();
}


$myfile = fopen("lrf_data_job_log.txt", "w") or die("Unable to open file!");
$txt = "Job " . date("Y-m-d H:i:s") . " running $i data processed, File : Y:\\EAF_".$data_date.".csv \n";
fwrite($myfile, $txt);
fclose($myfile);
?>