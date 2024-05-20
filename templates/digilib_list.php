<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <h5 class="center">Intranet Digital Library</h5>          
            <?php
            if (isset($data["gallery_list"])) {
              foreach ($data["gallery_list"] as $gal) {
                ?>
            <div class="col s12 m4">
              <div class="card small light-blue darken-3">
                <div class="card-content white-text">
                  <span class="card-title"><?php echo str_replace("-", " ", $gal) ?></span>
                  <p><?php echo str_replace("-", " ", $gal)." Digital Library" ?></p>
                </div>
                <div class="card-action">
                  <a href="?action=digilib_detail&dir=<?php echo $gal; ?>">View Documents</a>
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
