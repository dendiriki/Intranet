<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <h5 class="center">Conference Room Booking/Avalability</h5>
          <?php
          if (isset($room_list)) {
            if (!empty($room_list)) {
              foreach ($room_list as $room) {
                echo '<div class="col s12 m4">
                      <div class="card light-blue darken-3">
                        <div class="card-content white-text">
                          <span class="card-title">'.$room['name'].'</span>
                          <p>'.$room['remark'].'</p>
                        </div>
                        <div class="card-action">
                          <a class="waves-effect wave-white" href="?action=conf_list&room_id='.$room['id'].'">Book this room</a>
                        </div>
                      </div>
                      </div>';
              }
            } else {
              echo "<h5 class='center'>Room List Empty</h5>";
            }
          }
          ?>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
