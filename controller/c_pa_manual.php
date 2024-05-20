<?php
if($action == "pa_manual") {
	$conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
	
	$sql = "select * from makess.mst_company where ch_active = 'Y' order by vc_comp_code ASC";
	$stmt = $conn->prepare($sql);
	
	$company = array();
	if($stmt->execute()) {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$company[] = $row;
		}
	}
	
	$group = array();
	$group[0]["id"] = "S";
	$group[0]["name"] = "SMS (INDO)";
	$group[1]["id"] = "M";
	$group[1]["name"] = "Office (INDO)";
	$group[2]["id"] = "R";
	$group[2]["name"] = "Rolling Mill (INDO)";
	$group[3]["id"] = "O";
	$group[3]["name"] = "Office (IWP)";
	$group[4]["id"] = "T";
	$group[4]["name"] = "Lapangan (IWP)";
	
	if(isset($_POST["save"])) {
		$VC_COMP_CODE = $_POST["VC_COMP_CODE"];
		$DT_PERIOD_DT = $_POST["DT_PERIOD_DT"];
		$VC_GROUP = $_POST["VC_GROUP"];
		$NU_LOAN_AMOUNT = str_replace(",", ".", $_POST["NU_LOAN_AMOUNT"]);
		
		$sql_i = "INSERT INTO hrpay.emp_loan_premium VALUES ('$VC_COMP_CODE',TO_DATE('$DT_PERIOD_DT','YYYY-MM-DD'),'$VC_GROUP','$NU_LOAN_AMOUNT',SYSDATE,'INTRANET','IND-WWW02','X')";
		$conn->exec($sql_i) or die($conn->errorInfo()[2]);
		$success = "Data Saved";
	}
	
	require( TEMPLATE_PATH . "/t_pa_manual.php" );
}
?>