<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="section light-blue darken-1">
      <div class="container">
        <h4 class="white-text"><?php echo $data["page"]?></h4>
      </div>
    </div>
    <div class="container">
      <div class="section">
        <div class="row">
          <?php 
          $article_list = $data["article"];
          if(!empty($article_list)) {
            foreach($article_list as $article) {
              if($article->type == "T" || $article->type == "E") $article->title .= " - ".$article->date;
          ?>
          <div class="col s12">
            <div class="card horizontal">
              <div class="card-image">
                <img class="responsive-img" src="media/article_images/<?php echo $article->id."/main.jpg" ?>">
              </div>
              <div class="card-stacked">
                <div class="card-content">
                  <h6 class="teal-text"><?php echo $article->title ?></h6>
                  <p class="medium-text"><?php echo $article->summary ?></p>
                </div>
                <div class="card-action">
                  <a href="?action=news_detail&articleId=<?php echo $article->id ?>">Read More</a>
                </div>
              </div>
            </div>                      
          </div>
          <?php
            } 
          } else {
          ?>
          <a class="collection-item" href="#">
            <h5><span class="title">Ooooops...!!!</span></h5>
            <p class="black-text">
              Sorry, no article for today, that's all we know.
            </p>
          </a>
          <?php
          }
          ?>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
