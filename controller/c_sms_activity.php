<?php
if($action == "sms_activity") {
	if(isset($_FILES["excel"])) {
		$conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
		
		require('cron/spreadsheet-reader/php-excel-reader/excel_reader2.php');
		require('cron/spreadsheet-reader/SpreadsheetReader.php');
		
		$sap_mk_datetime = date("d.m.Y-H.i");
		
		$excel = $_FILES["excel"];
		$reader = new Spreadsheet_Excel_Reader();
		$reader->setUTFEncoder('iconv');
		$reader->setOutputEncoding('UTF-8');
		$reader->read($excel["tmp_name"]);
		
		$i = 0;
		foreach($reader->sheets[0]["cells"] as $row) {
			if($i > 0 && !empty($row[1])) {	
				echo "Processing line $i - Heat Num = ".$row[2]." - Activity = ".$row[3]."<BR>";
				$type = $row[3];
				$arr_posting_date = explode(".", $row[16]);
				$posting_date = $arr_posting_date[2].$arr_posting_date[1].$arr_posting_date[0];
				if($type == "SMS1") {
					$sql_sms1 = "insert into sapsr3.ZPP_SMS_IB_ACTIV@dbsap_iip (
								 mandt, heat_num, op_num, wc, 
								 arcing_time, uom1, 
								 tap2tap_time, uom2, 
								 idle_time, uom3, 
								 lrf_parking_tim, uom4, 
								 lrf_tapping, uom12, 
								 lrf_pwer_1temp, uom13,
								 oxygen_cons, uom5,
								 eaf_gas_cons, uom6,
								 tapping_temp, uom7,
								 first_lrf_temp, uom8,
								 last_lrf_temp, uom9,
								 eaf_power, uom10,
								 lrf_pwer, uom11, 
								 posting_date,
								 shift,
								 makess_status,
								 sap_status,
								 makess_date_time,
								 sap_date_time,
								 makess_message,
								 sap_message,
								 zeaftap
								 ) values (
								 '600', '".$row[2]."', '0010', 'SMS1', 
								 '".$row[4]."', 'MIN', 
								 '".$row[5]."', 'MIN', 
								 '".$row[6]."', 'MIN', 
								 '".$row[7]."', 'MIN', 
								 '0', 'MIN', 
								 '0', 'KWH',
								 '0', ' ',
								 '0', ' ',
								 '0', ' ',
								 '0', ' ',
								 '0', ' ',
								 '0', 'KWH',
								 '0', 'KWH', 
								 '".$posting_date."',
								 '".$row[17]."',
								 'C',
								 'U',
								 '$sap_mk_datetime',
								 '$sap_mk_datetime',
								 'WRITE TO SAP FROM MAKESS',
								 ' ',
								 ' '
								 )";
					$conn->exec($sql_sms1) or die("ERROR : ".$conn->errorInfo()[2]."<BR>".$sql_sms1);
				} else if($type == "SMS2") {
					$sql_sms2 = "insert into sapsr3.ZPP_SMS_IB_ACTIV@dbsap_iip (
								 mandt, heat_num, op_num, wc, 
								 arcing_time, uom1, 
								 tap2tap_time, uom2, 
								 idle_time, uom3, 
								 lrf_parking_tim, uom4, 
								 lrf_tapping, uom12, 
								 lrf_pwer_1temp, uom13,
								 oxygen_cons, uom5,
								 eaf_gas_cons, uom6,
								 tapping_temp, uom7,
								 first_lrf_temp, uom8,
								 last_lrf_temp, uom9,
								 eaf_power, uom10,
								 lrf_pwer, uom11, 
								 posting_date,
								 shift,
								 makess_status,
								 sap_status,
								 makess_date_time,
								 sap_date_time,
								 makess_message,
								 sap_message,
								 zeaftap
								 ) values (
								 '600', '".$row[2]."', '0020', 'SMS2', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '".$row[9]."', 'M3',
								 '".$row[10]."', 'M3',
								 '".$row[11]."', 'GC',
								 '".$row[12]."', 'GC',
								 '0', 'GC',
								 '0', 'KWH',
								 '0', 'KWH', 
								 '".$posting_date."',
								 '".$row[17]."',
								 'C',
								 'U',
								 '$sap_mk_datetime',
								 '$sap_mk_datetime',
								 'WRITE TO SAP FROM MAKESS',
								 ' ',
								 ' '
								 )";
					$conn->exec($sql_sms2) or die("ERROR : ".$conn->errorInfo()[2]."<BR>".$sql_sms2);
				} else if($type == "SMS4") {
					$sql_sms4 = "insert into sapsr3.ZPP_SMS_IB_ACTIV@dbsap_iip (
								 mandt, heat_num, op_num, wc, 
								 arcing_time, uom1, 
								 tap2tap_time, uom2, 
								 idle_time, uom3, 
								 lrf_parking_tim, uom4, 
								 lrf_tapping, uom12, 
								 lrf_pwer_1temp, uom13,
								 oxygen_cons, uom5,
								 eaf_gas_cons, uom6,
								 tapping_temp, uom7,
								 first_lrf_temp, uom8,
								 last_lrf_temp, uom9,
								 eaf_power, uom10,
								 lrf_pwer, uom11, 
								 posting_date,
								 shift,
								 makess_status,
								 sap_status,
								 makess_date_time,
								 sap_date_time,
								 makess_message,
								 sap_message,
								 zeaftap
								 ) values (
								 '600', '".$row[2]."', '0040', 'SMS4', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ', 
								 '0', ' ',
								 '".$row[14]."', 'KWH',
								 '".$row[15]."', 'KWH', 
								 '".$posting_date."',
								 '".$row[17]."',
								 'C',
								 'U',
								 '$sap_mk_datetime',
								 '$sap_mk_datetime',
								 'WRITE TO SAP FROM MAKESS',
								 ' ',
								 '".$row[20]."'
								 )";
					$conn->exec($sql_sms4) or die("ERROR : ".$conn->errorInfo()[2]."<BR>".$sql_sms4);
				}
			}			
			$i++;
		}
		$data_processed = $i-1;
		echo $data_processed." Data was processed <BR>";
	} else {
		require( TEMPLATE_PATH . "/t_sms_activity.php" );
	}
}
?>