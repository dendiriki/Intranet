<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container-95">
      <div class="section">
        <div class="row">
          <div class="col s12 m8">
            <div class="card">
              <div class="card-content">
                <?php
                if(!empty($data["article"])){
                ?>
                <p class="grey-text"><?php echo $data["article"]->type." ".$data["article"]->date ?></p>
                <p class="card-title teal-text"><b><?php echo $data["article"]->title ?></b></p>
                <p>
                  <img class="img-main responsive-img" src="media/article_images/<?php echo $data["article"]->id."/".$data["article_images"]["main"] ?>">
                </p>
                <div class="divider"></div>
                <p><?php echo $data["article"]->content ?></p>
                <div class="divider"></div>
                <?php
                } else {
                ?>
                <span class="card-title">Oooops...!!!</span>
                <p>News you requested was not avaliable</p>
                <?php 
                }
                if(!empty($data["article_images"]["additional"])) {
                  $gallery = new Gallery();
                  $images_dir = "media/article_images/".$data["article"]->id."/";
                  $thumbs_dir = "media/article_images/".$data["article"]->id."/thumbs/";
                  if(!is_dir($thumbs_dir)) {
                    mkdir($thumbs_dir, 0777);
                  }
                  $thumbs_width = 200;
                  $image_files = $gallery->get_files($images_dir);
                  
                  if (count($image_files)) {
                    $index = 0;
                    echo '<div class="image-gallery center">';
                    foreach ($image_files as $index => $file) {
                      if($file == "main.jpg") {
                        continue;
                      } else {
                        $index++;
                        $thumbnail_image = $thumbs_dir . $file;
                        if (!file_exists($thumbnail_image)) {
                          $extension = $gallery->get_file_extension($thumbnail_image);
                          if ($extension) {
                            $gallery->make_thumb($images_dir . $file, $thumbnail_image, $thumbs_width);
                          }
                        }
                        echo '<a href="', $images_dir . $file, '" class="sb" ><img class="photo-link" src="', $thumbnail_image, '" /></a>';
                                     
                      }
                    }
                    echo '</div>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col s12 m4">
            <div class="row">
              <div class="col s12">
                <div class="card-panel light-blue">
                  <h5 class="center white-text">You May Also Like</h5>
                </div>
              </div>
              <?php foreach($side_article as $sa) {
                if($sa->id == $data["article"]->id) {
                  continue;
                } else {
              ?>
              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                    <h6 class="teal-text"><?php echo $sa->title; ?></h6>
                    <p class="truncate">
                      <?php echo $sa->summary; ?>
                    </p>
                  </div>
                  <div class="card-action">
                    <a href="?action=news_detail&articleId=<?php echo $sa->id ?>">Read More</a>
                  </div>
                </div>
              </div>
              <?php
                }
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'common/footer.php' ?>  
    <script src="templates/vendor/simple-lightbox/simpleLightbox.js" type="text/javascript"></script>
    <script>
      $(document).ready(function(){
        $('.image-gallery a').simpleLightbox();
      });
    </script>
  </body>
</html>
