<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author dheo
 */
class Employee {

  //put your code here
  public $payroll = null;
  public $company = null;
  public $name = null;
  public $address = null;
  public $phone = null;
  public $department = null;

  public function __construct($data = array()) {
    if (isset($data["payroll"]))
      $this->payroll = $data["payroll"];
    
    if (isset($data["company"]))
      $this->company = $data["company"];

    if (isset($data["name"]))
      $this->name = $data["name"];

    if (isset($data["address"]))
      $this->address = $data["address"];

    if (isset($data["phone"]))
      $this->phone = $data["phone"];
    
    if (isset($data["department"]))
      $this->department = $data["department"];
  }

  public function getById($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select a.vc_name, a.vc_comp_code, a.vc_emp_code, b.vc_dept_code, b.vc_first_name, b.vc_middle_name, b.vc_last_name, "
            . "b.vc_permanent_address1, b.vc_permanent_address2, b.vc_permanent_address3, "
            . "b.vc_permanent_phone, "
            . "b.vc_corrs_address1, b.vc_corrs_address2, b.vc_corrs_address3, "
            . "b.vc_corrs_phone "
            . "FROM int_mst_user a LEFT JOIN mst_employee b ON b.vc_emp_code = a.vc_emp_code AND b.vc_comp_code = a.vc_comp_code "
            . "WHERE a.vc_username = :username";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $username, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    if (($row = oci_fetch_assoc($st)) != false) {
      $data['payroll'] = $row["VC_EMP_CODE"];
      $data["company"] = $row["VC_COMP_CODE"];
      if(!empty($row["VC_NAME"])) {
        $data['name'] = $row["VC_NAME"];
      } else {
        $data['name'] = $row["VC_FIRST_NAME"] . " " . $row["VC_MIDDLE_NAME"] . " " . $row["VC_LAST_NAME"];
      }
      $data['address'] = $row["VC_PERMANENT_ADDRESS1"] . " " . $row["VC_PERMANENT_ADDRESS2"] . " " . $row["VC_PERMANENT_ADDRESS3"];
      $data['phone'] = $row["VC_PERMANENT_PHONE"];
      $data['department'] = $row["VC_DEPT_CODE"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return new Employee($data);
  }

  public function update() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE mst_employee SET vc_first_name = :name, vc_permanent_address1 = :address, vc_permanent_phone = :phone WHERE vc_emp_code = :payroll";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":payroll", $this->payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":name", $this->name, -1, SQLT_CHR);
    oci_bind_by_name($st, ":address", $this->address, -1, SQLT_CHR);
    oci_bind_by_name($st, ":phone", $this->phone, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);

    oci_free_statement($st);
    oci_close($conn);

    return true;
  }
  
  public function getList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select vc_emp_code, vc_dept_code, vc_first_name, vc_middle_name, vc_last_name FROM mst_employee WHERE dt_resignation_date IS NULL";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['payroll'] = $row["VC_EMP_CODE"];
      $data['name'] = $row["VC_FIRST_NAME"] . " " . $row["VC_MIDDLE_NAME"] . " " . $row["VC_LAST_NAME"];
      $return[] = $data;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getMailById($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_user_email where vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $email = null;
    if (($row = oci_fetch_assoc($st)) != false) {
      $email = $row["VC_EMAIL"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $email;
  }
  
  public function getMailByIdMulti($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $user = "";
    if(is_array($username)) {
      foreach($username as &$uname) {
        $uname = "'".$uname."'";
      }
      unset($uname);
      $user = implode(",", $username);
    } else {
      $user = "'".$username."'";
    }
     
    $sql = "select * from int_mst_user_email where vc_username IN (".$user.")";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $email = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      if($row["VC_EMAIL"] == "-") {
        continue;
      } else {
        $email[] = $row["VC_EMAIL"];
      }
    }

    oci_free_statement($st);
    oci_close($conn);
    return $email;
  }
  
  public function insertEmail($username, $email) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql_cek = "SELECT count(*) as jml FROM int_mst_user_email WHERE vc_username = '$username'";
    $st_cek = oci_parse($conn, $sql_cek);
    if (!$st_cek) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st_cek) or die(oci_error($conn)["message"]);
    $jml = 0;
    if (($row_cek = oci_fetch_assoc($st_cek)) != false) {
      $jml = $row_cek["JML"];
    }
    
    if($jml > 0) {
      $sql = "UPDATE int_mst_user_email SET vc_email = '$email' WHERE vc_username = '$username'";
    } else {
      $sql = "INSERT INTO int_mst_user_email VALUES('$username','$email')";
    }
    
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
  
  public function getExtById($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_user_telp where vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $telp = null;
    if (($row = oci_fetch_assoc($st)) != false) {
      $telp = $row["VC_EXTENSION"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $telp;
  }
  
  public function insertExt($username, $telp) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql_cek = "SELECT count(*) as jml FROM int_mst_user_telp WHERE vc_username = '$username'";
    $st_cek = oci_parse($conn, $sql_cek);
    if (!$st_cek) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st_cek) or die(oci_error($conn)["message"]);
    $jml = 0;
    if (($row_cek = oci_fetch_assoc($st_cek)) != false) {
      $jml = $row_cek["JML"];
    }
    
    if($jml > 0) {
      $sql = "UPDATE int_mst_user_telp SET vc_extension = '$telp' WHERE vc_username = '$username'";
    } else {
      $sql = "INSERT INTO int_mst_user_telp VALUES('$username','$telp')";
    }
    
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
  
  public function getNameByEmpNo($company,$payroll) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select vc_first_name, vc_middle_name, vc_last_name from mst_employee where vc_comp_code = :company and vc_emp_code = :payroll";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":payroll", $payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":company", $company, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $name = null;
    if (($row = oci_fetch_assoc($st)) != false) {
      $name = $row["VC_FIRST_NAME"]." ".$row["VC_MIDDLE_NAME"]." ".$row["VC_LAST_NAME"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $name;
  }
  
  public function getBirthDateByEmpNo($company,$payroll) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select to_char(dt_date_of_birth,'DDMMYYYY') AS bday from mst_employee where vc_comp_code = :company and vc_emp_code = :payroll";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":payroll", $payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":company", $company, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $bday = null;
    if (($row = oci_fetch_assoc($st)) != false) {
      $bday = $row["BDAY"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $bday;
  }
  
  public function getShoesAllowanceDetail($company,$payroll) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.*, b.*, c.* FROM emp_safety_detail a 
            INNER JOIN mst_safety b ON b.vc_safety_code = a.vc_safety_code 
            INNER JOIN mst_safety_type c ON c.vc_safety_code = a.vc_safety_code AND c.vc_code_type = a.vc_type 
            WHERE a.vc_comp_code = :company AND a.vc_emp_code = :payroll";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":payroll", $payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":company", $company, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $return[] = $row;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
}
