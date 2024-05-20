<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author dheo
 */
class Menu {
  
  public $id = null;
  public $name = null;
  public $long_name = null;
  public $link = null;
  public $icon = null;
  public $type = null;
  public $active = null;
  public $target = null;

  public function __construct($data = array()) {
    if(isset($data["id"])) $this->id = $data["id"];
    if(isset($data["name"])) $this->name = $data["name"];
    if(isset($data["long_name"])) $this->long_name = $data["long_name"];
    if(isset($data["link"])) $this->link = $data["link"];
    if(isset($data["icon"])) $this->icon = $data["icon"];
    if(isset($data["type"])) $this->type = $data["type"];
    if(isset($data["active"])) $this->active = $data["active"];
    if(isset($data["target"])) $this->target = $data["target"];
  }
  public function getGlobalMenu() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select * from int_mst_menu where mn_type = 'G' and mn_active = 'Y'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $menu_id = null;
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      if ($menu_id == $row["MN_ID"]) {
        continue;
      } else {
        $menu_id = $row["MN_ID"];
        $data[$i]["id"] = $row["MN_ID"];
        $data[$i]["name"] = $row["MN_NAME"];
        $data[$i]["long_name"] = $row["MN_LONG_NAME"];
        $data[$i]["link"] = $row["MN_LINK"];
        $data[$i]["icon"] = $row["MN_ICON"];
        $data[$i]["target"] = $row["MN_TARGET"];
        $i++;
      }
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  //put your code here
  public function getByUser($username) {
    $username = strtoupper($username);
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "select a.vc_username, a.rl_id, b.mn_id, c.mn_name, c.mn_link, c.mn_target, c.mn_icon, c.mn_long_name "
            . "from int_trx_user_role a " .
            "INNER JOIN int_trx_menu_role b ON b.rl_id = a.rl_id " .
            "INNER JOIN Int_Mst_Menu c ON c.mn_id = b.mn_id " .
            "WHERE a.vc_username = '$username' AND c.mn_active = 'Y' AND c.mn_type = 'U' ORDER BY mn_id ASC";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $menu_id = null;
    $i = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      if ($menu_id == $row["MN_ID"]) {
        continue;
      } else {
        $menu_id = $row["MN_ID"];
        $data[$i]["id"] = $row["MN_ID"];
        $data[$i]["name"] = $row["MN_NAME"];
        $data[$i]["long_name"] = $row["MN_LONG_NAME"];
        $data[$i]["link"] = $row["MN_LINK"];
        $data[$i]["icon"] = $row["MN_ICON"];
        $data[$i]["target"] = $row["MN_TARGET"];
        $i++;
      }
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function getById($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM int_mst_menu WHERE mn_id = '$id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["id"] = $row["MN_ID"];
      $data["name"] = $row["MN_NAME"];
      $data["long_name"] = $row["MN_LONG_NAME"];
      $data["link"] = $row["MN_LINK"];
      $data["icon"] = $row["MN_ICON"];
      $data["type"] = $row["MN_TYPE"];
      $data["active"] = $row["MN_ACTIVE"];
      $data["target"] = $row["MN_TARGET"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }

  public function getList() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM int_mst_menu order by mn_id asc";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);
    $i = 0;
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data[$i]["id"] = $row["MN_ID"];
      $data[$i]["name"] = $row["MN_NAME"];
      $data[$i]["long_name"] = $row["MN_LONG_NAME"];
      $data[$i]["link"] = $row["MN_LINK"];
      $data[$i]["icon"] = $row["MN_ICON"];
      $data[$i]["type"] = $row["MN_TYPE"];
      $data[$i]["active"] = $row["MN_ACTIVE"];      
      $data[$i]["target"] = $row["MN_TARGET"];
      $i++;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  
  public function insert() {
    if(!empty($this->id)) return false;
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_mst_menu (MN_NAME, MN_LINK, MN_ICON, MN_TYPE, MN_LONG_NAME, mn_target, mn_active) "
            . "VALUES ('$this->name','$this->link','$this->icon','$this->type','$this->long_name', '$this->target', '$this->active')";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);

    oci_free_statement($st);
    oci_close($conn);
    return true;
  }
  
  public function update() {
    if(empty($this->id)) return false;
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_mst_menu SET "
            . "MN_NAME = '$this->name', "
            . "MN_LINK = '$this->link', "
            . "MN_ICON = '$this->icon', "
            . "MN_TYPE = '$this->type', "
            . "MN_LONG_NAME = '$this->long_name', "
            . "MN_TARGET = '$this->target', "
            . "MN_ACTIVE = '$this->active' "
            . "WHERE mn_id = '$this->id'";
    $st = oci_parse($conn, $sql);
    oci_execute($st) or die(oci_error($conn)["message"]);

    oci_free_statement($st);
    oci_close($conn);
    return true;
  }
}
