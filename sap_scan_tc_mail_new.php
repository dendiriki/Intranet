<?php
ini_set( "error_reporting" , E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED );
ini_set( "error_log" , "log/php-error.log" );
ini_set( "display_errors", true );

define( "PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" ); //Local
define( "DB_USERNAME", "production" );
define( "DB_PASSWORD", "production" );

include "classes/SendMail.php";
$mail = new SendMail();
$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);

$sql = "SELECT * FROM ZSAP_CUST_TC_SCANNER";
$stmt = $conn->prepare($sql);
$data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'TCSCAN'
        AND STS = '4'";
$stmt = $conn->prepare($sql);
$mail_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$mail_data[] = $row["MAILID"];
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'TCSCAN'
        AND STS = '4'";
$stmt = $conn->prepare($sql);
$cc_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$cc_data[] = $row["MAILID"];
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'TCSCAN'
        AND STS = '4'";
$stmt = $conn->prepare($sql);
$bcc_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$bcc_data[] = $row["MAILID"];
	}
}

$recipient = array();
		$rc = 0;
                if(!empty($mail_data)) {
			foreach ($mail_data as $row) {
				$recipient[$rc]["type"] = "ADD";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}
                if(!empty($cc_data)) {
			foreach ($cc_data as $row) {
				$recipient[$rc]["type"] = "CC";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}
		if(!empty($bcc_data)) {
			foreach ($bcc_data as $row) {
				$recipient[$rc]["type"] = "BCC";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}

if(!empty($data)) {
    foreach ($data as $val) {
        $kunnr = $val["KUNNR"];
        $sql = "SELECT B.WSNUM,
                   (SELECT VEHICLE_NO
                      FROM SAPSR3.ZSD_WB_HDR@DBSAP_IIP
                     WHERE MANDT = B.MANDT
                       AND WSNUM = B.WSNUM) AS VEHNO,
                   A.KUNNR,
                   (SELECT NAME1
                      FROM SAPSR3.KNA1@DBSAP_IIP
                     WHERE MANDT = A.MANDT
                       AND KUNNR = A.KUNNR) AS NAME1,
                   TO_CHAR(SYSDATE, 'DD-MM-YYYY hh24:mi:ss') as budat,
                   (SELECT NAME1
                      FROM SAPSR3.LFA1@DBSAP_IIP
                     WHERE MANDT = A.MANDT
                       AND LIFNR = A.LIFNR) AS SUPP,
                   A.VBELN,
                   B.CHARG,
                   substr(C.MATNR, 11, 8) as matnr,
                   (SELECT MAKTG
                      FROM SAPSR3.MAKT@DBSAP_IIP
                     WHERE MANDT = C.MANDT
                       AND MATNR = C.MATNR
                       AND SPRAS = 'E') AS MATDES,
                   (SELECT ATWRT
                      FROM sapsr3.ausp@DBSAP_IIP
                     where mandt = '600'
                       and ATINN = '0000000820'
                       and OBJEK in (select CUOBJ_BM
                                       from sapsr3.mch1@DBSAP_IIP
                                      where mandt = '600'
                                        and matnr = C.MATNR
                                        AND CHARG = B.CHARG)) AS HEAT_NO,
                   '1' AS NUM_COIL,
                   (select menge
                      from sapsr3.mseg@DBSAP_IIP
                     where mandt = '600'
                       and matnr = C.MATNR
                       AND CHARG = B.CHARG
                       and mjahr || mblnr =
                           (select max(mjahr || mblnr)
                              from sapsr3.mseg@DBSAP_IIP
                             where mandt = '600'
                               and matnr = C.MATNR
                               AND CHARG = B.CHARG)) AS MENGE,
                   SUBSTR(A.ERDAT, 1, 4) AS YEARS
              FROM SAPSR3.LIKP@DBSAP_IIP         A,
                   SAPSR3.ZSD_WB_BATCH@DBSAP_IIP B,
                   SAPSR3.ZSD_WB_ITM@DBSAP_IIP   C
             WHERE A.MANDT = B.MANDT
               AND A.VBELN = B.VBELN
               AND A.MANDT = C.MANDT
               AND B.WSNUM = C.WSNUM
               AND B.POSNR = C.POSNR
               AND A.MANDT = '600'
               AND A.KUNNR = '$kunnr'
               AND SUBSTR(A.ERDAT, 1, 8) = TO_CHAR(SYSDATE, 'YYYYMMDD')
               --AND SUBSTR(A.ERDAT, 1, 6) >= '201909'
               --AND SUBSTR(A.ERDAT, 1, 8) = '20190826'
                  --AND SUBSTR(A.ERDAT, 1, 6) BETWEEN '201905' AND '201905'
                  --AND A.ERDAT = '201909'
               AND B.WSNUM NOT IN (SELECT WSNUM FROM ZSAP_CUST_LOG)
             order by 1 asc";
                 
        $stmt = $conn->prepare($sql);
        $data2 = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $data2[] = $row;
                }
        }
        $vwsnum = 'XXX';
        if(!empty($data2)){
        foreach ($data2 as $val1) {
                $wsnum = $val1["WSNUM"];
                $vehno = $val1["VEHNO"];
                $name1 = $val1["NAME1"];
                $budat = $val1["BUDAT"];
                $supp = $val1["SUPP"];
                if ($vwsnum <> $wsnum){
                    if ($vwsnum <> 'XXX'){
                        
                    }
                
                $email_msg1 .= "PT. ISPAT INDO <br><br>";
                $email_msg1 .= "<table>";
                $email_msg1 .= "<tr><td>Transaction</td><td>:</td><td>".$wsnum."</td></tr>";
                $email_msg1 .= "<tr><td>Vehicle No</td><td>:</td><td>".$vehno."</td></tr>";
                $email_msg1 .= "<tr><td>Customer No</td><td>:</td><td>".$name1."</td></tr>";
                $email_msg1 .= "<tr><td>Date</td><td>:</td><td>".$budat."</td></tr>";
                $email_msg1 .= "<tr><td>Transporter Name</td><td>:</td><td>".$supp."</td></tr>";
                $email_msg1 .= "</table><br>";
                $email_msg1 .= "<table>";
                $email_msg1 .= "<tr><td>Delivery</td><td>Product</td><td>Heat No</td><td>Description</td><td>Bundle</td><td>No. of Coils</td><td>Weight</td></tr>"; 
//                $email_msg2 = $email_msg2. $email_msg1;
                $vwsnum = $wsnum;  
                
                $email_msg2 .= "<tr><td>".$val1["VBELN"]."</td><td>".$val1["MATNR"]."</td><td>".$val1["HEAT_NO"]."</td><td>".$val1["MATDES"]."</td><td>".$val1["CHARG"]."</td><td>".$val1["NUM_COIL"]."</td><td>".$val1["MENGE"]."</td></tr>";
                $email_msg2 .= $email_msg2. $email_msg1;
                }
                
//                $wsnum = $val["WSNUM"];
                
//                $sql = "select count(*) as count
//                        from ZSAP_CUST_LOG
//                        where wsnum = '$wsnum'";
//                $stmt = $conn->prepare($sql);
//                $count = array();
//                if($stmt->execute() or die($stmt->errorInfo()[2])) {
//                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                                $count[] = $row;
//                        }
//                }
//                if ($count = 0) {
//                    $sql = "insert into ZSAP_CUST_LOG values ('INDO','$wsnum', SYSDATE)";
//                    $stmt = $conn->prepare($sql);
//                    $sql = "COMMIT TRANSACTION";
//                    $stmt = $conn->prepare($sql);
//                }
                
        }
        
        $email_msg3 .= "</table><br>";
        $email_msg3 .= "::: This is an automatically generated email, please do not reply.";
        $email_msg  .= $email_msg2. '<br>' .$email_msg3;
        $mail->sendTheMailIT("SAP Automail - Scanner Report Alert", $email_msg, $recipient);
    }
}
}



$mail = new SendMail();

$myfile = fopen("scantcmail_job_log.txt", "w") or die("Unable to open file!");
$txt = date("Y-m-d")." - Job Running - ".$i." Email was Sent".PHP_EOL;
echo $txt;
fwrite($myfile, $txt);
fclose($myfile);
?>