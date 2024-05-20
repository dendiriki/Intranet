<!DOCTYPE html>
<html lang="en">
    <?php include 'common/header.php' ?>

    <body>
        <style>
            h5 {
                margin-top : 0px !important;
                margin-bottom: 0px !important;
            }

            .container-fluid {
                width: 85%;
                margin: 0 auto;
                max-width: 1280px;
            }

            h5 {
                font-size: 1.5rem !important;
            }
        </style>
        <?php include 'common/navigation.php' ?>
        <div class="section light-blue">
            <div class="container-fluid">
                <h5 class="white-text center-align">
                    SMS Sample Analysis, [<span id="val_type"><?php echo $type; ?></span>] Heat : <span id="val_heat"><?php echo $data_header["VCHEAT"]; ?></span> Sample No: <span id="val_sample_no"><?php echo $data_header["SAMPLE_NO"]; ?></span> Liq. Tmp <sup>o</sup>C : <span id="val_ltmp"><?php echo $lTemp; ?></span>
                </h5>
            </div>
        </div>
        <div class="section" style="margin-top: 0px !important;padding-top: 0px !important;">
            <div class="container">
                <div class="row" style="margin-bottom: 0px !important;">					
                    <div class="col s12 m12">
                        <div class="card">
                            <div class="card-content">	
                                <form methd="get" action="index.php">
                                    <input type="hidden" name="action" value="<?php echo $action; ?>">
                                    <input type="hidden" id="type" value="<?php echo $type; ?>">
                                    <table class="table striped">
                                        <tr>
                                            <td><h5><input type="submit" class="btn" style="width: 100%;" name="type" value="EAF"></h5></td>
                                            <td><h5><input type="submit" class="btn" style="width: 100%;" name="type" value="LRF"></h5></td>
                                            <td><h5><input type="submit" class="btn" style="width: 100%;" name="type" value="CCM"></h5></td>
                                            <td><h5><input type="submit" class="btn" style="width: 100%;" name="type" value="SLE"></h5></td>
                                            <td><h5><input type="submit" class="btn" style="width: 100%;" name="type" value="SLL"></h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align amber-text text-darken-4"><h5>FE</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>C</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Mn</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>P</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>S</h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align"><h5 id="val_fe"><?php echo floatval($data_content["FE"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_c"><?php echo floatval($data_content["C"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_mn"><?php echo floatval($data_content["MN"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_p"><?php echo floatval($data_content["P"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_s"><?php echo floatval($data_content["S"]); ?></h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align amber-text text-darken-4"><h5>Si</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Sn</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Al</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Cr</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Cu</h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align"><h5 id="val_si"><?php echo floatval($data_content["SI"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_sn"><?php echo floatval($data_content["SN"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_al"><?php echo floatval($data_content["AL"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_cr"><?php echo floatval($data_content["CR"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_cu"><?php echo floatval($data_content["CU"]); ?></h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align amber-text text-darken-4"><h5>Ni</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>V</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Mo</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Nb</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>Ca</h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align"><h5 id="val_ni"><?php echo floatval($data_content["NI"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_v"><?php echo floatval($data_content["V"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_mo"><?php echo floatval($data_content["MO"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_nb"><?php echo floatval($data_content["NB"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_ca"><?php echo floatval($data_content["CA"]); ?></h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align amber-text text-darken-4"><h5>Co</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>CE</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>TS</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>RATIO</h5></td>
                                            <td class="center-align amber-text text-darken-4"><h5>&nbsp;</h5></td>
                                        </tr>
                                        <tr>
                                            <td class="center-align"><h5 id="val_co"><?php echo floatval($data_content["CO"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_ce"><?php echo floatval($data_content["CE"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_ts"><?php echo floatval($data_content["TS"]); ?></h5></td>
                                            <td class="center-align"><h5 id="val_ratio"><?php echo floatval($data_content["RATIO"]); ?></h5></td>
                                            <td class="center-align"><h5>&nbsp;</h5></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'common/footer.php' ?>  
        <script type="text/javascript">
            setInterval(reloadData, 20000);
            
            $(document).ready(function () {
                
            });
            
            function reloadData() {
                var type = $("#type").val();
                $.ajax({
                    url: "index.php?action=ajax_sms_chem", 
                    method: "POST",
                    data: {type:type},
                    success: function(result){
                        var obj = $.parseJSON(result);
                        
                        if(obj.length > 0) {
                            var header = obj.header;
                            $("#val_type").html(header.TYPE);
                            $("#val_heat").html(header.VCHEAT);
                            $("#val_sample_no").html(header.SAMPLE_NO);
                            $("#val_ltemp").html(header.LTEMP);
            
                            var content = obj.content;
                            
                            $("#val_fe").html(content.FE);
                            $("#val_c").html(content.C);
                            $("#val_mn").html(content.MN);
                            $("#val_p").html(content.P);
                            $("#val_s").html(content.S);
                            
                            $("#val_si").html(content.SI);
                            $("#val_sn").html(content.SN);
                            $("#val_al").html(content.AL);
                            $("#val_cr").html(content.CR);
                            $("#val_cu").html(content.CU);
                            
                            $("#val_ni").html(content.NI);
                            $("#val_v").html(content.V);
                            $("#val_mo").html(content.MO);
                            $("#val_nb").html(content.NB);
                            $("#val_ca").html(content.CA);
                            
                            $("#val_co").html(content.CO);
                            $("#val_ce").html(content.CE);
                            $("#val_ts").html(content.TS);
                            $("#val_ratio").html(content.RATIO);
                        }
                    }
              });
            }
        </script>
    </body>
</html>
