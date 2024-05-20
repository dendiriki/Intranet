<?php
ini_set( "error_reporting" , E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED );
ini_set( "error_log" , "log/php-error.log" );
ini_set( "display_errors", true );

define( "PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" ); //Local
define( "DB_USERNAME", "hrpay" );
define( "DB_PASSWORD", "hrpay" );

include "classes/SendMail.php";

$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);

$today = date("dm");
$sql = "SELECT a.vc_comp_code, a.vc_emp_code, a.vc_first_name, to_char(a.dt_date_of_birth,'DD-MM-YYYY') as birth_date, b.vc_company_name, c.vc_dept_name 
       from hrpay.mst_employee a 
       inner join makess.mst_company b on b.vc_comp_code = a.vc_comp_code 
       left join hrpay.mst_dept c on c.vc_comp_code = a.vc_comp_code and c.vc_dept_code = a.vc_dept_code 
       where to_char(a.dt_date_of_birth,'DDMM') = '1304' and a.dt_resignation_date is null 
union 
SELECT a.vc_comp_code, a.vc_emp_code, a.vc_first_name, to_char(a.dt_date_of_birth,'DD-MM-YYYY') as birth_date, b.vc_company_name, 'EXPATRIATE' as vc_dept_name 
       from hrpay.mst_employee_expat a 
       inner join makess.mst_company b on b.vc_comp_code = a.vc_comp_code 
       where to_char(a.dt_date_of_birth,'DDMM') = '1304' and a.vc_status = 'A'";

$stmt = $conn->prepare($sql);


$data = array();
if($stmt->execute() or die($stmt->errorInfo()[2])) {
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data[] = $row;
	}
}

if(!empty($data)) {
	$email_msg = "<table border='1'>";
	//echo "<table border='2'>";
	$email_msg .= "<tr><th>Company</th><th>Department</th><th>Name</th><th>Birth Date</th></tr>";
	foreach ($data as $row) {
		$email_msg .= "<tr><td>".$row["VC_COMPANY_NAME"]."</td><td>".$row["VC_DEPT_NAME"]."</td><td>".$row["VC_FIRST_NAME"]."</td><td>".$row["BIRTH_DATE"]."</td></tr>";
		//echo "<tr><td>".$row["VC_COMPANY_NAME"]."</td><td>".$row["VC_FIRST_NAME"]."</td><td>".$row["BIRTH_DATE"]."</td></tr>";
	}
	$email_msg .= "</table>";
	//echo "</table>";
} else {
	$email_msg = "<p>No Employee Birthday Today</p>";
}

echo $email_msg."<BR>";

$mail = new SendMail();

$recipient = array();
/*$recipient[0]["type"] = "ADD";
$recipient[0]["email"] = "dheo.pratama@ispatindo.com";*/

$recipient[0]["type"] = "ADD";
$recipient[0]["email"] = "Fenny.Kusumawardani@mittalsteel.com";
$recipient[2]["type"] = "BCC";
$recipient[2]["email"] = "vicky.ardiansyah@mittalsteel.com";
$recipient[3]["type"] = "BCC";
$recipient[3]["email"] = "hary.purwantoro@mittalsteel.com";

$mail->sendTheMailAdv("Employee Birthday on 13 April", $email_msg, $recipient);

$myfile = fopen("birthday_job_log.txt", "w") or die("Unable to open file!");
$txt = "Job ".date("Y-m-d")." running \n";
fwrite($myfile, $txt);
fclose($myfile);
?>