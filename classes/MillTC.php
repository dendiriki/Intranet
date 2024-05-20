<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MillTC
 *
 * @author dheo
 */
class MillTC {
	//put your code here
	
	public function insert($data = array()) {
		$return = array();
		if(empty($data)) {
			$return["status"] = false;
			$return["message"] = "Data empty";
		} else {
			$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
			$sql = "INSERT INTO sapsr3.ztpp_mtc@dbsap_iip "
							. "(mandt,werks,ebeln,charg,zqty_c,zqty_p,zqty_s,zqty_si,zqty_al,zqty_cu,zqty_ni,zqty_cr,zqty_mo,zqty_v,zqty_n2,zgrade) "
							. "values ('600',:werks,:ebeln,:charg,:zqty_c,:zqty_p,:zqty_s,:zqty_si,:zqty_al,:zqty_cu,:zqty_ni,:zqty_cr,:zqty_mo,:zqty_v,:zqty_n2,:zgrade)";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(":werks", $data["werks"], PDO::PARAM_STR);
			$stmt->bindValue(":ebeln", $data["ebeln"], PDO::PARAM_STR);
			$stmt->bindValue(":charg", $data["charg"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_c", $data["zqty_c"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_p", $data["zqty_p"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_s", $data["zqty_s"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_si", $data["zqty_si"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_al", $data["zqty_al"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_cu", $data["zqty_cu"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_ni", $data["zqty_ni"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_cr", $data["zqty_cr"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_mo", $data["zqty_mo"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_v", $data["zqty_v"], PDO::PARAM_STR);
			$stmt->bindValue(":zqty_n2", $data["zqty_n2"], PDO::PARAM_STR);
			$stmt->bindValue(":zgrade", $data["zgrade"], PDO::PARAM_STR);
			if($stmt->execute()) {
				$return["status"] = true;
			} else {
				$return["status"] = false;
				$error = $stmt->errorInfo();
				$return["message"] = trim(str_replace("\n", " ", $error[2]));
			}
		}
		$stmt = null;
    $conn = null;
		return $return;
	}
}
