<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    
    <div class="container">
      <div class="section">
        <h5 class="center"><?php if(isset($data["title"])) {echo $data["title"];} ?></h5>
        <div class="collection">
          <?php
          if(isset($data["files"])){
            foreach ($data["files"] as $files) {
              echo '<a href="'.$data["digilib_dir"].$files.'" class="collection-item" target="_blank"><i class="material-icons left">&#xE24D;</i>'.$files.'</a>';
            }
          }
          ?>
        </div>
      </div>
    </div>
<?php include 'common/footer.php' ?>  
    
  </body>
</html>
