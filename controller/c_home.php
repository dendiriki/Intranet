<?php

if($action == "home") {
  $data = array();
  $data["username"] = $username;
  $data["employee"] = $employee;
  $article = new Article();
  $data["news"] = $article->getSummary("N", 5);
  $data["event"] = $article->getSummary("E", 5);
  $data["training"] = $article->getSummary("T", 5);
  require( TEMPLATE_PATH . "/home.php" );
}
?>