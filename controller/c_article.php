<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($action == "news_list") {
  viewListArticle("Latest News", "N");
}
if($action == "event_list") {
  viewListArticle("Latest Events", "E");
}
if($action == "training_list") {
  viewListArticle("Training Schedule", "T");
}
if($action == 'news_detail') {
  viewArticle();
}
function viewListArticle($page, $type) {
  $data = array();
  global $globalMenu;
  global $username;
  global $menu;
  global $employee;
  $data["username"] = $username;
  $data["employee"] = $employee;
  $data["page"] = $page;
  $article = new Article();
  $data["article"] = $article->getSummary($type, 20);
  require( TEMPLATE_PATH . "/news_list.php" );
}

function viewArticle() {
  $data = array();
  global $globalMenu;
  global $username;
  global $menu;
  global $employee;
  $data["username"] = $username;
  $data["employee"] = $employee;
  $article = new Article();
  $id = $_GET["articleId"];
  $data["article"] = $article->getById($id);
  $data["article_images"] = $article->getArticleImages($id);
  $article_type = $data["article"]->type;
  $side_article = $article->getSummary($article_type, 6);
  require( TEMPLATE_PATH . "/news_detail.php" );
}
?>