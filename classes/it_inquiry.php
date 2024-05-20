<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of it_inquiry
 *
 * @author dheo
 */
class ItInquiry {

  //put your code here
  public $id = null;
  public $up_category = null;
  public $up_category_desc = null;
  public $category = null;
  public $category_desc = null;
  public $subject = null;
  public $detail = null;
  public $req_by = null;
  public $req_name = null;
  public $status = null;
  public $status_desc = null;
  public $priority = null;
  public $priority_desc = null;
  public $priority_color = null;
  public $pic = null;
  public $pic_name = null;
  public $solution = null;
  public $create_by = null;
  public $create_name = null;
  public $create_date = null;
  public $closed_date = null;
  public $status_color = null;
  public $last_change_date = null;
  public $last_change_by = null;
  public $last_change_name = null;
  protected $table_name = "INT_TRX_INQ_TICKET";

  public function __construct($data = array()) {
    if (isset($data["id"]))
      $this->id = $data["id"];
    if (isset($data["up_category"]))
      $this->up_category = $data["up_category"];
    if (isset($data["up_category_desc"]))
      $this->up_category_desc = $data["up_category_desc"];
    if (isset($data["category"]))
      $this->category = $data["category"];
    if (isset($data["category_desc"]))
      $this->category_desc = $data["category_desc"];
    if (isset($data["subject"]))
      $this->subject = $data["subject"];
    if (isset($data["detail"]))
      $this->detail = $data["detail"];
    if (isset($data["req_by"]))
      $this->req_by = $data["req_by"];
    if (isset($data["status"]))
      $this->status = $data["status"];
    if (isset($data["status_desc"]))
      $this->status_desc = $data["status_desc"];
    if (isset($data["priority"]))
      $this->priority = $data["priority"];
    if (isset($data["priority_desc"]))
      $this->priority_desc = $data["priority_desc"];
    if (isset($data["priority_color"]))
      $this->priority_color = $data["priority_color"];
    if (isset($data["pic"]))
      $this->pic = $data["pic"];
    if (isset($data["solution"]))
      $this->solution = $data["solution"];
    if (isset($data["create_by"]))
      $this->create_by = $data["create_by"];
    if (isset($data["create_date"]))
      $this->create_date = $data["create_date"];
    if (isset($data["closed_date"]))
      $this->closed_date = $data["closed_date"];
    if (isset($data["req_name"]))
      $this->req_name = $data["req_name"];
    if (isset($data["pic_name"]))
      $this->pic_name = $data["pic_name"];
    if (isset($data["create_name"]))
      $this->create_name = $data["create_name"];
    if (isset($data["status_color"]))
      $this->status_color = $data["status_color"];
    if (isset($data["last_change_date"]))
      $this->last_change_date = $data["last_change_date"];
    if (isset($data["last_change_by"]))
      $this->last_change_by = $data["last_change_by"];
    if (isset($data["last_change_name"]))
      $this->last_change_name = $data["last_change_name"];
  }

  public function setData($data = array()) {
    if (isset($data["id"]))
      $this->id = $data["id"];
    if (isset($data["up_category"]))
      $this->up_category = $data["up_category"];
    if (isset($data["up_category_desc"]))
      $this->up_category_desc = $data["up_category_desc"];
    if (isset($data["category"]))
      $this->category = $data["category"];
    if (isset($data["category_desc"]))
      $this->category_desc = $data["category_desc"];
    if (isset($data["subject"]))
      $this->subject = $data["subject"];
    if (isset($data["detail"]))
      $this->detail = $data["detail"];
    if (isset($data["req_by"]))
      $this->req_by = $data["req_by"];
    if (isset($data["status"]))
      $this->status = $data["status"];
    if (isset($data["status_desc"]))
      $this->status_desc = $data["status_desc"];
    if (isset($data["priority"]))
      $this->priority = $data["priority"];
    if (isset($data["priority_desc"]))
      $this->priority_desc = $data["priority_desc"];
    if (isset($data["priority_color"]))
      $this->priority_color = $data["priority_color"];
    if (isset($data["pic"]))
      $this->pic = $data["pic"];
    if (isset($data["solution"]))
      $this->solution = $data["solution"];
    if (isset($data["create_by"]))
      $this->create_by = $data["create_by"];
    if (isset($data["create_date"]))
      $this->create_date = $data["create_date"];
    if (isset($data["closed_date"]))
      $this->closed_date = $data["closed_date"];
    if (isset($data["req_name"]))
      $this->req_name = $data["req_name"];
    if (isset($data["pic_name"]))
      $this->pic_name = $data["pic_name"];
    if (isset($data["create_name"]))
      $this->create_name = $data["create_name"];
    if (isset($data["status_color"]))
      $this->status_color = $data["status_color"];
    if (isset($data["last_change_date"]))
      $this->last_change_date = $data["last_change_date"];
    if (isset($data["last_change_by"]))
      $this->last_change_by = $data["last_change_by"];
    if (isset($data["last_change_name"]))
      $this->last_change_name = $data["last_change_name"];
  }

  public function getById($id) {
    if (!empty($id)) {
      $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
      $sql = "SELECT a.*, to_char(a.tic_created_dt, 'DD-MON-YYYY HH24:MI') AS crtd_dt,  b.cat_desc, b.cat_sub, c.vc_name FROM $this->table_name a "
              . "LEFT JOIN int_mst_inq_category b ON b.cat_id = a.tic_cat_id "
              . "LEFT JOIN int_mst_user c ON c.vc_username = a.tic_req_by "
              . "WHERE a.tic_id = '$id'";
      $st = oci_parse($conn, $sql);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      oci_execute($st) or die(oci_error($conn)["message"]);
      $data = array();
      if (($row = oci_fetch_assoc($st)) != false) {
        $data['id'] = $row["TIC_ID"];
        $data["up_category"] = $row["CAT_SUB"];

        if ($data["up_category"] == "H") {
          $data["up_category_desc"] = "HARDWARE";
        } else if ($data["up_category"] == "S") {
          $data["up_category_desc"] = "SOFTWARE";
        }

        $data["category"] = $row["TIC_CAT_ID"];
        $data["category_desc"] = $row["CAT_DESC"];
        $data["subject"] = $row["TIC_SUBJECT"];
        $data["detail"] = $row["TIC_DETAIL"];
        $data["req_by"] = $row["TIC_REQ_BY"];
        $data["req_name"] = $row["VC_NAME"];

        $data["status"] = $row["TIC_STATUS"];
        if ($data["status"] == "O") {
          $data["status_desc"] = "OPEN";
        } else if ($data["status"] == "P") {
          $data["status_desc"] = "ON PROGRESS";
        } else if ($data["status"] == "N") {
          $data["status_desc"] = "NEED CONFIRMATION";
        } else if ($data["status"] == "C") {
          $data["status_desc"] = "CANCELED";
        } else if ($data["status"] == "X") {
          $data["status_desc"] = "CLOSED";
        }

        $data["priority"] = $row["TIC_PRIORITY"];
        if ($data["priority"] == "H") {
          $data["priority_desc"] = "HIGH";
        } else if ($data["priority"] == "M") {
          $data["priority_desc"] = "MIDDLE";
        } else if ($data["priority"] == "L") {
          $data["priority_desc"] = "LOW";
        }

        $data["pic"] = $row["TIC_PIC"];
        $data["solution"] = $row["TIC_SOLUTION"];
        $data["create_by"] = $row["TIC_CREATED_BY"];
        $data["create_date"] = $row["CRTD_DT"];
        $data["closed_date"] = $row["TIC_CLOSED_DT"];
      }

      oci_free_statement($st);
      oci_close($conn);
      return new ItInquiry($data);
    } else {
      return false;
    }
  }

  public function getList($limit, $page, $filter = array(), $username = "*") {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    if ($page == 0) {
      $page = 1;
		}
    $offset2 = $page * $limit;
    $offset1 = ($offset2 - $limit) + 1;
    $sql_count = "SELECT count(*) cnt FROM $this->table_name a "
            . "INNER JOIN int_mst_inq_category b ON b.cat_id = a.tic_cat_id ";
    if ($username != "*") {
      $sql_count .= "WHERE a.tic_req_by = '$username' or a.tic_created_by = '$username'";
    }
    if (isset($filter["category"])) {
      if (!empty($filter["category"])) {
        $sql_count .= "AND b.cat_sub = '" . $filter["category"] . "' ";
      }
    }
    if (isset($filter["priority"])) {
      if (!empty($filter["priority"])) {
        $sql_count .= "AND a.tic_priority = '" . $filter["priority"] . "' ";
      }
    }
    
    if (isset($filter["status"])) {
      if (!empty($filter["status"])) {
        $arrayStatus = array();
        foreach($filter["status"] as $valStatus) {
          if(strlen($valStatus) == 0) {
            continue;
          } else {
            $arrayStatus[] = "'".$valStatus."'";
          }      
        }
        if(count($arrayStatus)>0) {
          $status = implode(",",$arrayStatus);
          $sql_count .= "AND a.tic_status IN (" . $status . ") ";
        }        
      }
    }
    if (isset($filter["created_date"])) {
      if (!empty($filter["created_date"])) {
        $sql_count .= "AND to_char(a.tic_created_dt,'DD-MM-YYYY') = '" . $filter["created_date"] . "' ";
      }
    }
    if (isset($filter["pic"])) {
      if (!empty($filter["pic"])) {
        $sql_count .= "AND a.tic_pic = '" . $filter["pic"] . "' ";
      }
    }
    
    if (isset($filter["subject"])) {
      if (!empty($filter["subject"])) {
        $sql_count .= "AND UPPER(a.tic_subject) LIKE '%" . strtoupper($filter["subject"]) . "%' ";
      }
    }
    $st = oci_parse($conn, $sql_count);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $count = 0;
    $page = 0;
    if (($row = oci_fetch_assoc($st)) != false) {
      $count = $row["CNT"];
      if ($count >= 1) {
        $page = ceil($count / $limit);
      }
    }

    $sql = "SELECT * FROM(
            SELECT ROWNUM rn, t.* FROM (
            SELECT a.*, to_char(a.tic_created_dt, 'DD/MM/YY HH24:MI') AS crtd_dt, 
            to_char(a.TIC_LAST_CH_DT, 'DD/MM/YY HH24:MI') AS ch_dt, 
            b.cat_desc, b.cat_sub, 
            c.vc_name as req_name, 
            d.vc_name as pic_name, 
            e.vc_name as create_name,
            f.st_desc, f.st_color_code,
            g.pr_desc, g.pr_color_code,
            h.cat_desc as sup_desc 
            FROM $this->table_name a 
            LEFT JOIN int_mst_inq_category b ON b.cat_id = a.tic_cat_id 
            LEFT JOIN int_mst_user c on c.vc_username = a.tic_req_by 
            LEFT JOIN int_mst_user d on d.vc_username = a.tic_pic 
            LEFT JOIN int_mst_user e on e.vc_username = a.tic_created_by 
            LEFT JOIN int_mst_inq_status f on f.st_id = a.tic_status 
            LEFT JOIN int_mst_inq_priority g on g.pr_id = a.tic_priority 
            LEFT JOIN int_mst_inq_cat_sup h ON h.cat_sub = b.cat_sub 
            WHERE 1=1 ";
    if (isset($filter["category"])) {
      if (!empty($filter["category"])) {
        $sql .= "AND b.cat_sub = '" . $filter["category"] . "' ";
      }
    }
    if (isset($filter["priority"])) {
      if (!empty($filter["priority"])) {
        $sql .= "AND a.tic_priority = '" . $filter["priority"] . "' ";
      }
    }
    if (isset($filter["status"])) {
      if (!empty($filter["status"])) {
        $arrayStatus = array();
        foreach($filter["status"] as $valStatus) {
          if(strlen($valStatus) == 0) {
            continue;
          } else {
            $arrayStatus[] = "'".$valStatus."'";
          } 
        }
        if(count($arrayStatus)>0) {
          $status = implode(",",$arrayStatus);
          $sql .= "AND a.tic_status IN (" . $status . ") ";
        }
      }
    }
    if (isset($filter["created_date"])) {
      if (!empty($filter["created_date"])) {
        $sql .= "AND to_char(a.tic_created_dt,'DD-MM-YYYY') = '" . $filter["created_date"] . "' ";
      }
    }
    if (isset($filter["pic"])) {
      if (!empty($filter["pic"])) {
        $sql .= "AND a.tic_pic = '" . $filter["pic"] . "' ";
      }
    }
    
    if (isset($filter["subject"])) {
      if (!empty($filter["subject"])) {
        $sql .= "AND UPPER(a.tic_subject) LIKE '%" . strtoupper($filter["subject"]) . "%' ";
      }
    }
    
    if ($username != "*") {
      $sql .= "AND a.tic_req_by = '$username' or a.tic_created_by = '$username' ";
    }

    $sql .= "ORDER BY tic_status asc, TIC_LAST_CH_DT DESC NULLS LAST) t ) 
            WHERE rn BETWEEN $offset1 AND $offset2 ";

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $list = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['id'] = $row["TIC_ID"];
      $data["category"] = $row["TIC_CAT_ID"];
      $data["category_desc"] = $row["CAT_DESC"];
      $data["subject"] = $row["TIC_SUBJECT"];
      $data["detail"] = $row["TIC_DETAIL"];
      $data["req_by"] = $row["TIC_REQ_BY"];
      $data["status"] = $row["TIC_STATUS"];
      $data["status_desc"] = $row["ST_DESC"];
      $data["status_color"] = $row["ST_COLOR_CODE"];
      $data["priority"] = $row["TIC_PRIORITY"];
      $data["priority_desc"] = $row["PR_DESC"];
      $data["priority_color"] = $row["PR_COLOR_CODE"];
      $data["pic"] = $row["TIC_PIC"];
      $data["solution"] = $row["TIC_SOLUTION"];
      $data["create_by"] = $row["TIC_CREATED_BY"];
      $data["create_date"] = $row["CRTD_DT"];
      $data["closed_date"] = $row["TIC_CLOSED_DT"];
      $data["req_name"] = $row["REQ_NAME"];
      $data["pic_name"] = $row["PIC_NAME"];
      $data["create_name"] = $row["CREATE_NAME"];

      $data["up_category"] = $row["CAT_SUB"];
      $data["up_category_desc"] = $row["SUP_DESC"];
      $data["last_change_date"] = $row["CH_DT"];

      $list[] = new ItInquiry($data);
    }
    $return["list"] = $list;
    $return["page"] = $page;
    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }

  public function insert() {
    if (empty($this->id)) {
      $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
      $ch_dt = date("d-m-Y H:i");
      $sql = "INSERT INTO $this->table_name "
              . "(tic_cat_id, tic_subject, tic_detail, tic_req_by, tic_status, tic_priority, tic_pic, tic_solution, tic_created_by, tic_created_dt, TIC_LAST_CH_DT, TIC_LAST_CH_BY, tic_closed_dt) "
              . "VALUES ('$this->category', :tic_subject, :tic_detail, '$this->req_by', '$this->status', '$this->priority', :tic_pic, :tic_solution, '$this->create_by', TO_DATE('$this->create_date','DD-MM-YYYY HH24:MI'), TO_DATE('$ch_dt','DD-MM-YYYY HH24:MI'), '$this->create_by',";
      if (empty($this->closed_date)) {
        $sql .= "NULL";
      } else {
        $sql .= "TO_DATE('$this->closed_date','DD-MM-YYYY HH24:MI')";
      }
      $sql .= " ) RETURNING tic_id into :ticket_id";
      //echo $sql;
      $st = oci_parse($conn, $sql);
      $id = 0;
      oci_bind_by_name($st, ":tic_pic", $this->pic, -1, SQLT_CHR);
      oci_bind_by_name($st, ":tic_subject", $this->subject, -1, SQLT_CHR);
      oci_bind_by_name($st, ":tic_detail", $this->detail, -1, SQLT_CHR);
      oci_bind_by_name($st, ":tic_solution", $this->solution, -1, SQLT_CHR);
      oci_bind_by_name($st, ":TICKET_ID", $id, -1, SQLT_INT);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      //echo $sql;
      oci_execute($st) or die(oci_error($conn)["message"]);

      oci_free_statement($st);
      oci_close($conn);
      return $id;
    } else {
      return 0;
    }
  }

  public function userInsert() {
    if (empty($this->id)) {
      $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
      $sql = "INSERT INTO $this->table_name "
              . "(tic_cat_id, tic_subject, tic_detail, tic_req_by, tic_status, tic_priority, tic_created_by, tic_created_dt) "
              . "VALUES ('$this->category', :tic_subject, :tic_detail, '$this->req_by', '$this->status', '$this->priority', '$this->create_by', TO_DATE('$this->create_date','DD-MM-YYYY HH24:MI'))";
      $st = oci_parse($conn, $sql);
      oci_bind_by_name($st, ":tic_subject", $this->subject, -1, SQLT_CHR);
      oci_bind_by_name($st, ":tic_detail", $this->detail, -1, SQLT_CHR);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      //echo $sql;
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      oci_close($conn);
      return true;
    } else {
      return false;
    }
  }

  public function update() {
    if (!empty($this->id)) {
      $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
      $ch_dt = date("d-m-Y H:i");
      $sql = "UPDATE $this->table_name "
              . "SET tic_cat_id = '$this->category', "
              . "tic_subject = :subject, "
              . "tic_detail = :detail, "
              . "tic_req_by = '$this->req_by', "
              . "tic_status = '$this->status', "
              . "tic_priority = '$this->priority', "
              . "TIC_LAST_CH_DT = TO_DATE('$ch_dt','DD-MM-YYYY HH24:MI'), "
              . "TIC_LAST_CH_BY = '$this->last_change_by',";
      if (!empty($this->pic)) {
        $sql .= "tic_pic = '$this->pic', ";
      } else {
        $sql .= "tic_pic = NULL, ";
      }

      if (!empty($this->closed_date)) {
        $sql .= " tic_closed_dt = to_date('$this->closed_date', 'DD-MM-YYYY HH24:MI') ";
      } else {
        $sql .= " tic_closed_dt = NULL ";
      }
      $sql .= " WHERE tic_id = '$this->id' ";
      $st = oci_parse($conn, $sql);
      oci_bind_by_name($st, ":subject", $this->subject, -1, SQLT_CHR);
      oci_bind_by_name($st, ":detail", $this->detail, -1, SQLT_CHR);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      //echo $sql;
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      oci_close($conn);
      return true;
    } else {
      return false;
    }
  }

  public function userUpdate() {
    if (!empty($this->id)) {
      $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
      $sql = "UPDATE $this->table_name "
              . "SET tic_cat_id = '$this->category', "
              . "tic_subject = '$this->subject', "
              . "tic_detail = :detail, "
              . "tic_req_by = '$this->req_by', "
              . "tic_status = '$this->status', "
              . "tic_priority = '$this->priority', ";
      if (!empty($this->closed_date)) {
        $sql .= " tic_closed_dt = to_date('$this->closed_date', 'DD-MM-YYYY HH24:MI') ";
      } else {
        $sql .= " tic_closed_dt = NULL ";
      }
      $sql .= " WHERE tic_id = '$this->id' ";
      $st = oci_parse($conn, $sql);
      oci_bind_by_name($st, ":detail", $this->detail, -1, SQLT_CHR);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      //echo $sql;
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      oci_close($conn);
      return true;
    } else {
      return false;
    }
  }

  public function setStatus($id, $status) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE $this->table_name "
            . "SET tic_status = '$status' ";
    if ($status == "X") {
      $closedDate = new DateTime();
      $sql .= ",tic_closed_dt = to_date('" . $closedDate->format("d-m-Y H:i") . "', 'DD-MM-YYYY HH24:MI') ";
    }
    $sql .= "WHERE tic_id = '$id' ";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function getCategoryList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM INT_MST_INQ_CATEGORY";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    $category = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $category[$i]["id"] = $row["CAT_ID"];
      $category[$i]["sub"] = $row["CAT_SUB"];
      $category[$i]["desc"] = $row["CAT_DESC"];
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $category;
  }

  public function uploadAttachment($ticket_id, $the_file) {
    //handle main images upload
    $image_path = "media/ticket_attachment/" . $ticket_id;
    if (!file_exists($image_path)) {
      mkdir($image_path, 0777, true);
    }
    $target_dir = $image_path . "/";
    //handle main images upload
    if (!empty($the_file)) {
      //$file_extension = pathinfo($the_file["name"], PATHINFO_EXTENSION);
      $target_file = $target_dir . $the_file["name"];
      if (file_exists($target_file)) {
        unlink($target_file);
      }
      move_uploaded_file($the_file["tmp_name"], $target_file);
    }
  }

  public function getAttachment($ticket_id) {
    $return = array();
    $file_path = "media/ticket_attachment/" . $ticket_id;
    if (file_exists($file_path)) {
      $files = scandir($file_path);
      $i = 0;
      foreach ($files as $file) {
        if ($i >= 2) {
          if ($file == "Thumbs.db") {
            continue;
          } else {
            $return[] = $file;
          }
        }
        $i++;
      }
    }
    return $return;
  }

  public function insertReply($tic_id, $replied_by, $reply_content) {
    $date_time = new DateTime();
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_trx_ticket_chat VALUES ('$tic_id',to_date('" . $date_time->format("d-m-Y H:i") . "', 'DD-MM-YYYY HH24:MI'),:reply_content,'$replied_by')";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":reply_content", $reply_content, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function getReply($tic_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $data = array();
    $sql = "SELECT a.*, to_char(a.tic_cht_date, 'DD-MON-YYYY HH24:MI') AS disp_dt, c.vc_name, b.vc_first_name, b.vc_middle_name, b.vc_last_name FROM int_trx_ticket_chat a 
            INNER JOIN int_mst_user c on c.vc_username = a.tic_chat_by 
            LEFT JOIN mst_employee b ON b.vc_emp_code = c.vc_emp_code
            WHERE a.tic_id = '$tic_id' order by tic_cht_date asc";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["TIC_ID"];
      $data[$i]["date"] = $row["DISP_DT"];
      $data[$i]["reply"] = $row["TIC_CHAT"];
      $data[$i]["reply_by"] = $row["TIC_CHAT_BY"];
      if (!empty($row["VC_NAME"])) {
        $data[$i]["reply_name"] = $row["VC_NAME"];
      } else {
        $data[$i]["reply_name"] = $row["VC_FIRST_NAME"] . " " . $row["VC_MIDDLE_NAME"] . " " . $row["VC_LAST_NAME"];
      }
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function updatePIC($ticket_id, $pic) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    //cek dulu apakah pic sudah di take
    $sql = "SELECT tic_pic FROM $this->table_name WHERE tic_id = '$ticket_id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    $current_pic = null;
    while (($row = oci_fetch_assoc($st)) != false) {
      $current_pic = $row["TIC_PIC"];
    }
    oci_free_statement($st);
    if (empty($current_pic)) {
      $ch_dt = date("d-m-Y H:i");
      $sql = "UPDATE $this->table_name "
              . "SET tic_status = 'P', "
              . "tic_pic = '$pic', "
              . "TIC_LAST_CH_DT = TO_DATE('$ch_dt','DD-MM-YYYY HH24:MI') "
              . "WHERE tic_id = '$ticket_id' ";
      $st = oci_parse($conn, $sql);
      if (!$st) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }
      //echo $sql;
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      oci_close($conn);
      return true;
    } else {
      return "PIC Already Assigned";
    }
  }

  public function getEmployeeName($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.vc_name, "
            . "(b.vc_first_name || ' ' || b.vc_middle_name || ' ' || b.vc_last_name) as emp_name "
            . "FROM int_mst_user a "
            . "LEFT JOIN mst_employee b on b.vc_emp_code = a.vc_emp_code "
            . "WHERE a.vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $name = null;
    oci_execute($st) or die(oci_error($conn)["message"]);
    while (($row = oci_fetch_assoc($st)) != false) {
      if (empty($row["VC_NAME"])) {
        $name = $row["EMP_NAME"];
      } else {
        $name = $row["VC_NAME"];
      }
    }

    oci_free_statement($st);
    oci_close($conn);
    return $name;
  }

  public function getSubCategory($up_cat) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_category WHERE cat_sub = '$up_cat' order by cat_order asc";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $data = array();
    $i = 0;
    oci_execute($st) or die(oci_error($conn)["message"]);

    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["CAT_ID"];
      $data[$i]["desc"] = $row["CAT_DESC"];
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function insertStatusLog($id, $username, $status) {
    $table = "INT_TRX_TICKET_STATUS_LOG";
    $log_date = date("d-m-Y H:i:s");
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "INSERT INTO $table VALUES('$id', to_date('" . $log_date . "', 'DD-MM-YYYY HH24:MI:SS'),'$username','$status')";
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

  public function getStatusLog($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $table = "INT_TRX_TICKET_STATUS_LOG";
    $sql = "SELECT a.*, to_char(a.tic_changed_date, 'DD-MON-YYYY HH24:MI') AS disp_dt, b.vc_name, "
            . "(c.vc_first_name || ' ' || c.vc_middle_name || ' ' || c.vc_last_name) as emp_name "
            . "FROM $table a "
            . "LEFT JOIN int_mst_user b on b.vc_username = a.tic_changed_by "
            . "LEFT JOIN mst_employee c on c.vc_emp_code = b.vc_emp_code AND c.vc_comp_code = b.vc_comp_code "
            . "WHERE a.tic_id = '$id' ORDER BY tic_changed_date ASC";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    $i = 0;
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["TIC_ID"];
      $data[$i]["date"] = $row["DISP_DT"];
      $data[$i]["changed_by"] = $row["TIC_CHANGED_BY"];
      $data[$i]["status"] = $row["TIC_STATUS"];

      if ($data[$i]["status"] == "O") {
        $data[$i]["status_desc"] = "OPEN";
      } else if ($data[$i]["status"] == "P") {
        $data[$i]["status_desc"] = "ON PROGRESS";
      } else if ($data[$i]["status"] == "N") {
        $data[$i]["status_desc"] = "NEED CONFIRMATION";
      } else if ($data[$i]["status"] == "C") {
        $data[$i]["status_desc"] = "CANCELED";
      } else if ($data[$i]["status"] == "X") {
        $data[$i]["status_desc"] = "CLOSED";
      }
      if (!empty($row["VC_NAME"])) {
        $data[$i]["changed_name"] = $row["VC_NAME"];
      } else {
        $data[$i]["changed_name"] = $row["EMP_NAME"];
      }
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function getTicketStatus($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "SELECT tic_status FROM $this->table_name WHERE tic_id = '$id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $status = null;
    oci_execute($st) or die(oci_error($conn)["message"]);

    while (($row = oci_fetch_assoc($st)) != false) {
      $status = $row["TIC_STATUS"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $status;
  }
  
  public function getAllowedFileType() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "SELECT file_ext FROM int_mst_ticket_alwd_filetype";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $filetype = array();
    oci_execute($st) or die(oci_error($conn)["message"]);

    while (($row = oci_fetch_assoc($st)) != false) {
      $filetype[] = $row["FILE_EXT"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $filetype;
  }
  
  public function getStatusList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_status order by st_order asc";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $return = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["ST_ID"];
      $data["desc"] = $row["ST_DESC"];
      $data["color"] = $row["ST_COLOR_CODE"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getStatusById($status_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_status where st_id = '$status_id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    $data = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["ST_ID"];
      $data["desc"] = $row["ST_DESC"];
      $data["color"] = $row["ST_COLOR_CODE"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  
  public function getPriorityList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_priority ORDER BY pr_order ASC";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $return = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["PR_ID"];
      $data["desc"] = $row["PR_DESC"];
      $data["color"] = $row["PR_COLOR_CODE"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getPriorityById($priority_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_priority where pr_id = '$priority_id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $data = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["PR_ID"];
      $data["desc"] = $row["PR_DESC"];
      $data["color"] = $row["PR_COLOR_CODE"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  
  public function getSupCategoryList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_cat_sup";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $return = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["CAT_SUB"];
      $data["desc"] = $row["CAT_DESC"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getSupCategoryById($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select * from int_mst_inq_cat_sup where cat_sub = '$id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $data = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["CAT_SUB"];
      $data["desc"] = $row["CAT_DESC"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  
  public function getTicketPIC($ticket_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select a.tic_pic, b.vc_name from Int_Trx_Inq_Ticket a 
            LEFT JOIN int_mst_user b ON b.vc_username = a.tic_pic 
            WHERE a.tic_id = '$ticket_id'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    $data = array();
    oci_execute($st) or die(oci_error($conn)["message"]);
    
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["pic"] = $row["TIC_PIC"];
      $data["name"] = $row["VC_NAME"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
}
