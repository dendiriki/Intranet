<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12">
            <h5 class="center">Leave Record</h5>
            <div class="card-panel">
              <table class="responsive-table striped bordered">
                <thead>
                  <tr class="hide-on-med-and-down blue darken-1 white-text">
                    <th colspan="2">Period</th>
                    <th colspan="2">Date of Taken</th>
                    <th colspan="2">&nbsp</th>
                  </tr>
                  <tr class="blue white-text">
                    <th>From</th>
                    <th>To</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Days</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($data["annual_leave"])) {
                    $dt_period = null;
                    $dt_period_to = null;
                    $print_period = false;
                    $annual_balance = 0;
                    foreach ($data["annual_leave"]["leave"] as $leave) {
                      if ($leave["flag"] == "A" || $leave["flag"] == "W") {
                        $annual_balance += $leave["balance"];
                      } else {
                        $annual_balance -= $leave["balance"];
                      }
                      if ($dt_period == $leave["period_from"]) {
                        $print_period = false;
                      } else {
                        if ($annual_balance > 0 && !empty($dt_period)) {
                          //print annual ballance
                          ?>
                          <tr>
                            <td colspan="4"><b><?php echo "Period " . $dt_period . " - " . $dt_period_to . " Balance"; ?></b></td>
                            <td><?php echo $annual_balance; ?></td>
                            <td>Days Remaining</td>
                          </tr>
                          <?php
                        }
                        $annual_balance = 0;
                        $print_period = true;
                        $dt_period = $leave["period_from"];
                        $dt_period_to = $leave["period_to"];
                      }
                      ?>
                      <tr>
                        <td><?php if ($print_period) echo $leave["period_from"]; ?></td>
                        <td><?php if ($print_period) echo $leave["period_to"]; ?></td>
                        <td><?php echo $leave["start_date"]; ?></td>
                        <td><?php echo $leave["end_date"]; ?></td>
                        <td><?php echo $leave["balance"]; ?></td>
                        <td><?php echo $leave["remarks"]; ?></td>
                      </tr>
                      <?php
                    }
                  }
                  ?>
                </tbody>
              </table>

              <table class="bordered">
                <tr class="blue lighten-1">
                  <td colspan="4"><b>Total Balance</b></td>
                  <td><?php echo $data["annual_leave"]["balance"]; ?></td>
                  <td>Days Remaining</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
