<?php
ini_set( "error_reporting" , E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED );
ini_set( "error_log" , "log/php-error.log" );
ini_set( "display_errors", true );

define( "PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" ); //Local
define( "DB_USERNAME", "hrpay" );
define( "DB_PASSWORD", "hrpay" );

include "classes/SendMail.php";
$mail = new SendMail();
$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
//GET BCC

$sql = "select * from sapsr3.ZMM_EMAILUSER@dbsap_iip where mandt = '600' and bukrs = 'INDO' and type = 'ICMS' and param1 = 'BCC'";
$stmt = $conn->prepare($sql);
$data_bcc = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data_bcc[] = $row["EMAILID"];
	}
}
//section 1
$today = date("Ymd");
$sql = "SELECT srlno, bukrs, sfunc, regul, sdesc, artcl, prfmr, preml, revwr, rveml, duedt FROM SAPSR3.ZFI_AUD_MD_01@DBSAP_IIP where delet = ' ' AND cmpst = ' ' and cmpdt = '00000000' AND  ( rmdt1 = '$today' OR rmdt2 = '$today' )";

$stmt = $conn->prepare($sql);

$data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
}
$i = 0;
if(!empty($data)) {	
	foreach ($data as $val) {
		$due_date = substr($val["DUEDT"], 6, 2).".".substr($val["DUEDT"], 4, 2).".".substr($val["DUEDT"], 0, 4);
		$email_msg = "Dear, ".$val["PRFMR"]."<BR>";
		//echo "<table border='2'>";
		$email_msg .= "INDO Compliance Management System Reminder<br>";
		$email_msg .= "Section 1 - Laws and Regulations<br>";
		$email_msg .= "<table>";
                $email_msg .= "<tr><td>Serial No.</td><td>:</td><td>".$val["SRLNO"]."</td></tr>";
		$email_msg .= "<tr><td>Entity</td><td>:</td><td>".$val["BUKRS"]."</td></tr>";
		$email_msg .= "<tr><td>Sub Function</td><td>:</td><td>".$val["SFUNC"]."</td></tr>";
		$email_msg .= "<tr><td>Regulation</td><td>:</td><td>".$val["REGUL"]."</td></tr>";
		$email_msg .= "<tr><td>Article</td><td>:</td><td>".$val["ARTCL"]."</td></tr>";
		$email_msg .= "<tr><td>Short Desc.</td><td>:</td><td>".$val["SDESC"]."</td></tr>";
		$email_msg .= "<tr><td>Due Date</td><td>:</td><td>".$due_date."</td></tr>";
		$email_msg .= "</table>";
		$recipient = array();
		$recipient[0]["type"] = "ADD";
		$recipient[0]["email"] = $val["PREML"];
		$recipient[1]["type"] = "CC";
		$recipient[1]["email"] = $val["RVEML"];
		$rc = 2;
		if(!empty($data_bcc)) {
			foreach ($data_bcc as $row) {
				$recipient[$rc]["type"] = "BCC";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}
		$mail->sendTheMailAdv("ICMS Reminder Notification, Laws and Regulation", $email_msg, $recipient);
		$i++;
	}	
}

//section 2
$sql = "SELECT srlno, bukrs, sfunc, sdesc, certy, isudt, prfmr, preml, revwr, rveml, duedt FROM SAPSR3.ZFI_AUD_MD_02@DBSAP_IIP where delet = ' ' AND cmpst = ' ' and cmpdt = '00000000' AND  ( rmdt1 = '$today' OR rmdt2 = '$today' )";

$stmt = $conn->prepare($sql);

$data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
}

if(!empty($data)) {	
	foreach ($data as $val) {
		$due_date = substr($val["DUEDT"], 6, 2).".".substr($val["DUEDT"], 4, 2).".".substr($val["DUEDT"], 0, 4);
		$isu_date = substr($val["ISUDT"], 6, 2).".".substr($val["ISUDT"], 4, 2).".".substr($val["ISUDT"], 0, 4);
		$email_msg = "Dear, ".$val["PRFMR"]."<BR>";
		//echo "<table border='2'>";
		$email_msg .= "INDO Compliance Management System Reminder<br>";
		$email_msg .= "Section 2 - License Permits Certifications<br>";
		$email_msg .= "<table>";
                $email_msg .= "<tr><td>Serial No.</td><td>:</td><td>".$val["SRLNO"]."</td></tr>";
		$email_msg .= "<tr><td>Entity</td><td>:</td><td>".$val["BUKRS"]."</td></tr>";
		$email_msg .= "<tr><td>Sub Function</td><td>:</td><td>".$val["SFUNC"]."</td></tr>";
		$email_msg .= "<tr><td>Certification / Permit / license / Renewals /policy types</td><td>:</td><td>".$val["CERTY"]."</td></tr>";
		$email_msg .= "<tr><td>Short Desc.</td><td>:</td><td>".$val["SDESC"]."</td></tr>";
		$email_msg .= "<tr><td>Issue Date</td><td>:</td><td>".$isu_date."</td></tr>";
		$email_msg .= "<tr><td>Due Date</td><td>:</td><td>".$due_date."</td></tr>";
		$email_msg .= "</table>";
		$recipient = array();
		$recipient[0]["type"] = "ADD";
		$recipient[0]["email"] = $val["PREML"];
		$recipient[1]["type"] = "CC";
		$recipient[1]["email"] = $val["RVEML"];
		$rc = 2;
		if(!empty($data_bcc)) {
			foreach ($data_bcc as $row) {
				$recipient[$rc]["type"] = "BCC";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}
		$mail->sendTheMailAdv("ICMS Reminder Notification, License Permits Certifications", $email_msg, $recipient);
		$i++;
	}	
}

//Section 3
$today = date("Ymd");
$sql = "SELECT srlno, bukrs, sfunc, sdesc, certy, agrdt, prfmr, preml, revwr, rveml, agrrd FROM SAPSR3.ZFI_AUD_MD_03@DBSAP_IIP where delet = ' ' AND cmpst = ' ' and cmpdt = '00000000' AND  ( rmdt1 = '$today' OR rmdt2 = '$today' )";

$stmt = $conn->prepare($sql);

$data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
}

if(!empty($data)) {	
	foreach ($data as $val) {
		$due_date = substr($val["AGRRD"], 6, 2).".".substr($val["AGRRD"], 4, 2).".".substr($val["AGRRD"], 0, 4);
		$agr_date = substr($val["AGRDT"], 6, 2).".".substr($val["AGRDT"], 4, 2).".".substr($val["AGRDT"], 0, 4);
		$email_msg = "Dear, ".$val["PRFMR"]."<BR>";
		//echo "<table border='2'>";
		$email_msg .= "INDO Compliance Management System Reminder<br>";
		$email_msg .= "Section 3 - Agreements<br>";
		$email_msg .= "<table>";
                $email_msg .= "<tr><td>Serial No.</td><td>:</td><td>".$val["SRLNO"]."</td></tr>";
		$email_msg .= "<tr><td>Entity</td><td>:</td><td>".$val["BUKRS"]."</td></tr>";
		$email_msg .= "<tr><td>Agreement reference</td><td>:</td><td>".$val["CERTY"]."</td></tr>";
		$email_msg .= "<tr><td>Short Desc.</td><td>:</td><td>".$val["SDESC"]."</td></tr>";
		$email_msg .= "<tr><td>Agreement Date</td><td>:</td><td>".$agr_date."</td></tr>";
		$email_msg .= "<tr><td>Renewal Date</td><td>:</td><td>".$due_date."</td></tr>";
		$email_msg .= "</table>";
		$recipient = array();
		$recipient[0]["type"] = "ADD";
		$recipient[0]["email"] = $val["PREML"];
		$recipient[1]["type"] = "CC";
		$recipient[1]["email"] = $val["RVEML"];
		$rc = 2;
		if(!empty($data_bcc)) {
			foreach ($data_bcc as $row) {
				$recipient[$rc]["type"] = "BCC";
				$recipient[$rc]["email"] = $row;
				$rc++;
			}
		}
		$mail->sendTheMailAdv("ICMS Reminder Notification, Agreements", $email_msg, $recipient);
		$i++;
	}	
}

$myfile = fopen("icms_reminder_log.txt", "w") or die("Unable to open file!");
$txt = date("Y-m-d")." - Job Running - ".$i." Email was Sent".PHP_EOL;
echo $txt;
fwrite($myfile, $txt);
fclose($myfile);
?>