<!DOCTYPE html>
<html>
  <?php include 'common/header.php' ?> 

  <body>
    <?php include 'common/navigation.php' ?>
    <style>
      input[readonly] { 
        color: #000 !important;
      }
      
			input[disabled] { 
        background-color: #E0E0DD !important;
      }
			
      input[type=text], input[type=number] {
        height: 2.2rem !important;
        font-size: 14px !important;
      }
      
    </style>
		<form action="index.php?action=<?php echo $action ?>&wsnum=<?php echo $wsnum ?>" method="post">
    <div class="section blue white-text padding-bottom-0">
      <div class="container row margin-bottom-0">
        <div class="col s6">
          <h5 id="sec-title">Local Scrap Inspection</h5>
        </div>
        <div class="col s3">
          <button type="button" class="btn waves-effect waves-light right" onclick="doPrint()">PRINT<i class="right material-icons">print</i></button>
        </div>
				<div class="col s3">
          <button type="submit" class="btn waves-effect waves-light right" id="btn_save" name="save" value="save">save<i class="right material-icons">save</i></button>
        </div>
      </div>        
    </div>
    <div class="container">
      <div class="card margin-top-0">
        <div class="card-content padding-5">
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
						<div class="input-field col s2">
              <input name="SRL_NO" id="SRL_NO" type="text" readonly value="<?php echo $data["HDR"]["SRLNO"]; ?>" style="text-align: center;">
              <label class="active" for="SRL_NO">Unl. Srl. No.</label>
            </div>
            <div class="input-field col s4">
              <input name="WSNUM" id="WSNUM" type="text" readonly value="<?php echo $data["HDR"]["WSNUM"]; ?>">
              <label class="active" for="WSNUM">Weighment Slip</label>
            </div>
            <div class="input-field col s6">
              <input name="CRT_BY" id="CRT_BY" type="text" readonly value="<?php echo $data["HDR"]["CRT_BY"]; ?>">
              <label class="active" for="CRT_BY">Inspector</label>
            </div>

            <div class="input-field col s6">
              <input name="CRT_DT" id="CRT_DT" type="text" placeholder="DD.MM.YYYY" readonly value="<?php echo $data["HDR"]["CRT_DT"]; ?>">
              <label class="active" for="CRT_DT">Date</label>
            </div>
            <div class="input-field col s6">
              <input name="CRT_TM" id="CRT_TM" type="text" readonly value="<?php echo $data["HDR"]["CRT_TM"]; ?>">
              <label class="active" for="CRT_TM">Time</label>
            </div>

            <div class="input-field col s6">
              <input name="VEHICLE_NO" id="VEHICLE_NO" type="text" value="<?php echo $data["HDR"]["VEHICLE_NO"]; ?>">
              <label class="active" for="VEHICLE_NO">Vehicle No.</label>
            </div>
            <div class="input-field col s6">
              <input name="WEIGHT_F" id="WEIGHT_F" type="number" step="any" readonly value="<?php echo $data["HDR"]["WEIGHT_F"]; ?>">
              <label class="active" for="WEIGHT_F">First Weight</label>
            </div>
            <div class="input-field col s6">
              <input name="WEIGHT_E" id="WEIGHT_E" type="number" step="any" value="<?php echo $data["HDR"]["WEIGHT_E"]; ?>">
              <label for="WEIGHT_E">Estimated Empty Weight</label>
            </div>
            <div class="input-field col s6">
              <input name="WEIGHT_N" id="WEIGHT_N" type="number" step="any" readonly>
              <label for="WEIGHT_N">Estimated Nett Weight</label>
            </div>

          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
            <div class="col s4">
              <p>
                <input name="CONT_MRK" id="CONT_MRK" type="checkbox" class="filled-in" <?php if($data["HDR"]["CONT_MRK"] == "X") echo "checked"; ?>/>
                <label for="CONT_MRK">Container</label>
              </p>
            </div>
            <div class="col s3">
              <p>
                <input name="CONT_SLD" id="CONT_SLD" type="checkbox" class="filled-in" disabled <?php if($data["HDR"]["CONT_SLD"] == "X") echo "checked"; ?>/>
                <label for="CONT_SLD">Sealed</label>
              </p>
            </div>
            <div class="col s2">
              <p>
                <input name="CONT_FULL" id="CONT_FULL" type="checkbox" class="filled-in" disabled <?php if($data["HDR"]["CONT_FULL"] == "X") echo "checked"; ?>/>
                <label for="CONT_FULL">Full</label>
              </p>
            </div>          
            <div class="col s2">
              <p>
                <input name="EIR_MRK" id="EIR_MRK" type="checkbox" class="filled-in" disabled <?php if($data["HDR"]["EIR_MRK"] == "X") echo "checked"; ?>/>
                <label for="EIR_MRK">EIR</label>
              </p>
            </div> 
            <div class="input-field col s6">
              <input name="CONT_NO" id="CONT_NO" class="char_count" readonly="readonly"  type="text" data-length="100" value="<?php echo $data["HDR"]["CONT_NO"]; ?>">
              <label for="CONT_NO">Container No.</label>
            </div>
            <div class="input-field col s6">
              <input name="ORIGIN" id="ORIGIN" class="char_count" readonly="readonly"  type="text" data-length="15" value="<?php echo $data["HDR"]["ORIGIN"]; ?>">
              <label for="ORIGIN">Origin</label>
            </div>
            <div class="input-field col s6">
              <input name="EIR_DOC" id="EIR_DOC" class="char_count" readonly="readonly" type="text" data-length="255" value="<?php echo $data["HDR"]["EIR_DOC"]; ?>">
              <label for="EIR_DOC">EIR Doc.</label>
            </div>
            <div class="input-field col s6">
              <input name="SLD_DOC" id="SLD_DOC" class="char_count" readonly="readonly" type="text" data-length="255" value="<?php echo $data["HDR"]["SLD_DOC"]; ?>">
              <label for="SLD_DOC">Seal No.</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">  
            <div class="input-field col s6">
              <input name="CONT_LENGTH" id="CONT_LENGTH" type="number" step="any" class="not-cont" value="<?php echo $data["HDR"]["CONT_LENGTH"]; ?>">
              <label for="CONT_LENGTH">Length</label>
            </div>                    
            <div class="input-field col s6">
              <input name="CONT_WIDTH" id="CONT_WIDTH" type="number" step="any" class="not-cont" value="<?php echo $data["HDR"]["CONT_WIDTH"]; ?>">
              <label for="CONT_WIDTH">Width</label>
            </div>
            <div class="input-field col s6">
              <input name="CONT_HEIGHT" id="CONT_HEIGHT" type="number" step="any" class="not-cont" value="<?php echo $data["HDR"]["CONT_HEIGHT"]; ?>">
              <label for="CONT_HEIGHT">Height</label>
            </div>          
            <div class="input-field col s6">
              <input name="DENS_E" id="DENS_E" type="number" step="any" readonly value="<?php echo $data["HDR"]["DENS_E"]; ?>">
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
								<div class="col s2 input-field"><input type="number" step="any" id="Z001A" name="Z001A" class="ins-items" value="<?php echo $data["ITM"][0]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" id="Z001B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" name="Z001R" id="Z001R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][0]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Fresh Plt./BSH</p></div>
								<div class="col s2 input-field"><input type="number" step="any" id="Z002A" name="Z002A" class="ins-items" value="<?php echo $data["ITM"][1]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" id="Z002B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" name="Z002R" id="Z002R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][1]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Premium</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z003A" id="Z003A" class="ins-items" value="<?php echo $data["ITM"][2]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z003B" id="Z003B" class="ins-items" value="<?php echo $data["ITM"][2]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z003R" id="Z003R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][2]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Super A</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z004A" id="Z004A" class="ins-items" value="<?php echo $data["ITM"][3]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z004B" id="Z004B" class="ins-items" value="<?php echo $data["ITM"][3]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z004R" id="Z004R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][3]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Super B</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z005A" id="Z005A" class="ins-items" value="<?php echo $data["ITM"][4]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z005B" id="Z005B" class="ins-items" value="<?php echo $data["ITM"][4]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z005R" id="Z005R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][4]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade A</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z006A" id="Z006A" class="ins-items" value="<?php echo $data["ITM"][5]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z006B" id="Z006B" class="ins-items" value="<?php echo $data["ITM"][5]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z006R" id="Z006R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][5]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade B</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z007A" id="Z007A" class="ins-items" value="<?php echo $data["ITM"][6]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z007B" id="Z007B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" name="Z007R" id="Z007R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][6]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">Grade C</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z008A" id="Z008A" class="ins-items" value="<?php echo $data["ITM"][7]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z008B" id="Z008B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" name="Z008R" id="Z008R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][7]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">N. Cast Iron</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z009A" id="Z009A" class="ins-items" value="<?php echo $data["ITM"][8]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z009B" id="Z009B" class="ins-items" value="<?php echo $data["ITM"][8]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z009R" id="Z009R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][8]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">BS Cast Iron</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z010A" id="Z010A" class="ins-items" value="<?php echo $data["ITM"][9]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z010B" id="Z010B" class="ins-items" value="<?php echo $data["ITM"][9]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z010R" id="Z010R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][9]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">BMP SPL/ORD</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z011A" id="Z011A" class="ins-items" value="<?php echo $data["ITM"][10]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z011B" id="Z011B" disabled value="0"></div>
								<div class="col s5 input-field"><input type="text" name="Z011R" id="Z011R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][10]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">ROLLING ROLLS</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z012A" id="Z012A" class="ins-items" value="<?php echo $data["ITM"][11]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z012B" id="Z012B" class="ins-items" value="<?php echo $data["ITM"][11]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z012R" id="Z012R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][11]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 border-bottom-1">
							<div class="row margin-bottom-0">
								<div class="col s3"><p class="padding-top-10">COUNTER WEIGHT</p></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z013A" id="Z013A" class="ins-items" value="<?php echo $data["ITM"][12]["SIZE_NORM"] ?>"></div>
								<div class="col s2 input-field"><input type="number" step="any" name="Z013B" id="Z013B" class="ins-items" value="<?php echo $data["ITM"][12]["SIZE_LONG"] ?>"></div>
								<div class="col s5 input-field"><input type="text" name="Z013R" id="Z013R" class="char_count ins-items" data-length="200" value="<?php echo $data["ITM"][12]["REMARK"] ?>"></div>
							</div>
						</div>
						<div class="col s12 purple lighten-4">
							<div class="row">
								<div class="col s3"><p class="padding-top-10">Total</p></div>
								<div class="col s2 input-field"><input type="number" step="any" id="TOTALA" readonly></div>
								<div class="col s2 input-field"><input type="number" step="any" id="TOTALB" readonly></div>
								<div class="col s5 input-field"><input type="number" step="any" id="TOTALX" readonly></div>
							</div>
						</div>
								
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">
            <div class="col s12"><p>Deduction</p></div>
            
            <div class="col s2 padding-top-10">
              <p class="col s6">
                <input class="with-gap" name="DED_IND" id="DED_IND_KG" type="radio" value="K" <?php if($data["HDR"]["DED_IND"] == "K"){ echo "checked";} ?> />
                <label for="DED_IND_KG">KG</label>
              </p>
            </div>
            <div class="input-field col s2">
              <input name="DED_KG" id="DED_KG" type="number" step="any" value="<?php echo $data["HDR"]["DED_KG"]; ?>">
              <label for="DED_KG">Deduction(Kg)</label>
            </div>
            <div class="col s2 padding-top-10">
              <p class="col s6">
                <input class="with-gap" name="DED_IND" id="DED_IND_PR" type="radio" value="P" <?php if($data["HDR"]["DED_IND"] == "P"){ echo "checked";} ?>  />
                <label for="DED_IND_PR">%</label>
              </p>
            </div>
            <div class="input-field col s2">
              <input name="DED_PR" id="DED_PR" type="number" step="any" value="<?php echo $data["HDR"]["DED_PR"]; ?>">
              <label for="DED_PR">Deduction(%)</label>
            </div>
            <div class="input-field col s4">
              <input name="DED_RMK" id="DED_RMK" type="text" data-length="200" value="<?php echo $data["HDR"]["DED_RMK"]; ?>">
              <label for="DED_RMK">Deduction Remarks</label>
            </div>
          </div>
          <div class="row margin-top-0 padding-top-20 margin-bottom-5 z-depth-1">  
            <div class="input-field col s3">
              <p>
                <input name="REJ_MRK" id="REJ_MRK" type="checkbox" class="filled-in" <?php if($data["HDR"]["REJ_MRK"] == "X" || $data["HDR"]["REJ_MRK"] == "F") echo "checked"; ?> />
                <label for="REJ_MRK">Reject</label>
              </p>
            </div>
            <div class="input-field col s3">
              <p>
                <input name="REJ_FULL" id="REJ_FULL" type="checkbox" class="filled-in" disabled <?php if($data["HDR"]["REJ_MRK"] == "F") echo "checked"; ?> />
                <label for="REJ_FULL">Full Reject</label>
              </p>
            </div>
            <div class="input-field col s6">
              <input name="REJ_RMK" id="REJ_RMK" class="char_count" type="text" data-length="200" readonly value="<?php echo $data["HDR"]["REJ_RMK"]; ?>">
              <label for="REJ_RMK">Rejection Remarks</label>
            </div>

            <div class="input-field col s6">
              <p>
                <input name="SHORT_SIZE_IND" id="SHORT_SIZE_IND" type="checkbox" disabled="disabled" class="filled-in" <?php if($data["HDR"]["SHORT_SIZE_IND"] == "X") echo "checked"; ?> />
                <label for="SHORT_SIZE_IND">Short Size Incentive</label>
              </p>
            </div>
            <div class="input-field col s6">
              <p>
                <input name="PREM_IND" id="PREM_IND" type="checkbox" disabled="disabled" class="filled-in" <?php if($data["HDR"]["PREM_IND"] == "X") echo "checked"; ?> />
                <label for="PREM_IND">Premium Incentive</label>
              </p>
            </div>

            <div class="input-field col s4">
              <input name="PENALTY" id="PENALTY" type="number" step="any" value="<?php echo $data["HDR"]["PENALTY"]; ?>">
              <label for="PENALTY">Penalty</label>
            </div>
            <div class="input-field col s8">
              <input name="PENALTY_RMK" id="PENALTY_RMK" class="char_count" type="text" data-length="200" readonly value="<?php echo $data["HDR"]["PENALTY_RMK"]; ?>">
              <label for="PENALTY_RMK">Penalty Remarks</label>
            </div>

            <div class="input-field col s6">
              <p>
                <input name="SUR_IND" id="SUR_IND" type="checkbox" disabled="disabled" class="filled-in" <?php if($data["HDR"]["SUR_IND"] == "X") echo "checked"; ?>/>
                <label>Inter Island Surcharge</label>
              </p>
            </div>
            <div class="input-field col s6">
              <input name="SUR_RMK" id="SUR_RMK" class="char_count" type="text" data-length="200" disabled="disabled" value="<?php echo $data["HDR"]["SUR_RMK"]; ?>">
              <label for="SUR_RMK">Surcharge Remarks</label>
            </div>

            <div class="input-field col s12">
              <textarea name="NOTE" id="NOTE" class="materialize-textarea char_count" data-length="200"><?php echo $data["HDR"]["NOTE"]; ?></textarea>
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
			<input type="hidden" name="DEVICE_ID" value="<?php echo $data["HDR"]["DEVICE_ID"]; ?>" />
		</form>
    <input type="hidden" name="current_page" id="current_page">
    <!--JavaScript at end of body for optimized loading-->
    <?php include 'common/footer.php' ?>  
    <script>
      $(document).ready(function(){
        //$("input[type=text], input[type=number], textarea").attr("readonly","readonly");
        //$("input[type=checkbox], input[type=radio]").attr("disabled","disabled");
        
        calNettWt();
        calculateItem();
				checkContainer();
      });
      
			$("#WEIGHT_E").change(function() {
				calNettWt();
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
			
			$("#CONT_MRK").change(function() {
				checkContainer();
			});
			
			function checkContainer() {
        if($("#CONT_MRK").is(':checked')) {          
          $("#CONT_NO").removeAttr("readonly");
          $("#ORIGIN").removeAttr("readonly");
          $("#CONT_SLD").removeAttr("disabled");
          $("#CONT_FULL").removeAttr("disabled");
          $("#EIR_MRK").removeAttr("disabled");
          
					$("#DENS_E").val("0");
          $(".not-cont").val("0");
          $(".not-cont").attr("readonly","readonly");
        } else {
          $("#CONT_NO").val("");
          $("#CONT_NO").attr("readonly","readonly");
          
          $("#ORIGIN").val("");
          $("#ORIGIN").attr("readonly","readonly");
          
          $("#CONT_SLD").prop("checked", false);
          $("#CONT_SLD").attr("disabled","disabled");
          
          $("#CONT_FULL").prop("checked", false);
          $("#CONT_FULL").attr("disabled","disabled");
          
          $("#EIR_MRK").prop("checked", false);
          $("#EIR_MRK").attr("disabled","disabled");
          
          $("#EIR_DOC").val("");
          $("#EIR_DOC").attr("readonly","readonly");
          
          $("#SLD_DOC").val("");
          $("#SLD_DOC").attr("readonly","readonly");
          
          $(".not-cont").removeAttr("readonly");          
        }
        //M.updateTextFields();
      }
			
			$("#CONT_SLD").change(function(){
				checkSLD();
			});
      
      function checkSLD() {
        if($("#CONT_SLD").is(':checked')) {
          $("#SLD_DOC").removeAttr("readonly");
        } else {
          $("#SLD_DOC").val("");
          $("#SLD_DOC").attr("readonly","readonly");
        }
      }			
			
			$("#EIR_MRK").change(function() {
				checkEIR();
			});
      
      function checkEIR() {
        if($("#EIR_MRK").is(':checked')) {
          $("#EIR_DOC").removeAttr("readonly");
        } else {
          $("#EIR_DOC").val("");
          $("#EIR_DOC").attr("readonly","readonly");
        }
      }
			
			$(".not-cont").change(function() {
				calDensity();
			});
			
			function calDensity() {
        var nett_wt = $("#WEIGHT_N").val();        
        var length = $("#CONT_LENGTH").val();
        if(length === " " || length === null || length === false) {
          length = 0;
        }
        var width = $("#CONT_WIDTH").val();
        if(width === " " || width === null || width === false) {
          width = 0;
        }
        var height = $("#CONT_HEIGHT").val();
        if(height === " " || height === null || height === false) {
          height = 0;
        }        
        var volume = length * width * height;
        var density = 0;
        density = ( nett_wt / volume ).toFixed(2);
        $("#DENS_E").val(density);
        //M.updateTextFields();
      }
      
			$(".ins-items").change(function() {
				calculateItem();
			});
			
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
        
				if(totalx > 100) {
					$("#btn_save").attr("disabled","disabled");
					alert("Jumlah item tidak boleh lebih dari 100%");
				} else {
					$("#btn_save").removeAttr("disabled");
				}
        //M.updateTextFields();
      }
      
			$("#DED_KG").bind('keyup input', function(){
				calculateDeduction("KG");
			});

			$("#DED_PR").bind('keyup input', function(){
				calculateDeduction("PR");
			});
			
			function calculateDeduction(type) {
        var weight_n = $("#WEIGHT_N").val();
        var ded_kg = 0;
        var ded_pr = 0;
        if(type === "KG") {
          //hitung persen
					//get indicator
					if($("#DED_IND_KG").prop("checked")) {
						ded_kg = $("#DED_KG").val();
						ded_pr = (( ded_kg / weight_n ) * 100).toFixed(2);
						$("#DED_PR").val(ded_pr);
					}
        } else if(type === "PR") {
					if($("#DED_IND_PR").prop("checked")) {
						ded_pr = $("#DED_PR").val();
						ded_kg = (( weight_n * ded_pr ) / 100).toFixed(2);
						$("#DED_KG").val(ded_kg);
					}
        }
        //M.updateTextFields();
      }
			
			$("#DED_IND_KG").change(function(){
				checkDedInd();
			});
			
			$("#DED_IND_PR").change(function(){
				checkDedInd();
			});   
			
      function checkDedInd() {
        if($("#DED_IND_KG").is(':checked')) {
          $("#DED_KG").removeAttr("readonly");
          $("#DED_PR").attr("readonly","readonly");
        } 
        
        if($("#DED_IND_PR").is(':checked')) {
          $("#DED_KG").attr("readonly","readonly");
          $("#DED_PR").removeAttr("readonly");
        } 
      }
      
			$("#REJ_MRK").change(function() {
				checkRejection();
			});
			
      function checkRejection() {
        if($("#REJ_MRK").is(':checked')) {
          $("#REJ_RMK").removeAttr("readonly");
          $("#REJ_FULL").removeAttr("disabled");
        } else {
          $("#REJ_RMK").val("");
          $("#REJ_RMK").attr("readonly","readonly");
          
          $("#REJ_FULL").prop("checked", false);
          $("#REJ_FULL").attr("disabled","disabled");
        }
        //M.updateTextFields();
      }

			$("#REJ_FULL").change(function() {
				checkFullReject();
			});
			
      function checkFullReject() {
        if($("#REJ_FULL").is(':checked')) {
          $(".ins-items").val("");
          $(".ins-items").attr("readonly","readonly");
          $("#TOTALA, #TOTALB, #TOTALX").val("0");          
        } else {
          $(".ins-items").removeAttr("readonly");
        }
      }
			
      $("#PENALTY").bind('keyup input',function(){
				checkPenalty();
			});
				
      function checkPenalty() {
        var penalty = $("#PENALTY").val();
        if(penalty.length > 0) {
          $("#PENALTY_RMK").removeAttr("readonly");
        } else {
          $("#PENALTY_RMK").val("");
          $("#PENALTY_RMK").attr("readonly","readonly");
        }
        //M.updateTextFields();
      }
      
			$("#SUR_IND").change(function(){
				checkSurcharge();
			});
			
      function checkSurcharge() {
        if($("#SUR_IND").is(':checked')) {
          $("#SUR_RMK").removeAttr("readonly");
        } else {
          $("#SUR_RMK").val("");
          $("#SUR_RMK").attr("readonly","readonly");
        }
        //M.updateTextFields();
      }
			
      function doPrint() {
        var wsnum = $("#WSNUM").val();
        window.open("index.php?action=scrap_inspection&wsnum="+wsnum+"&print=true", '_blank');
      }
    </script>
  </body>
</html>