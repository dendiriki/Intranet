<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of conference
 *
 * @author dheo
 */
class Conference {
  //put your code here
  public function getConferenceRoomList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM int_mst_conf_room ORDER BY conf_room_id ASC";
    
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["CONF_ROOM_ID"];
      $data["name"] = $row["CONF_ROOM_NAME"];
      $data["remark"] = $row["CONF_ROOM_REMARK"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getConferenceRoomById($room_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM int_mst_conf_room where conf_room_id = '$room_id'";
    
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["CONF_ROOM_ID"];
      $data["name"] = $row["CONF_ROOM_NAME"];
      $data["remark"] = $row["CONF_ROOM_REMARK"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  
  public function getConferenceBookingByDateAndRoom($date, $room_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $currdate = new DateTime($date);
    $now = $currdate->format("d-m-Y");
    $currdate->modify('-1 days');
    $prevdate = $currdate->format("d-m-Y");
    $currdate->modify('+2 days');
    $nextdate = $currdate->format("d-m-Y");
    // select +-1 hari ditambah select yang long book
    $sql = "SELECT conf_book_id, conf_room_id, conf_book_long, "
            . "to_char(conf_book_date, 'DD-MM-YYYY') as conf_book_date, "
            . "to_char(conf_book_date_to, 'DD-MM-YYYY') as conf_book_date_to, "
            . "to_char(conf_book_start, 'HH24:MI') as conf_book_start, "
            . "to_char(conf_book_end, 'HH24:MI') as conf_book_end, "
            . "conf_book_by, conf_book_dept, conf_book_remark "
            . "FROM int_trx_conf_book WHERE conf_room_id = '$room_id' "
            . "AND ( conf_book_date <= to_date('".$now."','DD-MM-YYYY') AND conf_book_date_to >= to_date('".$now."','DD-MM-YYYY') )  "
            . "AND conf_book_long = 'Y' "
            . " UNION "
            . "SELECT conf_book_id, conf_room_id, conf_book_long, "
            . "to_char(conf_book_date, 'DD-MM-YYYY') as conf_book_date, "
            . "to_char(conf_book_date_to, 'DD-MM-YYYY') as conf_book_date_to, "
            . "to_char(conf_book_start, 'HH24:MI') as conf_book_start, "
            . "to_char(conf_book_end, 'HH24:MI') as conf_book_end, "
            . "conf_book_by, conf_book_dept, conf_book_remark "
            . "FROM int_trx_conf_book WHERE conf_room_id = '$room_id' "
            . "AND conf_book_date BETWEEN to_date('".$prevdate."','DD-MM-YYYY') AND to_date('".$nextdate."','DD-MM-YYYY') "
            . "AND conf_book_long = 'N' "
            . "ORDER BY conf_book_date, conf_book_start";
    
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["book_id"] = $row["CONF_BOOK_ID"];
      $data["room_id"] = $row["CONF_ROOM_ID"];
      $data["date"] = $row["CONF_BOOK_DATE"];
      if($row["CONF_BOOK_LONG"] == 'Y') {
        $data["date"] = $row["CONF_BOOK_DATE"] . " to " . $row["CONF_BOOK_DATE_TO"];
      }
      $data["start"] = $row["CONF_BOOK_START"];
      $data["end"] = $row["CONF_BOOK_END"];
      $data["by"] = $row["CONF_BOOK_BY"];
      $data["dept"] = $row["CONF_BOOK_DEPT"];
      $data["remark"] = $row["CONF_BOOK_REMARK"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function checkBooking($room_id, $date, $date2, $start, $end, $long_booking) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "";
    if($long_booking == "N") {
      //pengecekan one day booking
      $sql = "SELECT count(*) as jml from int_trx_conf_book 
              WHERE conf_room_id = '$room_id' 
              AND conf_book_long = 'N' 
              AND to_char(conf_book_date, 'DD-MM-YYYY') = '$date' 
              AND ( (to_char(conf_book_start, 'HH24:MM') BETWEEN '$start' AND '$end') 
              OR (to_char(conf_book_end, 'HH24:MM') BETWEEN '$start' AND '$end') ) "
              . " UNION " .
              "SELECT count(*) as jml from int_trx_conf_book 
              WHERE conf_room_id = '$room_id' 
              AND conf_book_long = 'Y' 
              AND ( to_char(conf_book_date, 'DD-MM-YYYY') <= '$date' AND to_char(conf_book_date_to, 'DD-MM-YYYY') >= '$date' ) ";              
    } else if($long_booking == "Y") {
      //pengecekan long booking
      $sql = "SELECT count(*) as jml from int_trx_conf_book 
              WHERE conf_room_id = '$room_id' 
              AND to_char(conf_book_date, 'DD-MM-YYYY') BETWEEN '$date' AND '$date2' "
              . " UNION " .
              "SELECT count(*) as jml from int_trx_conf_book 
              WHERE conf_room_id = '$room_id' 
              AND to_char(conf_book_date_to, 'DD-MM-YYYY') BETWEEN '$date' AND '$date2' ";
    }
      
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data += $row["JML"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;    
  }
  
  public function insertBooking($room_id, $date, $date2, $start, $end, $by, $dept, $remark, $ip, $long_book) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_trx_conf_book 
            (conf_room_id, 
            conf_book_date, 
            conf_book_date_to, 
            conf_book_start, 
            conf_book_end, 
            conf_book_by, 
            conf_book_dept, 
            conf_book_remark, 
            conf_book_ip_addr,
            conf_book_long)
            VALUES ('$room_id', 
            to_date('$date', 'DD-MM-YYYY'), 
            to_date('$date2', 'DD-MM-YYYY'), 
            to_date('".$date." ".$start."', 'DD-MM-YYYY HH24:MI'), 
            to_date('".$date." ".$end."', 'DD-MM-YYYY HH24:MI'), 
            '$by', 
            '$dept', 
            '$remark', 
            '$ip', 
            '$long_book')";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    oci_free_statement($st);
    oci_close($conn);
    return true; 
  }
}
