<?php
ini_set( "error_reporting" , E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED );
ini_set( "error_log" , "log/php-error.log" );
ini_set( "display_errors", true );

define( "PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" ); //Local
define( "DB_USERNAME", "cmms" );
define( "DB_PASSWORD", "cmms" );

include "classes/SendMail.php";
//$mail = new SendMail();
$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);


$sql = "SELECT DISTINCT a.vc_dept_code as dept, b.vc_dept_name as depname
		FROM MAIL_LIST_CMMS a, costing.mst_department b
		WHERE a.vc_comp_code = '01'
		AND a.vc_status = 'Y'
		AND a.vc_program_code = 'CPM' 
		AND a.vc_comp_code = b.vc_comp_code
		AND a.vc_dept_code = b.Vc_Dept_Code ";
$stmt = $conn->prepare($sql);
$data1 = array();
if($stmt->execute() or die($stmt->errorInfo()[2])){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data1[] = $row;
    }
}
if(!empty($data1)){
    foreach ($data1 as $val) {
		$depcd = $val["DEPT"];
		$depnm = $val["DEPNAME"];
		//Periksa data Schedule & Jadwal jika ada yang expired date-nya sudah mendekati duedate (kurang 3 hari) 
		$sql = "SELECT a.vc_workorder_no DOC_NO, a.vc_remarks DOC_DESC, b.vc_remarks ASET_DESC, 
					   TO_CHAR(a.dt_expired_date,'DD-MON-YYYY') START_DATE, 'OPEN WORK ORDER' REMARKS
				FROM hd_work_order a, MST_ASSET b, costing.mst_department c
				WHERE a.vc_comp_code = '01'
				AND  a.vc_wo_status = 'STS00001'
				AND TO_CHAR(a.dt_expired_date,'YYYYMMDD') = TO_CHAR(sysdate+3,'YYYYMMDD')
				AND a.vc_comp_code = b.vc_comp_code
				AND a.vc_asset_code = b.vc_asset_code
				AND a.vc_comp_code = c.vc_comp_code
				AND a.vc_dept_code = c.vc_dept_code
				AND a.vc_dept_code = '$depcd' 
		        UNION
				SELECT a.vc_schedule_no DOC_NO, a.vc_schedule_desc DOC_DESC, b.vc_remarks ASET_DESC, 
					   TO_CHAR(a.dt_start_date,'DD-MON-YYYY') START_DATE, 'WORK ORDER IS NOT GENERATING YET' REMARKS
				FROM schedule_maintenance a, MST_ASSET b, costing.mst_department c
				WHERE a.vc_comp_code = '01'
				AND a.vc_comp_code = b.vc_comp_code
				AND a.vc_object_code = b.vc_asset_code
				AND a.vc_comp_code = c.vc_comp_code
				AND a.vc_dept_code = c.vc_dept_code
				AND NVL(a.vc_status,'Y') = 'Y'
				AND TO_CHAR(a.dt_start_date,'YYYYMMDD') = TO_CHAR(sysdate+3,'YYYYMMDD')
				AND a.vc_dept_code = '$depcd' ";				
		$stmt = $conn->prepare($sql);
		$data2 = array();
		if($stmt->execute() or die($stmt->errorInfo()[2])){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$data2[] = $row;
			}
		}
		if(!empty($data2)){
			// Jika ada yang mendekati expired date
			$i = 1;
			$email_msg1 .= "Dear Sir/Madam, <br><br> ";
			$email_msg1 .= "Kindly take necessary action from your " .$depnm. "@PM Schedule/Work Order below.<br>";
			$email_msg2 .= "<table border='1'>";
			$email_msg2 .= "<tr><th>No.</th><th>Doc. No.</th><th>PM Schedule/Work Order</th><th>Asset/Equipment</th><th>Expired Date</th><th>Remarks</th></tr>";
			foreach ($data2 as $val2) {
				$email_msg2 .= "<tr><td>$i.</td><td>".$val2["DOC_NO"]."</td><td>".$val2["DOC_DESC"]."</td><td>".$val2["ASET_DESC"]."</td><td>".$val2["START_DATE"]."</td><td>".$val2["REMARKS"]."</td></tr>";
				$i++;
			}
			$email_msg2 .= "</table><br>";
			$email_msg3 .= "Note: This is system generated reminder email,<br>";
			$email_msg3 .= "Please ignore if you have completed for those documents.<br>";
		} else {
			$email_msg1 .= "Dear Sir/Madam, <br><br>";
			$email_msg2 = "<p>There is no CMMS-PM reminder for " .$depnm. " today</p>";
			$email_msg3 .= "Note: This is system generated reminder email<br>";
		}
		$email_msg .= $email_msg1. '<br>' .$email_msg2. '<br>' .$email_msg3;
		
		$recipient = array();

		$sql = "SELECT a.vc_email vemail, a.vc_seq as vseq
				  FROM MAIL_LIST_CMMS a, costing.Mst_Department b
				 WHERE a.vc_comp_code = '01'
				   AND a.vc_status = 'Y'
				   AND a.vc_program_code = 'CPM' 
				   AND a.vc_comp_code = b.vc_comp_code
				   AND a.vc_dept_code = b.Vc_Dept_Code
				   AND a.vc_dept_code = '$depcd'
				 ORDER BY a.vc_seq ";
		$stmt = $conn->prepare($sql);
		$data3 = array();
		if($stmt->execute() or die($stmt->errorInfo()[2])){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$data3[] = $row;
			}
		}
		$i = 0;
		foreach ($data3 as $val3) {
			$seq = $val3["VSEQ"];
			$email = $val3["VEMAIL"];
			if ($seq == 1) {
				$recipient[$i]["type"] = "ADD";
			} else {
				$recipient[$i]["type"] = "CC";
			}
			$recipient[$i]["email"] = $email;
			$i++;
		}
		/*
		$recipient[0]["type"] = "ADD";
		$recipient[0]["email"] = "nisa.meilana@mittalsteel.com";
		$recipient[1]["type"] = "CC";
		$recipient[1]["email"] = "hary.purwantoro@mittalsteel.com";
		$recipient[2]["type"] = "CC";
		$recipient[2]["email"] = "vicky.ardiansyah@mittalsteel.com";
		*/
		$mail = new SendMail();
		$mail->sendTheMailAdv("CMMS-PM Reminder 3 days before expired for " .$depnm, $email_msg, $recipient);
		$email_msg1 = $email_msg2 = $email_msg3 = $email_msg = '';
		echo $email_msg."<BR>";
	}
}

?>