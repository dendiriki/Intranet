<?php

if ($action == "sms_chem") {
    set_time_limit(0);
    define("PDO_MAKESS20", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))");
    $type = 'EAF';
    if (isset($_REQUEST["type"])) {
        $type = $_REQUEST["type"];
    }
    $conn = new PDO(PDO_MAKESS20, "production", "production");
    /* $sql_header = "select vc_heat_no vcheat,vc_sequence_no vcseq,nu_type_srl_no nusrl,vc_sample_no sample_no 
      from prod_chem_dt_sap
      where vc_comp_code ='01'
      and vc_type =  '$type'
      and   nu_synch_no = (select max(nu_synch_no) from  prod_chem_dt_sap where vc_type = '$type'
      and vc_disp_flag ='Y' ) "; */
    $sql_header = "select /*+ INDEX(prod_chem_dt_sap CHEM_SYNC) */
                   vc_heat_no vcheat,vc_sequence_no vcseq,nu_type_srl_no nusrl,vc_sample_no sample_no, nu_synch_no 
                                     from prod_chem_dt_sap 
                                     where vc_comp_code ='01' 
                                     and vc_type =  '$type'
                                     and to_char(dt_created_date,'YYYY-MM-DD') = '" . date("Y-m-d") . "'
                                     and vc_disp_flag ='Y'
                                     order by nu_synch_no desc";
    $stmt = $conn->prepare($sql_header) or die("Error Header: " . $conn->errorInfo()[2]);
    $data_header = array();
    if ($stmt->execute() or die("Error Header: " . $stmt->errorInfo()[2])) {
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_header = $row;
        }
    }

    $sql_content = "select sum(decode(x.vc_element,'FE',nu_ele_qty,0))as FE,
									sum(decode(x.vc_element,'C',nu_ele_qty,0))as C,
									sum(decode(x.vc_element,'Mn',nu_ele_qty,0))as Mn,
									sum(decode(x.vc_element,'P',nu_ele_qty,0))as P,
									sum(decode(x.vc_element,'S',nu_ele_qty,0))as S,
									sum(decode(x.vc_element,'Si',nu_ele_qty,0))as Si,
									sum(decode(x.vc_element,'Sn',nu_ele_qty,0))as Sn,
									sum(decode(x.vc_element,'Al',nu_ele_qty,0))as Al,
									sum(decode(x.vc_element,'Cr',nu_ele_qty,0))as Cr,
									sum(decode(x.vc_element,'Cu',nu_ele_qty,0))as Cu,
									sum(decode(x.vc_element,'Ni',nu_ele_qty,0))as Ni,
									sum(decode(x.vc_element,'V',nu_ele_qty,0))as V,
									sum(decode(x.vc_element,'Mo',nu_ele_qty,0))as Mo,
									sum(decode(x.vc_element,'Nb',nu_ele_qty,0))as Nb,
									sum(decode(x.vc_element,'Ca',nu_ele_qty,0))as Ca,
									sum(decode(x.vc_element,'Co',nu_ele_qty,0))as Co,
									sum(decode(x.vc_element,'CE',nu_ele_qty,0))as CE,
									sum(decode(x.vc_element,'TS',nu_ele_qty,0))as TS,
									sum(decode(x.vc_element,'W',nu_ele_qty,0))as W,
									sum(decode(x.vc_element,'Ti',nu_ele_qty,0))as Ti,
									sum(decode(x.vc_element,'B',nu_ele_qty,0))as B,
									sum(decode(x.vc_element,'As',nu_ele_qty,0))as As_,
									sum(decode(x.vc_element,'RATIO',nu_ele_qty,0))as RATIO 
									FROM(
									select vc_element,nu_ele_qty 
									from  prod_chem_dt_sap 
									where vc_type =  '$type' 
												and   vc_heat_no = '" . $data_header["VCHEAT"] . "' 
												and   vc_sequence_no = '" . $data_header["VCSEQ"] . "' 
												and    ltrim(rtrim(vc_sample_no)) = ltrim(rtrim('" . $data_header["SAMPLE_NO"] . "')) 
												and   nu_type_srl_no = '" . $data_header["NUSRL"] . "') x";
    $stmt = $conn->prepare($sql_content) or die("Error Content: " . $conn->errorInfo()[2]);
    $data_content = array();
    if ($stmt->execute() or die("Error Content: " . $stmt->errorInfo()[2])) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_content = $row;
        }
    }
    $CP = 0;
    $CP += $data_content["C"] + (0.02 * $data_content["MN"]) + (0.04 * $data_content["NI"]) + (0.1 * $data_content["SI"]) + (0.04 * $data_content["CR"]) + (0.1 * $data_content["MO"]) + (0.7 * $data_content["S"]);

    $ALLOY = 0;
    $ALLOY += (5 * $data_content["MN"]) + (8 * $data_content["SI"]) + (34 * $data_content["P"]) + (40 * $data_content["S"]) + (1.9 * $data_content["CR"]) + (2 * $data_content["MO"]) + (4 * $data_content["NI"]) + (3 * $data_content["CU"]) + (3 * $data_content["AL"]) +
            (1 * $data_content["W"]) + (2 * $data_content["V"]) + (7 * $data_content["NB"]) + (17 * $data_content["TI"]) + (60 * $data_content["B"]) + (10 * $data_content["SN"]) + (14 * $data_content["AS_"]);

    if ($CP < 0.5) {
        $lTemp = floor(1534 - (90.4 * $data_content["C"]) - $ALLOY);
    } else {
        $lTemp = floor(1521 - (65 * $data_content["C"]) - $ALLOY);
    }

    $stmt = null;
    $conn = null;
    require( TEMPLATE_PATH . "/t_sms_chem.php" );
}

if ($action == "ajax_sms_chem") {
    set_time_limit(0);
    define("PDO_MAKESS20", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))");
    $type = 'EAF';
    if (isset($_REQUEST["type"])) {
        $type = $_REQUEST["type"];
    }
    $conn = new PDO(PDO_MAKESS20, "production", "production");
    /*$sql_header = "select vc_heat_no vcheat,vc_sequence_no vcseq,nu_type_srl_no nusrl,vc_sample_no sample_no 
								 from prod_chem_dt_sap 
								 where vc_comp_code ='01' 
								 and vc_type =  '$type' 
								 and   nu_synch_no = (select max(nu_synch_no) from  prod_chem_dt_sap where vc_type = '$type' 
								 and vc_disp_flag ='Y' )";*/
    $sql_header = "select /*+ INDEX(prod_chem_dt_sap CHEM_SYNC) */ 
                   vc_heat_no vcheat,vc_sequence_no vcseq,nu_type_srl_no nusrl,vc_sample_no sample_no, nu_synch_no 
                                     from prod_chem_dt_sap 
                                     where vc_comp_code ='01' 
                                     and vc_type =  'EAF'
                                     and to_char(dt_created_date,'YYYY-MM-DD') = '" . date("Y-m-d") . "'
                                     and vc_disp_flag ='Y'
                                     order by nu_synch_no desc";
    $stmt = $conn->prepare($sql_header) or die("Error Header: " . $conn->errorInfo()[2]);
    $data_header = array();
    if ($stmt->execute() or die("Error Header: " . $stmt->errorInfo()[2])) {
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_header = $row;
        }
    }

    $sql_content = "select sum(decode(x.vc_element,'FE',nu_ele_qty,0))as FE,
									sum(decode(x.vc_element,'C',nu_ele_qty,0))as C,
									sum(decode(x.vc_element,'Mn',nu_ele_qty,0))as Mn,
									sum(decode(x.vc_element,'P',nu_ele_qty,0))as P,
									sum(decode(x.vc_element,'S',nu_ele_qty,0))as S,
									sum(decode(x.vc_element,'Si',nu_ele_qty,0))as Si,
									sum(decode(x.vc_element,'Sn',nu_ele_qty,0))as Sn,
									sum(decode(x.vc_element,'Al',nu_ele_qty,0))as Al,
									sum(decode(x.vc_element,'Cr',nu_ele_qty,0))as Cr,
									sum(decode(x.vc_element,'Cu',nu_ele_qty,0))as Cu,
									sum(decode(x.vc_element,'Ni',nu_ele_qty,0))as Ni,
									sum(decode(x.vc_element,'V',nu_ele_qty,0))as V,
									sum(decode(x.vc_element,'Mo',nu_ele_qty,0))as Mo,
									sum(decode(x.vc_element,'Nb',nu_ele_qty,0))as Nb,
									sum(decode(x.vc_element,'Ca',nu_ele_qty,0))as Ca,
									sum(decode(x.vc_element,'Co',nu_ele_qty,0))as Co,
									sum(decode(x.vc_element,'CE',nu_ele_qty,0))as CE,
									sum(decode(x.vc_element,'TS',nu_ele_qty,0))as TS,
									sum(decode(x.vc_element,'W',nu_ele_qty,0))as W,
									sum(decode(x.vc_element,'Ti',nu_ele_qty,0))as Ti,
									sum(decode(x.vc_element,'B',nu_ele_qty,0))as B,
									sum(decode(x.vc_element,'As',nu_ele_qty,0))as As_,
									sum(decode(x.vc_element,'RATIO',nu_ele_qty,0))as RATIO 
									FROM(
									select vc_element,nu_ele_qty 
									from  prod_chem_dt_sap 
									where vc_type =  '$type' 
												and   vc_heat_no = '" . $data_header["VCHEAT"] . "' 
												and   vc_sequence_no = '" . $data_header["VCSEQ"] . "' 
												and    ltrim(rtrim(vc_sample_no)) = ltrim(rtrim('" . $data_header["SAMPLE_NO"] . "')) 
												and   nu_type_srl_no = '" . $data_header["NUSRL"] . "') x";
    $stmt = $conn->prepare($sql_content) or die("Error Content: " . $conn->errorInfo()[2]);
    $data_content = array();
    if ($stmt->execute() or die("Error Content: " . $stmt->errorInfo()[2])) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_content = $row;
        }
    }
    $CP = 0;
    $CP += $data_content["C"] + (0.02 * $data_content["MN"]) + (0.04 * $data_content["NI"]) + (0.1 * $data_content["SI"]) + (0.04 * $data_content["CR"]) + (0.1 * $data_content["MO"]) + (0.7 * $data_content["S"]);

    $ALLOY = 0;
    $ALLOY += (5 * $data_content["MN"]) + (8 * $data_content["SI"]) + (34 * $data_content["P"]) + (40 * $data_content["S"]) + (1.9 * $data_content["CR"]) + (2 * $data_content["MO"]) + (4 * $data_content["NI"]) + (3 * $data_content["CU"]) + (3 * $data_content["AL"]) +
            (1 * $data_content["W"]) + (2 * $data_content["V"]) + (7 * $data_content["NB"]) + (17 * $data_content["TI"]) + (60 * $data_content["B"]) + (10 * $data_content["SN"]) + (14 * $data_content["AS_"]);

    if ($CP < 0.5) {
        $lTemp = floor(1534 - (90.4 * $data_content["C"]) - $ALLOY);
    } else {
        $lTemp = floor(1521 - (65 * $data_content["C"]) - $ALLOY);
    }
    $data_header["TYPE"] = $type;
    $data_header["LTEMP"] = $lTemp;

    $stmt = null;
    $conn = null;
    $data = array();
    $data["header"] = $data_header;
    $data["content"] = $data_content;
    echo json_encode($data);
}
?>