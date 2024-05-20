<?php 
if($action == "edit_news") {
  $article = new Article();
  $data = array();
  $data["employee"] = $employee;
  if (isset($_GET["articleId"])) {
    if (isset($_POST["save"])) {
      // save article
      $saveArticle = new Article();
      $pickedDate = DateTime::createFromFormat('d M, Y', $_POST["date"]);

      $params["date"] = $pickedDate->format("d-m-Y");
      $params["title"] = $_POST["title"];
      $params["summary"] = $_POST["summary"];
      $params["content"] = $_POST["content"];
      $params["type"] = $_POST["art-type"];
      $params["status"] = $_POST["art-status"];
      $params["username"] = $username;
      $image_main = $_FILES["image_main"];
      $image_additional = reArrayFiles($_FILES["image_additional"]);
      //var_dump($image_additional);
      if ($_POST["id"] == 0 || $_POST["id"] == "0") {
        //insert
        $saveArticle->setParam($params);
        $insert = $saveArticle->insert();
        if ($insert != 0) {
          //start handle uploaded images
          var_dump($insert);
          $saveArticle->uploadImages($insert, $image_main, $image_additional);
          header('Location: index.php?action=edit_news&success=true');
        } else {
          header('Location: index.php?action=edit_news&articleId=0&success=false');
        }
      } else {
        //update
        $params["id"] = $_POST["id"];
        $saveArticle->setParam($params);
        $update = $saveArticle->update();
        if ($update) {
          $saveArticle->uploadImages($params["id"], $image_main, $image_additional);
          header('Location: index.php?action=edit_news&success=true');
        } else {
          header('Location: index.php?action=edit_news&articleId=' . $params["id"] . '&success=false');
        }
      }
    } else {
      if ($_GET["articleId"] == 0 || $_GET["articleId"] == "0") {
        //new article
        if (isset($_GET["success"]))
          $data["error"] = "Failed to save article";

        $data["action"] = "New Article";
      } else {
        //edit article
        if (isset($_GET["success"]))
          $data["error"] = "Failed to update article";

        $data["action"] = "Edit Article";
        $data["article"] = $article->getById($_GET["articleId"]);
      }
      require( TEMPLATE_PATH . "/edit_article.php" );
    }
  } else {
    if (isset($_GET["success"]))
      $data["success"] = "article saved";

    if ($username == "ADMIN") {
      //Admin bisa edit semua
      $data["article"] = $article->getAll();
    } else {
      $data["article"] = $article->getSummaryByUser($username);
    }

    require( TEMPLATE_PATH . "/manage_article.php" );
  }
}

function reArrayFiles(&$file_post) {
  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for ($i=0; $i<$file_count; $i++) {
      foreach ($file_keys as $key) {
          $file_ary[$i][$key] = $file_post[$key][$i];
      }
  }

  return $file_ary;
}
?>