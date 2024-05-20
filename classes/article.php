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
class Article {

  //put your code here
  public $id = null;
  public $date = null;
  public $title = null;
  public $summary = null;
  public $content = null;
  public $username = null;
  public $type = null;
  public $status = null;

  public function __construct($data = array()) {
    if (isset($data["id"])) {
      $this->id = $data["id"];
    }
    if (isset($data["date"])) {
      $this->date = $data["date"];
    }
    if (isset($data["title"])) {
      $this->title = $data["title"];
    }
    if (isset($data["summary"])) {
      $this->summary = $data["summary"];
    }
    if (isset($data["content"])) {
      $this->content = $data["content"];
    }
    if (isset($data["username"])) {
      $this->username = $data["username"];
    }
    if (isset($data["type"])) {
      $this->type = $data["type"];
    }
    if (isset($data["status"])) {
      $this->status = $data["status"];
    }
  }

  public function setParam($data = array()) {
    if (isset($data["id"])) {
      $this->id = $data["id"];
    }
    if (isset($data["date"])) {
      $this->date = $data["date"];
    }
    if (isset($data["title"])) {
      $this->title = $data["title"];
    }
    if (isset($data["summary"])) {
      $this->summary = $data["summary"];
    }
    if (isset($data["content"])) {
      $this->content = $data["content"];
    }
    if (isset($data["username"])) {
      $this->username = $data["username"];
    }
    if (isset($data["type"])) {
      $this->type = $data["type"];
    }
    if (isset($data["status"])) {
      $this->status = $data["status"];
    }
  }

  public function getById($id) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select art_id, art_type, TO_CHAR(art_date, 'DD-MM-YYYY') as art_date, art_title, art_summary, art_content, art_del from int_trx_article where art_id = :id";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":id", $id, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    if (($row = oci_fetch_assoc($st)) != false) {
      $data['id'] = $row["ART_ID"];
      $data['date'] = date("d F, Y", strtotime($row["ART_DATE"]));
      $data['title'] = $row["ART_TITLE"];
      $data['summary'] = $row["ART_SUMMARY"];
      $data['content'] = $row["ART_CONTENT"];
      $data['type'] = $row["ART_TYPE"];
      $data["status"] = $row["ART_DEL"];
    }

    oci_free_statement($st);
    oci_close($conn);
    return new Article($data);
  }

  /*
   * $article_type :
   * N = News
   * E = Event
   * T = Training
   */

  public function getSummary($article_type, $row = 10) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    if ($article_type == "*") {
      //select semua
      $sql = "select art_type, art_id, TO_CHAR(art_date, 'YYYYMMDD') AS art_date_sort, TO_CHAR(art_date, 'YYYY-MM-DD') AS art_date, art_title, art_summary, vc_username from "
              . "int_trx_article where art_del = 'P' ORDER BY art_date_sort DESC ";
    } else {
      //dibatasi rownum
      $sql = "select art_type, art_id, TO_CHAR(art_date, 'YYYYMMDD') AS art_date_sort, TO_CHAR(art_date, 'YYYY-MM-DD') AS art_date, art_title, art_summary, vc_username from "
              . "(SELECT * FROM int_trx_article WHERE art_del = 'P' AND art_type = '$article_type' ORDER BY art_date DESC) "
              . "WHERE rownum <= '$row' ";
    }

    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['id'] = $row["ART_ID"];
      $data['date'] = date("d F, Y", strtotime($row["ART_DATE"]));
      $data['title'] = $row["ART_TITLE"];
      $data['summary'] = $row["ART_SUMMARY"];
      $data['username'] = $row["VC_USERNAME"];
      $data['type'] = $row["ART_TYPE"];
      $article = new Article($data);
      $return[] = $article;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function getAll() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
   
    //select semua
    $sql = "select art_type, art_id, TO_CHAR(art_date, 'YYYYMMDD') AS art_date_sort, TO_CHAR(art_date, 'YYYY-MM-DD') AS art_date, art_title, art_summary, vc_username from "
            . "int_trx_article ORDER BY art_date_sort DESC ";
    
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['id'] = $row["ART_ID"];
      $data['date'] = date("d F, Y", strtotime($row["ART_DATE"]));
      $data['title'] = $row["ART_TITLE"];
      $data['summary'] = $row["ART_SUMMARY"];
      $data['username'] = $row["VC_USERNAME"];
      $data['type'] = $row["ART_TYPE"];
      $article = new Article($data);
      $return[] = $article;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }

  public function getSummaryByUser($username) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");

    $sql = "select art_id, TO_CHAR(art_date, 'YYYYMMDD') AS art_date_sort, TO_CHAR(art_date, 'YYYY-MM-DD') AS art_date, art_title, art_summary, vc_username "
            . "from int_trx_article "
            . "WHERE vc_username = '" . $username . "' ORDER BY art_date_sort DESC";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    $return = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data['id'] = $row["ART_ID"];
      $data['date'] = date("d F, Y", strtotime($row["ART_DATE"]));
      $data['title'] = $row["ART_TITLE"];
      $data['summary'] = $row["ART_SUMMARY"];
      $data['username'] = $row["VC_USERNAME"];
      $data['type'] = $row["ART_TYPE"];
      $article = new Article($data);
      $return[] = $article;
    }

    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }

  public function insert() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "INSERT INTO int_trx_article (art_type, art_date, art_title, art_summary, art_content, vc_username, art_del) " .
            "VALUES ('" . $this->type . "', to_date('" . $this->date . "', 'DD-MM-YYYY'), :title, :summary, :content, '" . $this->username . "', '" . $this->status . "') "
            . "RETURNING art_id into :LAST_ID";
    $st = oci_parse($conn, $sql);
    $id = 0;
    //oci_bind_by_name($st, ":date", $this->date, -1, SQLT_CHR);
    oci_bind_by_name($st, ":title", substr($this->title, 0, 200), -1, SQLT_CHR);
    oci_bind_by_name($st, ":summary", substr($this->summary, 0, 1000), -1, SQLT_CHR);
    oci_bind_by_name($st, ":content", substr($this->content, 0, 4000), -1, SQLT_CHR);
    oci_bind_by_name($st, ":LAST_ID", $id, -1, SQLT_INT);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    //echo $sql;
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return $id;
  }

  public function update() {
    if (empty($this->id)) {
      return false;
    }

    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_trx_article SET art_date = to_date('" . $this->date . "', 'DD-MM-YYYY'), "
            . "art_type = '" . $this->type . "', "
            . "art_title = '" . $this->title . "', "
            . "art_summary = '" . $this->summary . "', "
            . "art_del = '" . $this->status . "', "
            . "art_content = :content " .
            "WHERE art_id = '" . $this->id . "'";
    $st = oci_parse($conn, $sql);
    //oci_bind_by_name($st, ":id", $this->id, -1, SQLT_INT);
    //oci_bind_by_name($st, ":date", $this->date, -1, SQLT_CHR);
    //oci_bind_by_name($st, ":title", $this->title, -1, SQLT_CHR);
    //oci_bind_by_name($st, ":summary", $this->summary, -1, SQLT_CHR);
    oci_bind_by_name($st, ":content", $this->content, -1, SQLT_CHR);
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

  public function delete() {
    if (empty($this->id)) {
      return false;
    }

    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "UPDATE int_trx_article SET art_del = 'D', " .
            "WHERE art_id = :id";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":id", $this->id, -1, SQLT_INT);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    oci_free_statement($st);
    oci_close($conn);
    return true;
  }

  public function uploadImages($article_id, $image_main, $image_additional) {
    //handle main images upload
    $image_path = "media/article_images/".$article_id;
    if(!file_exists($image_path)) {
      mkdir($image_path, 0777, true);
    }
    $target_dir = $image_path."/";
    //handle main images upload
    if (!empty($image_main)) {
      $file_extension = pathinfo($image_main["name"], PATHINFO_EXTENSION);
      $target_image_main = $target_dir . "main." . $file_extension;
      if (file_exists($target_image_main)) {
        unlink($target_image_main);
      }
      move_uploaded_file($image_main["tmp_name"], $target_image_main);
    }
    //handle additional image upload
    if (!empty($image_additional)) {
      $i = 1;
      foreach ($image_additional as $image_add) {
        $file_extension = pathinfo($image_add["name"], PATHINFO_EXTENSION);
        $target_image_add = $target_dir . "additional_" . $i . "." . $file_extension;
        if (file_exists($target_image_add)) {
          unlink($target_image_add);
        }
        move_uploaded_file($image_add["tmp_name"], $target_image_add);
        $i++;
      }
    }
  }
  
  public function getArticleImages($article_id) {
    $return = array();
    $images_main = null;
    $images_add = array();
    $image_path = "media/article_images/".$article_id;
    if(file_exists($image_path)) {
      $files = scandir($image_path);
      foreach ($files as $file) {
        $pos1 = strpos($file, "main");
        if($pos1 !== false) {
          $images_main = $file;
        }
        $pos2 = strpos($file, "add");
        if($pos2 !== false) {
          $images_add[] = $file;
        }
      }
      $return["main"] = $images_main;
      $return["additional"] = $images_add;
    }
    
    return $return;
  }
}