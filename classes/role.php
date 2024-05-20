<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud
 *
 * @author dheo
 */
class Role {

  public $id = null;
  public $name = null;
  public $desc = null;

  public function __construct($data = array()) {
    if (isset($data["id"]))
      $this->id = $data["id"];
    if (isset($data["name"]))
      $this->name = $data["name"];
    if (isset($data["desc"]))
      $this->desc = $data["desc"];
  }

  public function getList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_role order by rl_id asc";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["RL_ID"];
      $data[$i]["name"] = $row["RL_NAME"];
      $data[$i]["desc"] = $row["RL_DESC"];
      $i++;
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function getById($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_role WHERE rl_id = '$id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["RL_ID"];
      $data["name"] = $row["RL_NAME"];
      $data["desc"] = $row["RL_DESC"];
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function insert() {
    if (!empty($this->id)) {
      return false;
    }
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_mst_role (RL_NAME, RL_DESC) VALUES ('$this->name','$this->desc')";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function update() {
    if (empty($this->id)) {
      return false;
    }
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_mst_role SET RL_NAME = '$this->name', RL_DESC = '$this->desc' WHERE rl_id = '$this->id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function getMenuRole($role_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select a.mn_id, b.mn_name from int_trx_menu_role a INNER JOIN int_mst_menu b ON b.mn_id = a.mn_id WHERE a.rl_id = '$role_id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["MN_ID"];
      $data[$i]["name"] = $row["MN_NAME"];
      $i++;
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function deleteMenuRole($role_id, $menu_id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "DELETE int_trx_menu_role WHERE rl_id = '$role_id' AND mn_id = '$menu_id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function addMenuRole($role_id, $menu_id) {
    $return = array();
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql_select = "select COUNT(*) AS jml " .
            "from int_trx_menu_role " .
            "WHERE rl_id = '$role_id' AND mn_id = '$menu_id'";
    $st = oci_parse($conn, $sql_select);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $jml = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      $jml = $row["JML"];
    }
    oci_free_statement($st);
    if ($jml > 0) {
      $return["status"] = "fail";
      $return["msg"] = "Menu Already Exist";
    } else {
      $sql = "INSERT INTO int_trx_menu_role VALUES ('$role_id','$menu_id')";
      $st = oci_parse($conn, $sql);
      oci_execute($st) or die(oci_error($conn)["message"]);
      oci_free_statement($st);
      $return["status"] = "ok";
      $return["msg"] = "Menu Added";
    }
    oci_close($conn);
    return $return;
  }
}
