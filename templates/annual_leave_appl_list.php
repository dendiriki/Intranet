<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="section light-blue">
      <div class="container-95 row">
        <h5 class="col s12 m4 white-text">Leave Application Record</h5>
        <div class="col s12 m4 center"><a href="?action=annual_leave_appl&id=0" class="amber darken-2 white-text btn btn-flat waves-effect" style="margin-top:10px;">New Annual Leave</a></div>
        <div class="col s12 m4 center"><a href="?action=annual_leave_appl&id=0" class="amber darken-2 white-text btn btn-flat waves-effect" style="margin-top:10px;">New Leave</a></div>
      </div>      
    </div>
    <div class="section">
      <div class="container-95">
        <table class="responsive-table striped bordered table-ticket z-depth-1">
          <thead class="blue darken-2 white-text">
            <tr>
              <th>No</th>
              <th>Created Date</th>
              <th>Start</th>
              <th>End</th>
              <th>Duration</th>
              <th>Leave Type</th>
              <th>Designation</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($data["leave"])) {
              $i = 1;
              foreach ($data["leave"] as $lv) {
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $lv["LV_DATE_CREATED"]; ?></td>
              <td><?php echo $lv["LV_DATE_FROM"]; ?></td>
              <td><?php echo $lv["LV_DATE_TO"]; ?></td>
              <td><?php echo $lv["LV_DURATION"]; ?></td>
              <td><?php echo $lv["LV_LEAVE_TYPE"]; ?></td>
              <td><?php echo $lv["LV_DESIGNATION"]; ?></td>
              <td><?php echo $lv["LV_STATUS"]; ?></td>
            </tr>
            <?php
                $i++;
              }
            } else {
            ?>
            <tr><td class="center" colspan="8">Leave Application Empty</td></tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
