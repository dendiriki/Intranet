<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <h5 class="center">Image Gallery</h5>          
            <?php
            if (isset($data["gallery_list"])) {
              foreach ($data["gallery_list"] as $gal) {
                ?>
            <div class="col s12 m4">
              <div class="card">
                <div class="card-image">
                  <img src="media/gallery/<?php echo $gal; ?>/folder-thumbs.jpg">
                  <span class="card-title"><?php echo str_replace("-", " ", $gal) ?></span>
                </div>
                <div class="card-content">
                  <p><?php echo str_replace("-", " ", $gal)." photo gallery" ?></p>
                </div>
                <div class="card-action">
                  <a href="?action=view_gallery_detail&dir=<?php echo $gal; ?>">View Gallery</a>
                </div>
              </div>
            </div>
                <?php
              }
            }
            ?>
        </div>
      </div>
    </div>
<?php include 'common/footer.php' ?>  
  </body>
</html>
