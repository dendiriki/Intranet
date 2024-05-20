<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SapCommon
 *
 * @author dheo
 */
class SapCommon {
  //put your code here
  public function getDiskon($vbeln) {
    $return = array();
    $conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $sql = "select a.vbeln, a.posnr, a.matnr, a.kbetr_max, b.kunnr, c.name1 from sapsr3.zsd_so_discount@dbsap_iip a 
            inner join sapsr3.vbak@dbsap_iip b on b.vbeln = a.vbeln and a.mandt = b.mandt 
            inner join sapsr3.kna1@dbsap_iip c on c.kunnr = b.kunnr and a.mandt = c.mandt 
            where a.vbeln = :vbeln and a.mandt = '600' order by posnr asc";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":vbeln", $vbeln, PDO::PARAM_STR);
    if($stmt->execute()) {
      $data = array();
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {        
        $data[] = $row;
      }
      $return["data"] = $data;
      $return["status"] = true;
    } else {
      $return["status"] = false;
      $error = $stmt->errorInfo();
      $return["message"] = trim(str_replace("\n", " ", $error[2]));
    }
    $stmt = null;
    $conn = null;
    return $return;
  }
  
  public function updateDiscount($vbeln,$kbetr_max) {
    $return = array();
    $conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $sql = "update sapsr3.zsd_so_discount@dbsap_iip 
            set kbetr_max = :kbetr_max
            where mandt = '600' AND vbeln = :vbeln";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":kbetr_max", $kbetr_max, PDO::PARAM_STR);
    $stmt->bindValue(":vbeln", $vbeln, PDO::PARAM_STR);
    if($stmt->execute()) {
      $return["status"] = true;
    } else {
      $return["status"] = false;
      $error = $stmt->errorInfo();
      $return["message"] = trim(str_replace("\n", " ", $error[2]));
    }
    $stmt = null;
    $conn = null;
    return $return;
  }
}
