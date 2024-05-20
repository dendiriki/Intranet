<!DOCTYPE html>
<html>
  <?php include 'common/header.php' ?> 

  <body>
    <?php include 'common/navigation.php' ?>
    <style>
      input[readonly], input[disabled] { 
        color: #000 !important;
      }
      
      input[type=text], input[type=number] {
        height: 2.2rem !important;
        font-size: 14px !important;
      }
      
    </style>
    <div class="section blue white-text padding-bottom-0">
      <div class="container row margin-bottom-0">
        <div class="col s6">
          <h5 id="sec-title">Local Scrap Inspection</h5>
        </div>
        <div class="col s6">
          <button class="btn waves-effect waves-light right" onclick="doPrint()">PRINT<i class="right material-icons">print</i></button>
        </div>
      </div>        
    </div>
    <div class="container">
      <div class="card margin-top-0">
        <div class="card-content padding-5">
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
            <div class="input-field col s2">
              <input id="SRL_NO" type="text" readonly value="<?php echo $data["HDR"]["SRLNO"]; ?>" style="text-align: center;">
              <label class="active" for="SRL_NO">Unl. Srl. No.</label>
            </div>
						<div class="input-field col s4">
              <input id="WSNUM" type="text" readonly value="<?php echo $data["HDR"]["WSNUM"]; ?>" style="text-align: center;">
              <label class="active" for="WSNUM">Weighment Slip</label>
            </div>
            <div class="input-field col s6">
              <input id="CRT_BY" type="text" readonly value="<?php echo $data["HDR"]["CRT_BY"]; ?>">
              <label class="active" for="CRT_BY">Inspector</label>
            </div>

            <div class="input-field col s6">
              <input id="CRT_DT" type="text" readonly value="<?php echo $data["HDR"]["CRT_DT"]; ?>">
              <label class="active" for="CRT_DT">Date</label>
            </div>
            <div class="input-field col s6">
              <input id="CRT_TM" type="text" readonly value="<?php echo $data["HDR"]["CRT_TM"]; ?>">
              <label class="active" for="CRT_TM">Time</label>
            </div>

            <div class="input-field col s6">
              <input id="VEHICLE_NO" type="text" readonly value="<?php echo $data["HDR"]["VHC_ACT"]; ?>">
              <label class="active" for="VEHICLE_NO">Vehicle No.</label>
            </div>
            <div class="input-field col s6">
              <input id="WEIGHT_F" type="number" readonly value="<?php echo $data["HDR"]["WHT_ACT"]; ?>">
              <label class="active" for="WEIGHT_F">First Weight</label>
            </div>
            <div class="input-field col s6">
              <input id="WEIGHT_E" type="number" value="<?php echo $data["HDR"]["WEIGHT_E"]; ?>">
              <label for="WEIGHT_E">Estimated Empty Weight</label>
            </div>
            <div class="input-field col s6">
              <input id="WEIGHT_N" type="number" readonly>
              <label for="WEIGHT_N">Estimated Nett Weight</label>
            </div>

          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
            <div class="col s4">
              <p>
                <input type="checkbox" class="filled-in" id="CONT_MRK" <?php if($data["HDR"]["CONT_MRK"] == "X") echo "checked"; ?>/>
                <label>Container</label>
              </p>
            </div>
            <div class="col s3">
              <p>
                <input type="checkbox" class="filled-in" id="CONT_SLD" disabled <?php if($data["HDR"]["CONT_SLD"] == "X") echo "checked"; ?>/>
                <label>Sealed</label>
              </p>
            </div>
            <div class="col s2">
              <p>
                <input type="checkbox" class="filled-in" id="CONT_FULL" disabled <?php if($data["HDR"]["CONT_FULL"] == "X") echo "checked"; ?>/>
                <label>Full</label>
              </p>
            </div>          
            <div class="col s2">
              <p>
                <input type="checkbox" class="filled-in" id="EIR_MRK" disabled <?php if($data["HDR"]["EIR_MRK"] == "X") echo "checked"; ?>/>
                <label>EIR</label>
              </p>
            </div> 
            <div class="input-field col s6">
              <input id="CONT_NO" class="char_count" type="text" data-length="100" readonly value="<?php echo $data["HDR"]["CONT_NO"]; ?>">
              <label for="CONT_NO">Container No.</label>
            </div>
            <div class="input-field col s6">
              <input id="ORIGIN" class="char_count" type="text" data-length="15" readonly value="<?php echo $data["HDR"]["ORIGIN"]; ?>">
              <label for="ORIGIN">Origin</label>
            </div>
            <div class="input-field col s6">
              <input id="EIR_DOC" class="char_count" type="text" data-length="255" readonly value="<?php echo $data["HDR"]["EIR_DOC"]; ?>">
              <label for="EIR_DOC">EIR Doc.</label>
            </div>
            <div class="input-field col s6">
              <input id="SLD_DOC" class="char_count" type="text" data-length="255" readonly value="<?php echo $data["HDR"]["SLD_DOC"]; ?>">
              <label for="SLD_DOC">Seal No.</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">  
            <div class="input-field col s6">
              <input id="CONT_LENGTH" type="number" class="not-cont" value="<?php echo $data["HDR"]["CONT_LENGTH"]; ?>">
              <label for="CONT_LENGTH">Length</label>
            </div>                    
            <div class="input-field col s6">
              <input id="CONT_WIDTH" type="number" class="not-cont" value="<?php echo $data["HDR"]["CONT_WIDTH"]; ?>">
              <label for="CONT_WIDTH">Width</label>
            </div>
            <div class="input-field col s6">
              <input id="CONT_HEIGHT" type="number" class="not-cont" value="<?php echo $data["HDR"]["CONT_HEIGHT"]; ?>">
              <label for="CONT_HEIGHT">Height</label>
            </div>          
            <div class="input-field col s6">
              <input id="DENS_E" type="number" readonly value="<?php echo $data["HDR"]["DENS_E"]; ?>">
              <label for="DENS_E">Estimated Density</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3 input-field"><b>Classification</b></div>
								<div class="col s2 input-field right-align"><b>Normal</b></div>
								<div class="col s2 input-field right-align"><b>Long</b></div>
								<div class="col s5 input-field center-align"><b>Remarks</b></div>
							</div>
						</div>
						
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Ship Plate</p></div>
								<div class="col s2 input-field"><input type="number" id="Z001A" class="ins-items" value="<?php echo $data["ITM"][0]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z001B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" id="Z001R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][0]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Fresh Plt./BSH</p></div>
								<div class="col s2 input-field"><input type="number" id="Z002A" class="ins-items" value="<?php echo $data["ITM"][1]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z002B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" id="Z002R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][1]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Premium</p></div>
								<div class="col s2 input-field"><input type="number" id="Z003A" class="ins-items" value="<?php echo $data["ITM"][2]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z003B" class="ins-items" value="<?php echo $data["ITM"][2]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z003R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][2]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Super A</p></div>
								<div class="col s2 input-field"><input type="number" id="Z004A" class="ins-items" value="<?php echo $data["ITM"][3]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z004B" class="ins-items" value="<?php echo $data["ITM"][3]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z004R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][3]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Super B</p></div>
								<div class="col s2 input-field"><input type="number" id="Z005A" class="ins-items" value="<?php echo $data["ITM"][4]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z005B" class="ins-items" value="<?php echo $data["ITM"][4]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z005R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][4]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade A</p></div>
								<div class="col s2 input-field"><input type="number" id="Z006A" class="ins-items" value="<?php echo $data["ITM"][5]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z006B" class="ins-items" value="<?php echo $data["ITM"][5]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z006R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][5]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade B</p></div>
								<div class="col s2 input-field"><input type="number" id="Z007A" class="ins-items" value="<?php echo $data["ITM"][6]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z007B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" id="Z007R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][6]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade C</p></div>
								<div class="col s2 input-field"><input type="number" id="Z008A" class="ins-items" value="<?php echo $data["ITM"][7]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z008B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" id="Z008R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][7]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">N. Cast Iron</p></div>
								<div class="col s2 input-field"><input type="number" id="Z009A" class="ins-items" value="<?php echo $data["ITM"][8]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z009B" class="ins-items" value="<?php echo $data["ITM"][8]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z009R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][8]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">BS Cast Iron</p></div>
								<div class="col s2 input-field"><input type="number" id="Z010A" class="ins-items" value="<?php echo $data["ITM"][9]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z010B" class="ins-items" value="<?php echo $data["ITM"][9]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z010R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][9]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">BMP SPL/ORD</p></div>
								<div class="col s2 input-field"><input type="number" id="Z011A" class="ins-items" value="<?php echo $data["ITM"][10]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z011B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" id="Z011R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][10]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">ROLLING ROLLS</p></div>
								<div class="col s2 input-field"><input type="number" id="Z012A" class="ins-items" value="<?php echo $data["ITM"][11]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z012B" class="ins-items" value="<?php echo $data["ITM"][11]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z012R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][11]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">COUNTER WEIGHT</p></div>
								<div class="col s2 input-field"><input type="number" id="Z013A" class="ins-items" value="<?php echo $data["ITM"][12]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" id="Z013B" class="ins-items" value="<?php echo $data["ITM"][12]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" id="Z013R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][12]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 purple lighten-4">
							<div class="row">
								<div class="col s3"><p class="padding-top-10">Total</p></div>
								<div class="col s2 input-field"><input type="number" id="TOTALA" readonly></div>
								<div class="col s2 input-field"><input type="number" id="TOTALB" readonly></div>
								<div class="col s5 input-field"><input type="number" id="TOTALX" readonly></div>
							</div>
						</div>
								
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
            <div class="col s12"><p>Deduction</p></div>
            
            <div class="col s2 padding-top-10">
              <p class="col s6">
                <input class="with-gap" name="DED_IND" id="DED_IND_KG" type="radio" <?php if($data["HDR"]["DED_IND"] == "K"){ echo "checked";} ?> />
                <label for="DED_IND_KG">KG</label>
              </p>
            </div>
            <div class="input-field col s2">
              <input id="DED_KG" type="number" value="<?php echo $data["HDR"]["DED_KG"]; ?>">
              <label for="DED_KG">Deduction(Kg)</label>
            </div>
            <div class="col s2 padding-top-10">
              <p class="col s6">
                <input class="with-gap" name="DED_IND" id="DED_IND_PR" type="radio" <?php if($data["HDR"]["DED_IND"] == "P"){ echo "checked";} ?>  />
                <label for="DED_IND_PR">%</label>
              </p>
            </div>
            <div class="input-field col s2">
              <input id="DED_PR" type="number" value="<?php echo $data["HDR"]["DED_PR"]; ?>">
              <label for="DED_PR">Deduction(%)</label>
            </div>
            <div class="input-field col s4">
              <input id="DED_RMK" type="text" data-length="200" value="<?php echo $data["HDR"]["DED_RMK"]; ?>">
              <label for="DED_RMK">Deduction Remarks</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">  
            <div class="input-field col s3">
              <p>
                <input type="checkbox" class="filled-in" id="REJ_MRK" <?php if($data["HDR"]["REJ_MRK"] == "X") echo "checked"; ?> />
                <label>Reject</label>
              </p>
            </div>
            <div class="input-field col s3">
              <p>
                <input type="checkbox" class="filled-in" id="REJ_FULL" disabled <?php if($data["HDR"]["REJ_FULL"] == "X") echo "checked"; ?> />
                <label>Full Reject</label>
              </p>
            </div>
            <div class="input-field col s6">
              <input id="REJ_RMK" class="char_count" type="text" data-length="200" readonly value="<?php echo $data["HDR"]["REJ_RMK"]; ?>">
              <label for="REJ_RMK">Rejection Remarks</label>
            </div>

            <div class="input-field col s6">
              <p>
                <input type="checkbox" class="filled-in" id="SHORT_SIZE_IND" <?php if($data["HDR"]["SHORT_SIZE_IND"] == "X") echo "checked"; ?> />
                <label>Short Size Incentive</label>
              </p>
            </div>
            <div class="input-field col s6">
              <p>
                <input type="checkbox" class="filled-in" id="PREM_IND" <?php if($data["HDR"]["PREM_IND"] == "X") echo "checked"; ?> />
                <label>Premium Incentive</label>
              </p>
            </div>

            <div class="input-field col s4">
              <input id="PENALTY" type="number" value="<?php echo $data["HDR"]["PENALTY"]; ?>">
              <label for="PENALTY">Penalty</label>
            </div>
            <div class="input-field col s8">
              <input id="PENALTY_RMK" class="char_count" type="text" data-length="200" readonly value="<?php echo $data["HDR"]["PENALTY_RMK"]; ?>">
              <label for="PENALTY_RMK">Penalty Remarks</label>
            </div>

            <div class="input-field col s6">
              <p>
                <input type="checkbox" class="filled-in" id="SUR_IND" <?php if($data["HDR"]["SUR_IND"] == "X") echo "checked"; ?>/>
                <label>Inter Island Surcharge</label>
              </p>
            </div>
            <div class="input-field col s6">
              <input id="SUR_RMK" class="char_count" type="text" data-length="200" readonly value="<?php echo $data["HDR"]["SUR_RMK"]; ?>">
              <label for="SUR_RMK">Surcharge Remarks</label>
            </div>

            <div class="input-field col s12">
              <textarea id="NOTE" class="materialize-textarea char_count" data-length="200"><?php echo $data["HDR"]["NOTE"]; ?></textarea>
              <label for="NOTE">Notes</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 z-depth-1">
            <div class="col s12">
              <h6 class="center">Pictures</h6>
            </div>
            <div class="col s12">
              <div id="image-holder" class="row">
                <?php 
                if(!empty($data["IMG"])) {
                  foreach($data["IMG"] as $img) {
                ?>
                <div class='col s3'><img src='../ws_scrap/media/inspection/<?php echo $data["HDR"]["WSNUM"]; ?>/photo/<?php echo $img ?>' class='materialboxed responsive-img'></div>
                <?php
                  }
                }
                ?>
              </div>
            </div>            
          </div>
          
          <div class="row margin-top-0 padding-top-20 z-depth-1">
            <div class="col s12">
              <h6 class="center">Documents</h6>
            </div>
            <div class="col s12">
              <div id="document-holder" class="row">
                <?php 
                if(!empty($data["DOC"])) {
                  foreach($data["DOC"] as $img) {
                ?>
                <div class='col s3'><img src='../ws_scrap/media/inspection/<?php echo $data["HDR"]["WSNUM"]; ?>/document/<?php echo $img ?>' class='materialboxed responsive-img'></div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>          
      </div>
    </div>
    <input type="hidden" name="current_page" id="current_page">
    <!--JavaScript at end of body for optimized loading-->
    <?php include 'common/footer.php' ?>  
    <script>
      $(document).ready(function(){
        $("input[type=text], input[type=number], textarea").attr("readonly","readonly");
        $("input[type=checkbox], input[type=radio]").attr("disabled","disabled");
        
        calNettWt();
        calculateItem();
      });
      
      function calNettWt() {
        var weight_f = $("#WEIGHT_F").val();
        var weight_e = $("#WEIGHT_E").val();
        if(weight_e === " " || weight_e === null || weight_e === false) {
          weight_e = 0;
        }
        var weight_n = weight_f - weight_e;
        $("#WEIGHT_N").val(weight_n);
        //M.updateTextFields();
      }
      
      function calculateItem() {
        var Z001A = 0;
        var Z002A = 0;
        var Z003A = 0; var Z003B = 0;
        var Z004A = 0; var Z004B = 0;
        var Z005A = 0; var Z005B = 0;
        var Z006A = 0; var Z006B = 0;
        var Z007A = 0;
        var Z008A = 0;
        var Z009A = 0; var Z009B = 0;
        var Z010A = 0; var Z010B = 0;
        var Z011A = 0;
				var Z012A = 0; var Z012B = 0;
				var Z013A = 0; var Z013B = 0;
        
        if($("#Z001A").val() !== null && $("#Z001A").val() !== false && $("#Z001A").val() !== "") {Z001A = parseFloat($("#Z001A").val());}
        if($("#Z002A").val() !== null && $("#Z002A").val() !== false && $("#Z002A").val() !== "") {Z002A = parseFloat($("#Z002A").val());}
        if($("#Z003A").val() !== null && $("#Z003A").val() !== false && $("#Z003A").val() !== "") {Z003A = parseFloat($("#Z003A").val());}
        if($("#Z003B").val() !== null && $("#Z003B").val() !== false && $("#Z003B").val() !== "") {Z003B = parseFloat($("#Z003B").val());}
        if($("#Z004A").val() !== null && $("#Z004A").val() !== false && $("#Z004A").val() !== "") {Z004A = parseFloat($("#Z004A").val());}
        if($("#Z004B").val() !== null && $("#Z004B").val() !== false && $("#Z004B").val() !== "") {Z004B = parseFloat($("#Z004B").val());}
        if($("#Z005A").val() !== null && $("#Z005A").val() !== false && $("#Z005A").val() !== "") {Z005A = parseFloat($("#Z005A").val());}
        if($("#Z005B").val() !== null && $("#Z005B").val() !== false && $("#Z005B").val() !== "") {Z005B = parseFloat($("#Z005B").val());}
        if($("#Z006A").val() !== null && $("#Z006A").val() !== false && $("#Z006A").val() !== "") {Z006A = parseFloat($("#Z006A").val());}
        if($("#Z006B").val() !== null && $("#Z006B").val() !== false && $("#Z006B").val() !== "") {Z006B = parseFloat($("#Z006B").val());}
        if($("#Z007A").val() !== null && $("#Z007A").val() !== false && $("#Z007A").val() !== "") {Z007A = parseFloat($("#Z007A").val());}
        if($("#Z008A").val() !== null && $("#Z008A").val() !== false && $("#Z008A").val() !== "") {Z008A = parseFloat($("#Z008A").val());}
        if($("#Z009A").val() !== null && $("#Z009A").val() !== false && $("#Z009A").val() !== "") {Z009A = parseFloat($("#Z009A").val());}
        if($("#Z009B").val() !== null && $("#Z009B").val() !== false && $("#Z009B").val() !== "") {Z009B = parseFloat($("#Z009B").val());}
        if($("#Z010A").val() !== null && $("#Z010A").val() !== false && $("#Z010A").val() !== "") {Z010A = parseFloat($("#Z010A").val());}
        if($("#Z010B").val() !== null && $("#Z010B").val() !== false && $("#Z010B").val() !== "") {Z010B = parseFloat($("#Z010B").val());}
        if($("#Z011A").val() !== null && $("#Z011A").val() !== false && $("#Z011A").val() !== "") {Z011A = parseFloat($("#Z011A").val());}
				if($("#Z012A").val() !== null && $("#Z012A").val() !== false && $("#Z012A").val() !== "") {Z012A = parseFloat($("#Z012A").val());}
        if($("#Z012B").val() !== null && $("#Z012B").val() !== false && $("#Z012B").val() !== "") {Z012B = parseFloat($("#Z012B").val());}
				if($("#Z013A").val() !== null && $("#Z013A").val() !== false && $("#Z013A").val() !== "") {Z013A = parseFloat($("#Z013A").val());}
        if($("#Z013B").val() !== null && $("#Z013B").val() !== false && $("#Z013B").val() !== "") {Z013B = parseFloat($("#Z013B").val());}
        
        var totala = Z001A + Z002A + Z003A + Z004A + Z005A + Z006A + Z007A + Z008A + Z009A + Z010A + Z011A + Z012A + Z013A;
        var totalb = Z003B + Z004B + Z005B + Z006B + Z009B + Z010B + Z012B + Z013B;
        var totalx = totala + totalb;
        
        $("#TOTALA").val(totala);
        $("#TOTALB").val(totalb);
        $("#TOTALX").val(totalx);
        
        //M.updateTextFields();
      }
      
      function doPrint() {
        var wsnum = $("#WSNUM").val();
        window.open("index.php?action=scrap_inspection&wsnum="+wsnum+"&print=true", '_blank');
      }
    </script>
  </body>
</html>