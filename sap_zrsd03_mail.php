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

$sql = "    SELECT A.VBELN,
           substr(A.WADAT_IST, 7, 2) || '-' || substr(A.WADAT_IST, 5, 2) || '-' ||
           substr(A.WADAT_IST, 0, 4) as WADAT_IST,
           rpad(C. NAME1, 35) as name1,
           substr(B.MATNR, 11, 8) as matnr,
           rpad(D.MAKTX, 40, ' ') as maktx,
           rpad(B.MATKL, 9, ' ') as matkl,
           lpad(SUM(B.LFIMG), 9) AS QTY
      FROM SAPSR3.LIKP@DBSAP_IIP A,
           SAPSR3.LIPS@DBSAP_IIP B,
           SAPSR3.KNA1@DBSAP_IIP C,
           SAPSR3.MAKT@DBSAP_IIP D
     WHERE A.MANDT = '600'
       AND A.KUNNR IN
           (SELECT KUNNR FROM ZSAP_ZRSD03_MAIL WHERE VKORG = A.VKORG)
       AND A.WADAT_IST = TO_CHAR(SYSDATE - 1, 'YYYYMMDD')
       AND A.MANDT = B.MANDT
       AND A.VBELN = B.VBELN
       AND A.MANDT = C.MANDT
       AND A.KUNNR = C.KUNNR
       AND A.MANDT = D.MANDT
       AND B.MATNR = D.MATNR
       AND D.SPRAS = 'E'
     GROUP BY A.VBELN,
              WADAT_IST,
              A.ERZET,
              C.NAME1,
              B.MATNR,
              B.MATKL,
              D.MAKTX";
$stmt = $conn->prepare($sql);
$main_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$main_data[] = $row;
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'ZRSD03'
        AND STS = '1'";
$stmt = $conn->prepare($sql);
$mail_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$mail_data[] = $row["MAILID"];
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'ZRSD03'
        AND STS = '2'";
$stmt = $conn->prepare($sql);
$cc_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$cc_data[] = $row["MAILID"];
	}
}

$sql = "SELECT MAILID
        FROM ZSAP_MAIL_ID
        WHERE TCODE = 'ZRSD03'
        AND STS = '3'";
$stmt = $conn->prepare($sql);
$bcc_data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$bcc_data[] = $row["MAILID"];
	}
}

$email_msg .= "Dear All, <br><br>";
$email_msg .= "Following material have already dispatched to registered customers. Please prepare at your end for further information.<br><br>";
$c = 1;
if(!empty($main_data)) {
	foreach ($main_data as $val) {
		$email_msg .= "<table>";
		$email_msg .= "<tr><td>$c.</td><td>Delivery</td><td>:</td><td>".$val["VBELN"]."</td></tr>";
		$email_msg .= "<tr><td></td><td>SJ Date</td><td>:</td><td>".$val["WADAT_IST"]."</td></tr>";
		$email_msg .= "<tr><td></td><td>Customer</td><td>:</td><td>".$val["NAME1"]."</td></tr>";
		$email_msg .= "<tr><td></td><td>Material</td><td>:</td><td>".$val["MATNR"]."</td></tr>";
                $email_msg .= "<tr><td></td><td>Description</td><td>:</td><td>".$val["MAKTX"]."</td></tr>";
                $email_msg .= "<tr><td></td><td>Grade</td><td>:</td><td>".$val["MATKL"]."</td></tr>";
                $email_msg .= "<tr><td></td><td>Disp. Qty</td><td>:</td><td>".$val["QTY"]."</td></tr>";
		$email_msg .= "</table><br>";
                $c++;
        }
        $send = 1;
} else { $send = 0; }

$recipient = array();
		$rc = 0;
                if(!empty($mail_data)) {
			foreach ($mail_data as $row) {
				$recipient[$rc]["type"] = "ADD";
				$recipient[$rc]["email"] = $row;
                                echo $row;
				$rc++;
			}
		}
                if(!empty($cc_data)) {
			foreach ($cc_data as $row) {
				$recipient[$rc]["type"] = "CC";
				$recipient[$rc]["email"] = $row;
				echo $row;
                                $rc++;
			}
		}
		if(!empty($bcc_data)) {
			foreach ($bcc_data as $row) {
				$recipient[$rc]["type"] = "BCC";
				$recipient[$rc]["email"] = $row;
				echo $row;
                                $rc++;
			}
		}
                $email_msg .= "::: This is an automatically generated email, please do not reply.";
//                if ($send = 0) {
//	
//                } else {
//                    $mail->sendTheMailAdv("SAP Automail - Dispatch Information", $email_msg, $recipient);
//                }
               
                if ($send <> 0):
                    
			$mail->sendTheMailIT("SAP Automail - Dispatch Information", $email_msg, $recipient);
			echo $email_msg."<BR>";
			$mail = new SendMail();
			$myfile = fopen("zrsd03_job_log.txt", "w") or die("Unable to open file!");
			$txt = date("Y-m-d")." - Job Running - ".$i." Email was Sent".PHP_EOL;
			echo $txt;
			fwrite($myfile, $txt);
			fclose($myfile);
                endif;
                
                
                

?>