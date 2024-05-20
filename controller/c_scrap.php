<?php
if($action == "scrap_inspection") {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $inspection = new Inspection();
  $data = array();
  if(isset($_GET["wsnum"])) {
    $wsnum = $_GET["wsnum"];
    if($wsnum == "0") {
      require( TEMPLATE_PATH . "/error.php" );
    } else {
			$get_inspection = $inspection->getById($wsnum);
			//var_dump($get_inspection);die();
			if($get_inspection["status"] == true) {
				$data["HDR"] = $get_inspection["HDR"];
				$data["ITM"] = $get_inspection["ITM"];
				$data["IMG"] = $get_inspection["IMG"];
				$data["DOC"] = $get_inspection["DOC"];
			}

			if(isset($_GET["print"])) {
				require( TEMPLATE_PATH . "/scrap_print.php" );
			} else {
				require( TEMPLATE_PATH . "/scrap_view.php" );
			}
    }
  } else {
    $limit = 10;
    $page = 1;
		
    if (isset($_GET["page"])) {
      $page = $_GET["page"];
    }
		
		$src_wsnum = "*";
		if(isset($_GET["src_wsnum"])) {
			if(!empty($_GET["src_wsnum"])) {
				$src_wsnum = $_GET["src_wsnum"];
			}
		}
    $data["username"] = $username;
    $data["employee"] = $employee;
    
    $get_inspection = $inspection->getList($limit,$page,$src_wsnum);
    $data["inspection"] = $get_inspection["data"];
    $data["total_page"] = $get_inspection["page"];
    require( TEMPLATE_PATH . "/scrap_list.php" );
  }
}

if($action == "scrap_inspection_edit") {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $inspection = new Inspection();
  $data = array();
  if(isset($_GET["wsnum"])) {
		
    $wsnum = $_GET["wsnum"];
    if($wsnum == "0") {
      require( TEMPLATE_PATH . "/error.php" );
    } else {
			if(isset($_POST["save"])) {
				$header = array();
				$header['SRLNO'] = str_pad($_POST['SRL_NO'], 10, '0', STR_PAD_LEFT);
				$header['WSNUM'] = $_POST['WSNUM'];
				$header['VEHICLE_NO'] = $_POST['VEHICLE_NO'];
				$header['WEIGHT_F'] = $_POST['WEIGHT_F'];
				$header['CONT_MRK'] = isset($_POST['CONT_MRK']) ? "X" : " ";
				$header['CONT_NO'] = !empty($_POST['CONT_NO']) ? $_POST['CONT_NO'] : " ";
				$header['CONT_SLD'] = isset($_POST['CONT_SLD']) ? "X" : " ";
				$header['SLD_DOC'] = !empty($_POST['SLD_DOC']) ? $_POST['SLD_DOC'] : " ";
				$header['CONT_FULL'] = isset($_POST['CONT_FULL']) ? "X" : " ";
				$header['CONT_WIDTH'] = !empty($_POST['CONT_WIDTH']) ? $_POST['CONT_WIDTH'] : 0;
				$header['CONT_HEIGHT'] = !empty($_POST['CONT_HEIGHT']) ? $_POST['CONT_HEIGHT'] : 0;
				$header['CONT_LENGTH'] = !empty($_POST['CONT_LENGTH']) ? $_POST['CONT_LENGTH'] : 0;
				$header['EIR_MRK'] = isset($_POST['EIR_MRK']) ? "X" : " ";
				$header['EIR_DOC'] = !empty($_POST['EIR_DOC']) ? $_POST['EIR_DOC'] : " ";
				$header['WEIGHT_E'] = $_POST['WEIGHT_E'];
				$header['DENS_E'] = !empty($_POST['DENS_E']) ? $_POST['DENS_E'] : 0;
				$header['NOTE'] = !empty($_POST['NOTE']) ? $_POST['NOTE'] : " ";
				$header['DED_IND'] = "P";
				if(isset($_POST['DED_IND'])) {
					$header['DED_IND'] = $_POST['DED_IND'];
				}
				$header['DED_KG'] = !empty($_POST['DED_KG']) ? $_POST['DED_KG'] : 0;
				$header['DED_PR'] = !empty($_POST['DED_PR']) ? $_POST['DED_PR'] : 0;
				$header['DED_RMK'] = !empty($_POST['DED_RMK']) ? $_POST['DED_RMK'] : " ";
				$header['REJ_MRK'] = isset($_POST['REJ_MRK']) ? "X" : " ";
				if(!empty($_POST['REJ_FULL'])) {
					//Full Reject
					$header['REJ_MRK'] = "F";
				}
				$header['REJ_RMK'] = !empty($_POST['REJ_RMK']) ? $_POST['REJ_RMK'] : " ";
				$header['ORIGIN'] = !empty($_POST['ORIGIN']) ? $_POST['ORIGIN'] : " ";
				$header['SHORT_SIZE_IND'] = isset($_POST['SHORT_SIZE_IND']) ? "X" : " ";
				$header['PREM_IND'] = isset($_POST['PREM_IND']) ? "X" : " ";
				$header['PENALTY'] = !empty($_POST['PENALTY']) ? $_POST['PENALTY'] : 0;
				$header['PENALTY_RMK'] = !empty($_POST['PENALTY_RMK']) ? $_POST['PENALTY_RMK'] : " ";
				$header['SUR_IND'] = isset($_POST['SUR_IND']) ? "X" : " ";
				$header['SUR_RMK'] = !empty($_POST['SUR_RMK']) ? $_POST['SUR_RMK'] : " ";
				$date = explode(".", $_POST['CRT_DT']);
				$header['CRT_DT'] = $date[2].$date[1].$date[0];
				$time = explode(":",$_POST['CRT_TM']);
				$header['CRT_TM'] = "00".$time[0].$time[1]."00";
				$header['CRT_BY'] = $_POST['CRT_BY'];
				$chg_usr = $_SESSION['intra-username'];
				$user = new User();
				$header["CHG_DT"] = date("Ymd");
				$header["CHG_TM"] = "00".date("Hi")."00";
				$header['CHG_BY'] = $user->getName($chg_usr);
				$header["DEVICE_ID"] = $_POST["DEVICE_ID"];
								
				$item = array();

				$item[0]["class"] = "Z001"; 
				$item[0]["short"] = $_POST['Z001A'] == "NaN" ? 0 : $_POST['Z001A']; 
				$item[0]["long"] =  0; 
				$item[0]["remark"] = !empty($_POST['Z001R']) ? $_POST['Z001R'] : " ";

				$item[1]["class"] = "Z002"; 
				$item[1]["short"] = $_POST['Z002A'] == "NaN" ? 0 : $_POST['Z002A']; 
				$item[1]["long"] =  0; 
				$item[1]["remark"] = !empty($_POST['Z002R']) ? $_POST['Z002R'] : " ";

				$item[2]["class"] = "Z003"; 
				$item[2]["short"] = $_POST['Z003A'] == "NaN" ? 0 : $_POST['Z003A']; 
				$item[2]["long"] = $_POST['Z003B'] == "NaN" ? 0 : $_POST['Z003B']; 
				$item[2]["remark"] = !empty($_POST['Z003R']) ? $_POST['Z003R'] : " ";

				$item[3]["class"] = "Z004"; 
				$item[3]["short"] = $_POST['Z004A'] == "NaN" ? 0 : $_POST['Z004A']; 
				$item[3]["long"] = $_POST['Z004B'] == "NaN" ? 0 : $_POST['Z004B']; 
				$item[3]["remark"] = !empty($_POST['Z004R']) ? $_POST['Z004R'] : " ";

				$item[4]["class"] = "Z005"; 
				$item[4]["short"] = $_POST['Z005A'] == "NaN" ? 0 : $_POST['Z005A']; 
				$item[4]["long"] = $_POST['Z005B'] == "NaN" ? 0 : $_POST['Z005B']; 
				$item[4]["remark"] = !empty($_POST['Z005R']) ? $_POST['Z005R'] : " ";

				$item[5]["class"] = "Z006"; 
				$item[5]["short"] = $_POST['Z006A'] == "NaN" ? 0 : $_POST['Z006A']; 
				$item[5]["long"] = $_POST['Z006B'] == "NaN" ? 0 : $_POST['Z006B']; 
				$item[5]["remark"] = !empty($_POST['Z006R']) ? $_POST['Z006R'] : " ";

				$item[6]["class"] = "Z007"; 
				$item[6]["short"] = $_POST['Z007A'] == "NaN" ? 0 : $_POST['Z007A']; 
				$item[6]["long"] =  0; 
				$item[6]["remark"] = !empty($_POST['Z007R']) ? $_POST['Z007R'] : " ";

				$item[7]["class"] = "Z008"; 
				$item[7]["short"] = $_POST['Z008A'] == "NaN" ? 0 : $_POST['Z008A']; 
				$item[7]["long"] =  0; 
				$item[7]["remark"] = !empty($_POST['Z008R']) ? $_POST['Z008R'] : " ";

				$item[8]["class"] = "Z009"; 
				$item[8]["short"] = $_POST['Z009A'] == "NaN" ? 0 : $_POST['Z009A']; 
				$item[8]["long"] = $_POST['Z009B'] == "NaN" ? 0 : $_POST['Z009B']; 
				$item[8]["remark"] = !empty($_POST['Z009R']) ? $_POST['Z009R'] : " ";

				$item[9]["class"] = "Z010"; 
				$item[9]["short"] = $_POST['Z010A'] == "NaN" ? 0 : $_POST['Z010A']; 
				$item[9]["long"] = 0;
				$item[9]["remark"] = !empty($_POST['Z010R']) ? $_POST['Z010R'] : " ";

				$item[10]["class"] = "Z011"; 
				$item[10]["short"] = $_POST['Z011A'] == "NaN" ? 0 : $_POST['Z011A']; 
				$item[10]["long"] = 0;
				$item[10]["remark"] = !empty($_POST['Z011R']) ? $_POST['Z011R'] : " ";

				$item[11]["class"] = "Z012"; 
				$item[11]["short"] = $_POST['Z012A'] == "NaN" ? 0 : $_POST['Z012A']; 
				$item[11]["long"] = $_POST['Z012B'] == "NaN" ? 0 : $_POST['Z012B']; 
				$item[11]["remark"] = !empty($_POST['Z012R']) ? $_POST['Z012R'] : " ";

				$item[12]["class"] = "Z013"; 
				$item[12]["short"] = $_POST['Z013A'] == "NaN" ? 0 : $_POST['Z013A']; 
				$item[12]["long"] = $_POST['Z013B'] == "NaN" ? 0 : $_POST['Z013B']; 
				$item[12]["remark"] = !empty($_POST['Z013R']) ? $_POST['Z013R'] : " ";
				
				$save = array();				
				
				$save = $inspection->saveData($header, $item);
				
				if($save["status"] == true) {
					header("Location: index.php?action=$action&success=true&message=Inspection%20Updated");
				} else {
					header("Location: index.php?action=$action&wsnum=$wsnum&success=false&message=".$save["message"]);
				}
				//$result = $inspection->saveData($header, $item);
			} else {
				$get_inspection = $inspection->getById($wsnum);
				//var_dump($get_inspection);die();
				if($get_inspection["status"] == true) {
					$data["HDR"] = $get_inspection["HDR"];
					$data["ITM"] = $get_inspection["ITM"];
					$data["IMG"] = $get_inspection["IMG"];
					$data["DOC"] = $get_inspection["DOC"];
				}

				if(isset($_GET["print"])) {
					require( TEMPLATE_PATH . "/scrap_print.php" );
				} else {
					require( TEMPLATE_PATH . "/scrap_edit.php" );
				}
			}
    }
  } else {
    $limit = 10;
    $page = 1;
    if (isset($_GET["page"])) {
      $page = $_GET["page"];
    }
		
		$src_wsnum = "*";
		if(isset($_GET["src_wsnum"])) {
			if(!empty($_GET["src_wsnum"])) {
				$src_wsnum = $_GET["src_wsnum"];
			}
		}
		
    $data["username"] = $username;
    $data["employee"] = $employee;
    
    $get_inspection = $inspection->getList($limit,$page,$src_wsnum);
    $data["inspection"] = $get_inspection["data"];
    $data["total_page"] = $get_inspection["page"];
    require( TEMPLATE_PATH . "/scrap_list.php" );
  }
}
?>