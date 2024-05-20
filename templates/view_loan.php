<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <h5 class="center">Loan Record</h5>
          <div class="col s12 m12">
            <div class="card-panel">
            <table class="bordered responsive-table">
              <thead>
                <tr class="blue darken-1 white-text">
                    <th>Period</th>
                    <th>Date</th>
                    <th>Remark</th>
                    <th style='text-align:right'>Debit</th>
                    <th style='text-align:right'>Credit</th>
                </tr>
              </thead>

              <tbody>
                <?php
                if(!empty($loan)) {
                  $i = 0;
                  $partialSaldo = 0;
                  $partialDebet = 0;
                  $partialKredit = 0;
                  $key = "";
                  foreach ($loan as $val) {
                    $i++;
                    if($key != $val["key"]) {
                      if($i == 1) {
                        $partialDebet = $val["debit"];
                        $partialKredit = $val["kredit"];
                      } else {
                        $partialSaldo = $partialDebet - $partialKredit;
                        echo "<tr class='grey lighten-2'>";
                        echo "<td colspan='3' class='center'><b>Saldo</b></td>";
                        echo "<td>&nbsp;</td><td style='text-align:right'>".$partialSaldo."</td>";
                        echo "</tr>";
                        $i = 0;
                        $partialDebet = $val["debit"];
                        $partialKredit = $val["kredit"];
                      }
                      $key = $val["key"];
                    } else {
                      $partialDebet += $val["debit"];
                      $partialKredit += $val["kredit"];
                    }
                    
                    echo "<tr>";
                    echo "<td>".$val["periode"]."</td>";
                    echo "<td>".$val["tanggal"]."</td>";
                    echo "<td>".$val["remark"]."</td>";
                    echo "<td style='text-align:right'>".$val["debit"]."</td>";
                    echo "<td style='text-align:right'>".$val["kredit"]."</td>";
                    echo "</tr>";                    
                  }
                  $partialSaldo = $partialDebet - $partialKredit;
                  echo "<tr class='grey lighten-2'>";
                  echo "<td colspan='3' class='center'><b>Saldo</b></td>";
                  echo "<td>&nbsp;</td><td style='text-align:right'>".$partialSaldo."</td>";
                  echo "</tr>";
                } else {
                  echo "<tr><td colspan='5'>There is no loan record for you</td></tr>";
                }
                ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>
