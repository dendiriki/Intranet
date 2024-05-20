<?php

if ($action == "upload_mtc") {
    $class = new MillTC();
    $data = array();
    if (isset($_FILES["excel"])) {
        $conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        require('cron/spreadsheet-reader/php-excel-reader/excel_reader2.php');
        require('cron/spreadsheet-reader/SpreadsheetReader.php');
        $excel = $_FILES["excel"];
        $reader = new Spreadsheet_Excel_Reader();
        $reader->setUTFEncoder('iconv');
        $reader->setOutputEncoding('UTF-8');
        $reader->read($excel["tmp_name"]);
        $i = 0;
        $j = 0;
        foreach ($reader->sheets[0]["cells"] as $row) {
            if ($i > 0) {
                if ($row[1] <> '' and $row[2] <> ''){
                $sql = "SELECT COUNT(*) as CNT FROM sapsr3.ztpp_mtc@dbsap_iip "
                        . "WHERE mandt = '600' AND werks = 'INDO' AND ebeln = '".$row[1]."' AND charg = '".$row[2]."'";
                $stmt = $conn->prepare($sql);
                $data = array();
                if($stmt->execute() or die($stmt->errorInfo()[2])){
                    while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $data[] = $row1["CNT"];
                    }
                }
                
                list($count) = $data;               
            
            if ($count == 0){ 
                $sql = "INSERT INTO sapsr3.ztpp_mtc@dbsap_iip "
                        . "(mandt,werks,ebeln,charg,zqty_c,zqty_mn,zqty_p,zqty_s,zqty_si,zqty_al,zqty_cu,zqty_ni,zqty_cr,zqty_mo,zqty_v,zqty_b,zqty_n2,zgrade) "
                        . "values ('600','INDO','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."','".$row[8]."','".$row[9]."','".$row[10]."','".$row[11]."','".$row[12]."','".$row[13]."','".$row[14]."','".$row[15]."','".$row[16]."')";

                $stmt = $conn->prepare($sql);
                $stmt->execute() or die("Error at row " . $i . " SQL : " . $sql);
                $j++;
            }
            if ($count <> 0){
                echo "Line $i exist. <br>";
            }
            }
        }
            $i++;
        }

        echo "Upload Done, " . ( $j ) . " data inserted";
    } else {
        require( TEMPLATE_PATH . "/t_upload_mtc.php" );
    }
}
?>