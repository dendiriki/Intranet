<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author dheo
 */
class User {

  //put your code here
  public $username = null;
  public $password = null;
  public $reset = "1";
  public $company = null;
  public $payroll = null;
  public $name = null;
  public $type = null;

  public function __construct($data = array()) {
    if (isset($data["username"]))
      $this->username = strtoupper($data["username"]);

    if (isset($data["password"]))
      $this->password = $data["password"];

    if (isset($data["reset"]))
      $this->reset = $data["reset"];
  }

  public function setParam($data = array()) {
    $this->__construct($data);
    
    if (isset($data["company"]))
    {  $this->company = $data["company"]; }
    
    if (isset($data["payroll"]))
    {  $this->payroll = $data["payroll"]; }
    
    if (isset($data["name"]))
    {  $this->name = $data["name"]; }
    
    if (isset($data["type"]))
    {  $this->type = $data["type"]; }
  }

  public function getById($id) {
    $username = strtoupper($id);
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_user WHERE vc_username = :username AND vc_emp_del = '0'";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $username, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    if (($row = oci_fetch_assoc($st)) != false) {
      $data['username'] = strtoupper($row["VC_USERNAME"]);
      $data['password'] = $row["VC_EMP_PASS"];
      $data['reset'] = $row["VC_RESET"];
      $data["payroll"] = $row["VC_EMP_CODE"];
      $data["company"] = $row["VC_COMP_CODE"];
      $data["name"] = $row["VC_NAME"];
      $data["type"] = $row["VC_TYPE"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return new User($data);
  }

  public function getNameById($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $username = strtoupper($id);
    $sql = "SELECT a.vc_username, a.vc_emp_code, a.vc_comp_code, a.vc_name, b.vc_first_name, b.vc_middle_name, b.vc_last_name "
            . "FROM int_mst_user a "
            . "LEFT JOIN mst_employee b on b.vc_emp_code = a.vc_emp_code AND b.vc_comp_code = a.vc_comp_code "
            . "WHERE a.vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['username'] = strtoupper($row["VC_USERNAME"]);
      if(!empty($row["VC_NAME"])) {
        $data["name"] = $row["VC_NAME"];
      } else {
        $data['name'] = $row["VC_FIRST_NAME"] . " " . $row["VC_MIDDLE_NAME"] . " " . $row["VC_LAST_NAME"];
      }
      $data["payroll"] = $row["VC_EMP_CODE"];
      $data["company"] = $row["VC_COMP_CODE"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
	
  public function getName($userid) {    
    if(empty($userid)) {
      return false;
    } else {
      $conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
      $sql = "SELECT a.vc_name FROM int_mst_user a 
              WHERE a.vc_username = :userid";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(":userid", strtoupper($userid), PDO::PARAM_STR);
      if($stmt->execute()) {
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          return $row["VC_NAME"];
        } else {
          return false;
        }   
      } else {
        return false;
      }
    }    
  }

  public function getList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.vc_username, a.vc_emp_code, a.vc_name, b.vc_first_name, b.vc_middle_name, b.vc_last_name "
            . "FROM int_mst_user a "
            . "LEFT JOIN mst_employee b on b.vc_emp_code = a.vc_emp_code AND b.vc_comp_code = a.vc_comp_code "
            . "ORDER BY vc_emp_code ASC";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]['username'] = strtoupper($row["VC_USERNAME"]);
      if(!empty($row["VC_NAME"])) {
        $data[$i]['name'] = $row["VC_NAME"];
      } else {
        $data[$i]['name'] = $row["VC_FIRST_NAME"] . " " . $row["VC_MIDDLE_NAME"] . " " . $row["VC_LAST_NAME"];
      }
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function insert() {
    if (empty($this->username))
      die("Username Empty!");
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_mst_user (vc_username,vc_emp_pass,vc_emp_del,vc_reset,vc_type,vc_name,vc_emp_code,vc_comp_code) "
            . "VALUES (:username,:password,'0','1',:type,:name,:emp_code,:comp_code)";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $this->username, -1, SQLT_CHR);
    oci_bind_by_name($st, ":password", $this->password, -1, SQLT_CHR);
    oci_bind_by_name($st, ":type", $this->type, -1, SQLT_CHR);
    oci_bind_by_name($st, ":name", $this->name, -1, SQLT_CHR);
    oci_bind_by_name($st, ":emp_code", $this->payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":comp_code", $this->company, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function update() {
    if (empty($this->username))
      die("Username Empty!");
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_mst_user SET vc_emp_pass = :password, vc_reset = :reset WHERE vc_username = :username";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $this->username, -1, SQLT_CHR);
    oci_bind_by_name($st, ":password", $this->password, -1, SQLT_CHR);
    oci_bind_by_name($st, ":reset", $this->reset, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function delete() {
    if (empty($this->username))
      die("Username Empty!");
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_mst_user SET vc_emp_del = 'X' WHERE vc_username = :username";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $this->username, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function getUserRole($username) {
    $username = strtoupper($username);
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.rl_id, b.rl_name, b.rl_desc FROM int_trx_user_role a " .
            "INNER JOIN int_mst_role b ON b.rl_id = a.rl_id WHERE a.vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]['id'] = $row["RL_ID"];
      $data[$i]['name'] = $row["RL_NAME"];
      $data[$i]['desc'] = $row["RL_DESC"];
      $i++;
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function addUserRole($username, $role_id) {
    $username = strtoupper($username);
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT count(*) as jml FROM int_trx_user_role WHERE vc_username = '$username' AND rl_id = '$role_id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $jml = 0;
    if (($row = oci_fetch_assoc($st)) != false) {
      $jml = $row["JML"];
    }
    oci_free_statement($st);
    $return = array();
    if ($jml > 0) {
      $return["status"] = "fail";
      $return["msg"] = "Role Already Exist";
    } else {
      $sql = "INSERT INTO int_trx_user_role VALUES ('$username','$role_id')";
      $st = oci_parse($conn, $sql);
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      $return["status"] = "ok";
      $return["msg"] = "Role Added";
    }
    oci_close($conn);
    return $return;
  }

  public function deleteUserRole($username, $role_id) {
    $username = strtoupper($username);
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "DELETE int_trx_user_role WHERE vc_username = '$username' AND rl_id = '$role_id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function checkUserRoleByRoleName($username, $role_name) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT COUNT(*) as jml FROM int_mst_role a INNER JOIN Int_Trx_User_Role b ON b.rl_id = a.rl_id " .
            "WHERE a.rl_name = '$role_name' AND b.vc_username = '$username'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $jml = 0;
    if (($row = oci_fetch_assoc($st)) != false) {
      $jml = $row["JML"];
    }
    oci_free_statement($st);
    oci_close($conn);
    return $jml;
  }

  public function getUserListByRole($role_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.*, b.vc_first_name, c.vc_name FROM int_trx_user_role a 
            INNER JOIN int_mst_user c ON c.vc_username = a.vc_username 
            LEFT JOIN mst_employee b ON b.vc_emp_code = c.vc_emp_code AND b.vc_comp_code = c.vc_comp_code";
    
    if(is_array($role_id)) {
      $role_id_in = implode("','", $role_id);
      $sql .= " WHERE a.rl_id IN ('$role_id_in')";
    } else {
      $sql .= " WHERE a.rl_id = '$role_id'";
    }
    
    $sql .= " ORDER BY vc_name ASC";
    
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      if ($row["VC_EMP_CODE"] == "ADMIN") {
        continue;
      } else {
        $data[$i]["username"] = $row["VC_USERNAME"];
        if(!empty($row["VC_NAME"])) {
          $data[$i]["name"] = $row["VC_NAME"];
        } else {
          $data[$i]["name"] = $row["VC_FIRST_NAME"];
        }
        
        $i++;
      }
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function checkAuthorization($user, $action) {
    //check if menu is global or not
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT mn_type, mn_id, mn_active FROM int_mst_menu WHERE mn_link = '$action'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $menu_type = null;
    $menu_id = null;
    $menu_active = "N";
    while (($row = oci_fetch_assoc($st)) != false) {
      $menu_type = $row["MN_TYPE"];
      $menu_id = $row["MN_ID"];
      $menu_active = $row["MN_ACTIVE"];
    }
    oci_free_statement($st);

    if ($menu_active == "Y") {
      if ($menu_type == "G") {
        oci_close($conn);
        return true;
      } else {
        // cek apakah ada di rolenya
        if(empty($user)) {
          oci_close($conn);
          return false;
        }
        
        $sql = "SELECT COUNT(*) AS cek FROM int_trx_user_role a 
              INNER JOIN int_trx_menu_role b ON b.rl_id = a.rl_id 
              WHERE a.vc_username = '$user' AND b.mn_id = '$menu_id'";
        $st = oci_parse($conn, $sql);
        oci_execute($st) or die(oci_error($conn)["message"]);
        $cek = 0;
        while (($row = oci_fetch_assoc($st)) != false) {
          $cek = $row["CEK"];
        }
        oci_free_statement($st);
        oci_close($conn);
        if ($cek >= 1) {
          return true;
        } else {
          return false;
        }
      }
    } else {
      oci_close($conn);
      return false;
    }
  }
  
  public function isExist($username, $payroll, $company) {    
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT vc_username FROM int_mst_user 
            WHERE vc_username = :username OR ( vc_emp_code = :payroll AND vc_comp_code = :company )";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":username", $username);
    oci_bind_by_name($st, ":payroll", $payroll);
    oci_bind_by_name($st, ":company", $company);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $cek = null;
    while (($row = oci_fetch_assoc($st)) != false) {
      $cek = $row["VC_USERNAME"];
    }
    oci_free_statement($st);
    oci_close($conn);
    return $cek;
  }
}
