<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="home-container">
      <div class="section row">
        <div class="col s12 m8">
          <div class="slider">
            <ul class="slides">
              <?php
              $gallery = new Gallery();
              $images_dir = "media/carousel/"; //carousel directory
              $exts = array("jpg", "png");
              $image_files = $gallery->get_files($images_dir, $exts);
              if (count($image_files)) {
                foreach ($image_files as $index => $file) {
                  echo '<li><img src="'. $images_dir . $file . '" /></li>';
                }
              }
            ?>
            </ul>
          </div>
        </div>
        <div class="col s12 m4">
          <div class="card-panel">
            <ul class="collection with-header">
              <li class="collection-header"><h6>External Links</h6></li>
              <li class="collection-item"><a href="http://www.tugumandiri.com/" target="_blank"><img src="templates/images/logo-tugu-mandiri.png" height="30"></a></li>
              <li class="collection-item"><a href="https://bpjs-kesehatan.go.id/" target="_blank"><img src="templates/images/logo-bpjs-kesehatan.png" height="30"></a></li>
              <li class="collection-item"><a href="http://www.bpjsketenagakerjaan.go.id/" target="_blank"><img src="templates/images/logo-bpjs-ketenagakerjaan.png" height="30"></a></li>
              <li class="collection-item"><a href="https://djponline.pajak.go.id/" target="_blank"><img src="templates/images/logo-e-filing.png" height="30"></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="section white">
      <div class="row container-95">
        <div class="col s12 m8">
          <h5 class="center light-blue-text">Latest News</h5>
          <div class="row">
            <?php
            $news_list = $data["news"];
            if (!empty($news_list)) {
              foreach ($news_list as $news) {
                ?>
                <div class="col s12">
                  <div class="card horizontal small">
                    <div class="card-image">
                      <img class="responsive-img" src="media/article_images/<?php echo $news->id."/main.jpg" ?>">
                    </div>
                    <div class="card-stacked">
                      <div class="card-content">
                        <h6 class="teal-text"><?php echo $news->title ?></h6>
                        <p class="medium-text"><?php echo $news->summary ?></p>
                      </div>
                      <div class="card-action">
                        <a href="?action=news_detail&articleId=<?php echo $news->id ?>">Read More</a>
                      </div>
                    </div>
                  </div>                      
                </div>
                <?php
              }
            } else {
              ?>
              <div class="col s12 card">
                <div class="card-content">
                  <span class="card-title">Ooooops...!!!</span>
                  <span class="black-text small-text">
                    Sorry, no news for today, that's all we know.
                  </span>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="col s12 m4">
          <div class="card-panel">
            <h5 class="center light-blue-text">Latest Events</h5>
            <div class="collection">
              <?php
              $event_list = $data["event"];
              if (!empty($event_list)) {
                foreach ($event_list as $event) {
                  ?>
                  <a class="collection-item" href="?action=news_detail&articleId=<?php echo $event->id ?>">
                    <h6><span class="title"><?php echo $event->title ?></span></h6>
                    <span class="grey-text small-text">
                      <?php echo $event->date ?>
                    </span>
                    <span class="black-text small-text">
                      <?php echo $event->summary ?>
                    </span>
                  </a>
                  <?php
                }
              } else {
                ?>
                <a class="collection-item" href="#">
                  <h6><span class="title">Ooooops...!!!</span></h6>
                  <span class="black-text small-text">
                    Sorry, no event for today, that's all we know.
                  </span>
                </a>
                <?php
              }
              ?>
            </div>
          </div>              
          <div class="card-panel">
            <h5 class="center light-blue-text">Training Schedule</h5>
            <div class="collection">
              <?php
              $training_list = $data["training"];
              if (!empty($training_list)) {
                foreach ($training_list as $training) {
                  ?>
                  <a class="collection-item" href="?action=news_detail&articleId=<?php echo $training->id ?>">
                    <h6><span class="title"><?php echo $training->title ?></span></h6>
                    <span class="grey-text small-text">
                      <?php echo $training->date ?>
                    </span>
                    <span class="black-text small-text">
                      <?php echo $training->summary ?>
                    </span>
                  </a>
                  <?php
                }
              } else {
                ?>
                <a class="collection-item" href="#">
                  <h5><span class="title">Ooooops...!!!</span></h5>
                  <span class="black-text small-text">
                    Sorry, no Training Schedule for today, that's all we know.
                  </span>
                </a>
                <?php
              }
              ?>
            </div>
          </div>              
        </div>
      </div>
    </div>
    <?php include 'common/footer.php' ?>  
    <script>
      $(document).ready(function(){
        $(".slider").slider();
      }); 
    </script>
  </body>
</html>
