<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <style>
      body {
        font-size: 11px;
				font-family: Arial, Verdana, sans-serif;
      }
      table.border {
        border-collapse: collapse;
      }
      table.border tr td,th{
        border : 1px solid #000;
        border-spacing: 0;
        padding: 5px;
      }
      
      .right {
        text-align: right;
      }
      
      .height-10 {
        height: 3em;
      }
      
      .vl {
        padding: 10px;
      }
      @media print {
        body { 
          height: 210mm;
          font-size: 11px;
					font-family: Arial, Verdana, sans-serif;
        }
        /*div {
          page-break-after: always;
        }*/
      }
    </style>
  </head>
  <body>
  <?php
  for ($i = 0; $i < 1; $i++) {
  ?>
    <div class="vl">
    <p>Online Local Scrap Classification</p>
    <p>LOG/R/02</p>
    <table>
      <tr>
        <td>Date</td><td>:</td><td><?php echo $data["HDR"]["CRT_DT"]; ?></td>
      </tr>
			<tr>
        <td>Unloading Serial No.</td><td>:</td><td><?php echo $data["HDR"]["SRLNO"]; ?></td>
      </tr>
      <tr>
        <td>Insp. No.</td><td>:</td><td><?php echo $data["HDR"]["WSNUM"]; ?></td>
      </tr>
      <tr>
        <td>Vehicle No.</td><td>:</td><td><?php echo $data["HDR"]["VHC_ACT"]; ?></td>
      </tr>
      <tr>
        <td>Type</td><td>:</td><td><?php if($data["HDR"]["CONT_MRK"] == "X"){echo "Container";} else {echo "Truck";} ?></td>
      </tr>
      <tr>
        <td>Container No.</td><td>:</td><td><?php echo $data["HDR"]["CONT_NO"]; ?></td>
      </tr>
      <tr>
        <td>Supplier</td><td>:</td><td><?php echo $data["HDR"]["NAME1"]; ?></td>
      </tr>
			<tr>
        <td>Act. First WT.</td><td>:</td><td><?php echo $data["HDR"]["WHT_ACT"]; ?></td>
      </tr>
      <tr>
        <td>Est. Empty WT.</td><td>:</td><td><?php echo $data["HDR"]["WEIGHT_E"]; ?></td>
      </tr>
      <tr>
        <td>Est. Net WT.</td><td>:</td><td><?php echo ($data["HDR"]["WHT_ACT"]-$data["HDR"]["WEIGHT_E"]); ?></td>
      </tr>
      <tr>
        <td>Dimension LWH</td><td>:</td><td><?php echo $data["HDR"]["CONT_LENGTH"]."|".$data["HDR"]["CONT_WIDTH"]."|".$data["HDR"]["CONT_HEIGHT"]; ?></td>
      </tr>
			<tr>
        <td>Volume</td><td>:</td><td><?php echo ($data["HDR"]["CONT_LENGTH"]*$data["HDR"]["CONT_WIDTH"]*$data["HDR"]["CONT_HEIGHT"]); ?></td>
      </tr>
      <tr>
        <td>Density</td><td>:</td><td><?php echo $data["HDR"]["DENS_E"]; ?></td>
      </tr>
      <tr>
        <td>Rejection</td><td>:</td><td>
          <?php 
          if($data["HDR"]["REJ_MRK"] == "X" ) {
            echo "Yes";
          } else if ($data["HDR"]["REJ_MRK"] == "F") {
            echo "Full Reject";
          } else {
            echo "No";            
          } ?>
        </td>
      </tr>
			<tr>
        <td>Rej. Rem.</td><td>:</td><td><?php echo $data["HDR"]["REJ_RMK"]; ?></td>
      </tr>
      <tr>
        <td>Deduction</td><td>:</td><td>
          <?php 
          if(empty($data["HDR"]["DED_IND"])) {
            echo $data["HDR"]["DED_KG"]."(".$data["HDR"]["DED_PR"]." %)"; 
          } else {
            if($data["HDR"]["DED_IND"] == "K") {
              echo $data["HDR"]["DED_KG"]." Kg";
            } else {
              echo $data["HDR"]["DED_PR"]." %"; 
            }
          }
          ?>
        </td>
      </tr>
      <tr>
        <td>Ded. Rem.</td><td>:</td><td><?php echo $data["HDR"]["DED_RMK"]; ?></td>
      </tr>
    </table>
    
    <table class="border">
      <thead>
        <tr>
          <th rowspan="2">Classification</th>
          <th colspan="2">% Inspection</th>
          <th rowspan="2">Remarks</th>
        </tr>
        <tr>
          <th>NS</th>
          <th>LS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Ship Plate</td>
          <td class="right"><?php echo $data["ITM"][0]["SIZE_NORM"] ?></td>
          <td class="right">0</td>
          <td><?php echo $data["ITM"][0]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Fresh Plt./BSH</td>
          <td class="right"><?php echo $data["ITM"][1]["SIZE_NORM"] ?></td>
          <td class="right">0</td>
          <td><?php echo $data["ITM"][1]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Premium</td>
          <td class="right"><?php echo $data["ITM"][2]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][2]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][2]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Super A</td>
          <td class="right"><?php echo $data["ITM"][3]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][3]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][3]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Super B</td>
          <td class="right"><?php echo $data["ITM"][4]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][4]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][4]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Grade A</td>
          <td class="right"><?php echo $data["ITM"][5]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][5]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][5]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Grade B</td>
          <td class="right"><?php echo $data["ITM"][6]["SIZE_NORM"] ?></td>
          <td class="right">0</td>
          <td><?php echo $data["ITM"][6]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>Grade C</td>
          <td class="right"><?php echo $data["ITM"][7]["SIZE_NORM"] ?></td>
          <td class="right">0</td>
          <td><?php echo $data["ITM"][7]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>N. Cast Iron</td>
          <td class="right"><?php echo $data["ITM"][8]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][8]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][8]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>BS Cast Iron</td>
          <td class="right"><?php echo $data["ITM"][9]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][9]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][9]["REMARK"] ?></td>
        </tr>
        <tr>
          <td>BMP SPL/ORD</td>
          <td class="right"><?php echo $data["ITM"][10]["SIZE_NORM"] ?></td>
          <td class="right">0</td>
          <td><?php echo $data["ITM"][10]["REMARK"] ?></td>
        </tr>
				<tr>
          <td>ROLLING ROLLS</td>
          <td class="right"><?php echo $data["ITM"][11]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][11]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][11]["REMARK"] ?></td>
        </tr>
				<tr>
          <td>COUNTER WEIGHT</td>
          <td class="right"><?php echo $data["ITM"][12]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][12]["SIZE_LONG"] ?></td>
          <td><?php echo $data["ITM"][12]["REMARK"] ?></td>
        </tr>
      </tbody>
			<?php
			$item_list = $data["ITM"];
			$item_count = count($item_list) - 1;
			?>
      <tfoot>
        <tr>
          <td>TOTAL</td>
          <td class="right"><?php echo $data["ITM"][99]["SIZE_NORM"] ?></td>
          <td class="right"><?php echo $data["ITM"][99]["SIZE_LONG"] ?></td>
          <td class="right"><?php echo $data["ITM"][99]["REMARK"] ?></span></td>
        </tr>
      </tfoot>
    </table>
    <p><?php echo count($data["IMG"]); ?> data(s) is available by online intranet system only</p>
    <table>
      <tr>
        <td>Inspector,</td>
        <td>Manager QC,</td>
        <td>Manager PUR,</td>
      </tr>
      <tr class="height-10">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>...............</td>
        <td>...............</td>
        <td>...............</td>
      </tr>
    </table>
    <p>FULLY ACCEPTED / PARTIALLY ACCEPTED / REJECTED</p>
    </div>
    <?php 
    }
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        window.print();
      })
    </script>
  </body>
</html>
