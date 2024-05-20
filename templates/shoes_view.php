<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="section light-blue">
      <div class="container">
        <h5 class="white-text">Shoes Record</h5>
      </div>
    </div>
    <div class="section">
      <div class="container white">
        <table class="responsive-table striped bordered table-ticket centered z-depth-1">
          <thead>
            <tr class="blue white-text">
              <th>No</th>
              <th>Type</th>
              <th>Ukuran</th>
              <th>Waktu Pengambilan</th>
              <th>Aktual Pengambilan</th>
              <th>Durasi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1;
            foreach ($data["shoes"] as $shoes) {
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $shoes["VC_SAFETY_TYPE"]; ?></td>
              <td><?php echo $shoes["VC_SAFETY_SIZE"]; ?></td>
              <td><?php echo $shoes["DT_LOAD_DATE"]; ?></td>
              <td><?php echo $shoes["DT_ACTUAL_DATE"]; ?></td>
              <td><?php echo $shoes["NU_DURATION_YR"]; ?></td>
              <td><?php echo $shoes["VC_REMARKS"]; ?></td>
            </tr>
            <?php
            $i++;
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
