<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    
    <div class="container">
      <div class="section">
        <h5 class="center">Image Gallery</h5>
        <section class="image-gallery">
            <?php
            /** settings * */
            $images_dir = "media/gallery/".$data["dir"]."/";
            $thumbs_dir = "media/gallery/".$data["dir"]."/thumbs/";
            $thumbs_width = 200;
            $images_per_row = 4;
            /** generate photo gallery * */
            $image_files = $gallery->get_files($images_dir);
            //var_dump($image_files);
            if (count($image_files)) {
              $index = 0;
              foreach ($image_files as $index => $file) {
                if($file == "folder-thumbs.jpg") {
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
                  /*if ($index % $images_per_row == 0) {
                    echo '<div class="clear"></div>';
                  }*/                
                }
              }
              //echo '<div class="clear"></div>';
            } else {
              echo '<p class="col s12">There are no images in this gallery.</p>';
            }
            ?>
        </section>
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
