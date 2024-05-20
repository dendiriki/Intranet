<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MobileUser
 *
 * @author dheo
 */
class MobileUser {
	//put your code here
	public function getList() {
		$return = array();
		$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$sql = "select * from makess.mob_mst_user";		
		$stmt = $conn->prepare($sql);
		if($stmt->execute()) {
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$return[] = $row;
      }			
    } 
    $stmt = null;
    $conn = null;
    return $return;
	}
	
	public function delKunnr($usrid) {
		if(empty($usrid)) {return false;}
		$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		$sql = "update makess.mob_mst_user SET kunnr = null WHERE usrid = :usrid";		
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(":usrid", strtoupper($usrid), PDO::PARAM_STR);
		if($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	public function addKunnr($usrid,$kunnr) {
		$return = array();
		if(empty($usrid) || empty($kunnr)) {
			$return["status"] = false;
			$return["message"] = "Param Empty";
			return $return;
		}
		$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
		
		$sql = "SELECT name1, anred FROM sapsr3.kna1@dbsap_iip where mandt = '600' AND kunnr = :kunnr";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(":kunnr", strtoupper($kunnr), PDO::PARAM_STR);
		$comp1 = null;
		if($stmt->execute()) {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$comp1 = $row["ANRED"].". ".$row["NAME1"];
      }
		}
		if(empty($comp1)) {
			$return["status"] = false;
			$return["message"] = "Customer Not Found";
			return $return;
		}
		
		$sql = "update makess.mob_mst_user SET kunnr = :kunnr, COMP1 = :comp1 WHERE usrid = :usrid";		
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(":usrid", strtoupper($usrid), PDO::PARAM_STR);
		$stmt->bindValue(":kunnr", strtoupper($kunnr), PDO::PARAM_STR);
		$stmt->bindValue(":comp1", strtoupper($comp1), PDO::PARAM_STR);
		if($stmt->execute()) {
			$return["status"] = true;
			$return["message"] = "Customer Code Linked";
		} else {
			$return["status"] = false;
			$error = $stmt->errorInfo();
			$return["message"] = $error[2];
		}
		return $return;
	}
}
