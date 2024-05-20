<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of callendar
 *
 * @author dheo
 */
class Callendar {
  protected $table_name = "int_trx_holiday_cal";
  
  public $year = null;
  public $start = null;
  public $end = null;
  public $title = null;
  public $type = null; /* N = National Holiday, I = Company Holiday, C = Cuti Bersama */
  //put your code here
  public function getHolidayCallendar($year) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT TO_CHAR(cal_start, 'YYYY-MM-DD') as cal_start, TO_CHAR(cal_end, 'YYYY-MM-DD') as cal_end, cal_title, cal_type "
            . "FROM $this->table_name WHERE cal_year = '$year' order by cal_start ASC";

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['title'] = $row["CAL_TITLE"];
      $data['start'] = $row["CAL_START"];
      if (!empty($row["CAL_END"])) {
        $data['start'] = $row["CAL_START"]."T00:00:00";
        $data['end'] = $row["CAL_END"]."T23:59:59";
      }
      switch ($row["CAL_TYPE"]) {
        case "N" :
          $data['color'] = "#c62828";
          break;
        case "I":
          $data['color'] = "#1565c0";
          break;
        case "C":
          $data['color'] = "#7b1fa2";
          break;
      }
      $data["textColor"] = "#fff";
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function insert() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "insert into $this->table_name values('$this->year','$this->start','$this->end','$this->title','$this->type')";

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    

    oci_free_statement($st);
    oci_close($conn);
    return TRUE;
  }
  
  public function update($rowid) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "update $this->table_name "
            . "set cal_year = '$this->year', cal_start = '$this->start', cal_end = '$this->end', cal_type = '$this->type' "
            . "where rowid = '$rowid'";

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    

    oci_free_statement($st);
    oci_close($conn);
    return TRUE;
  }
  
  public function delete($rowid) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "delete $this->table_name where rowid = '$rowid'";

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    

    oci_free_statement($st);
    oci_close($conn);
    return TRUE;
  }
}
