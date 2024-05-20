<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SapUser
 *
 * @author dheo
 */
class SapUser {
  //put your code here
  public function getList($search = "*") {
    $return = array();
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    
    $sql = "select * from sapsr3.V_USR_NAME@dbsap_iip where mandt = '600'";
    if($search != "*") {
      $sql .= " AND bname LIKE '%$search%'";
    }
    
    $st = oci_parse($conn, $sql) or die("Query Parsing Error");
    
    oci_execute($st) or die("Query Execution Error");
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $return[] = $row;
    }
    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function unlockAccount($username) {
    if(empty($username)) {
      return false;
    }
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN);
    $sql = "UPDATE sapsr3.usr02@DBSAP_IIP SET uflag = '0' WHERE bname = '$username'";
    $st = oci_parse($conn, $sql) or die("Query Parsing Error");
    
    oci_execute($st) or die("Query Execution Error");
    
    return true;
  }
}