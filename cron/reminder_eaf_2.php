<?php

ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("error_log", "log/php-error.log");
ini_set("display_errors", true);

define("PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))"); //Local
define("DB_USERNAME", "hrpay");
define("DB_PASSWORD", "hrpay");

include "../classes/SendMail.php";
$conn = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
$date1 = date("Ymd") . "070000";
$date2 = date("Ymd") . "145959";
$sql = "select * from sapsr3.ZPP_SMS_EAF_DATA@dbsap_iip "
        . "where concat(erdat,erzet) between '" . $date1 . "' and '" . $date2 . "' "
        . "order by erdat asc, TO_NUMBER(srlno) asc";

$stmt = $conn->prepare($sql);

$data = array();
if ($stmt->execute() or die($stmt->errorInfo()[2])) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
}
$email_msg = "<html>";
if (!empty($data)) {
    $email_msg .= "<p>EAF Data</p>";
    $email_msg .= "<table border='1'>";
    //echo "<table border='2'>";
    $email_msg .= "<tr>"
            . "<th>Order No</th>"
            . "<th>Heat No</th>"
            . "<th>Date</th>"
            . "<th>Time</th>"
            . "<th>Serial No</th>"
            . "<th>DRI</th>"
            . "<th>Dolomite</th>"
            . "<th>Lime</th>"
            . "<th>Carbon</th>"
            . "<th>Gas EAF</th>"
            . "<th>Oxygen</th>"
            . "<th>Arcing Time</th>"
            . "<th>Power Off</th>"
            . "<th>Tap to Tap time</th>"
            . "<th>EAF Power</th>"
            . "<th>Tapping Temperature</th>"
            . "<th>Tapping Time</th>"
            . "<th>Lime</th>"
            . "<th>Amor Graph</th>"
            . "<th>Fe Si</th>"
            . "<th>Si Mn</th>"
            . "</tr>";
    foreach ($data as $row) {
        $erdat = substr($row["ERDAT"], 6, 2) . "." . substr($row["ERDAT"], 4, 2) . "." . substr($row["ERDAT"], 0, 4);
        $erzet = substr($row["ERZET"], 0, 2) . ":" . substr($row["ERZET"], 2, 2) . ":" . substr($row["ERZET"], 4, 2);
        $arctm = substr($row["ARCTM"], 0, 2) . ":" . substr($row["ARCTM"], 2, 2) . ":" . substr($row["ARCTM"], 4, 2);
        $pwoff = substr($row["PWOFF"], 0, 2) . ":" . substr($row["PWOFF"], 2, 2) . ":" . substr($row["PWOFF"], 4, 2);
        $t2ttm = substr($row["T2TTM"], 0, 2) . ":" . substr($row["T2TTM"], 2, 2) . ":" . substr($row["T2TTM"], 4, 2);
        $tpttm = substr($row["TPTTM"], 0, 2) . ":" . substr($row["TPTTM"], 2, 2) . ":" . substr($row["TPTTM"], 4, 2);
        $email_msg .= "<tr>"
                . "<td>" . $row["AUFNR"] . "</td>"
                . "<td>" . $row["ZHEAT"] . "</td>"
                . "<td>" . $erdat . "</td>"
                . "<td>" . $erzet . "</td>"
                . "<td>" . $row["SRLNO"] . "</td>"
                . "<td>" . $row["DRIHP"] . "</td>"
                . "<td>" . $row["DOLOM"] . "</td>"
                . "<td>" . $row["LIMEH"] . "</td>"
                . "<td>" . $row["CARBN"] . "</td>"
                . "<td>" . $row["GASEA"] . "</td>"
                . "<td>" . $row["OXYEA"] . "</td>"
                . "<td>" . $arctm . "</td>"
                . "<td>" . $pwoff . "</td>"
                . "<td>" . $t2ttm . "</td>"
                . "<td>" . $row["EAPWR"] . "</td>"
                . "<td>" . $row["TPTMP"] . "</td>"
                . "<td>" . $tpttm . "</td>"
                . "<td>" . $row["LIME"] . "</td>"
                . "<td>" . $row["AMOR_GRAPH"] . "</td>"
                . "<td>" . $row["FESI"] . "</td>"
                . "<td>" . $row["SIMN"] . "</td>"
                . "</tr>";
        //echo "<tr><td>".$row["VC_COMPANY_NAME"]."</td><td>".$row["VC_FIRST_NAME"]."</td><td>".$row["BIRTH_DATE"]."</td></tr>";
    }
    $email_msg .= "</table>";
    //echo "</table>";
} else {
    $email_msg = "<p>No EAF Data 07:00 to 15:00</p>";
}

$sql = "select * from sapsr3.ZPP_SMS_LRF_DATA@dbsap_iip "
        . "where concat(erdat,erzet) between '" . $date1 . "' and '" . $date2 . "' "
        . "order by erdat asc, TO_NUMBER(srlno) asc";

$stmt = $conn->prepare($sql);

$data = array();
if ($stmt->execute() or die($stmt->errorInfo()[2])) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
}
if (!empty($data)) {
    $email_msg .= "<BR><p>LRF Data</p>";
    $email_msg .= "<table border='1'>";
    //echo "<table border='2'>";
    $email_msg .= "<tr>"
            . "<th>Order No</th>"
            . "<th>Heat No</th>"
            . "<td>Date</td>"
            . "<td>Time</td>"
            . "<td>LRF Serial Number</td>"
            . "<td>Parking Time</td>"
            . "<td>LRF In Time</td>"
            . "<td>LRF Out Time</td>"
            . "<td>LRF Power(KWH)</td>"
            . "<td>LRF First Temp</td>"
            . "<td>LRF Last Temp</td>"
            . "<td>LRF Power 1st Temp</td>"
            . "<td>LimeRMH Hopper1(Kg)</td>"
            . "<td>AmGraph RMH Hopper4(Kg)</td>"
            . "<td>AmGraph RMH Hopper5(Kg)</td>"
            . "<td>SiMn RMH Hopper6(Kg)</td>"
            . "<td>SiMn RMH Hopper7(Kg)</td>"
            . "<td>FeSi RMH Hopper10(Kg)</td>"
            . "<td>RMH Man GB Sponge Iron</td>"
            . "<td>RMH Man Alu. Wire</td>"
            . "<td>RMH Man Amor Graph</td>"
            . "<td>RMH Man Borron</td>"
            . "<td>RMH Man Cal Carbide</td>"
            . "<td>RMH Man Carbon Riser</td>"
            . "<td>RMH Man Core Wire</td>"
            . "<td>RMH Man Dolomite</td>"
            . "<td>RMH Man Fe Chrome</td>"
            . "<td>RMH Man Fe Mn</td>"
            . "<td>RMH Man Fe Si</td>"
            . "<td>RMH Man Fe Titanium</td>"
            . "<td>RMH Man Fluorspar</td>"
            . "<td>RMH Man Lime</td>"
            . "<td>RMH Man Niobium</td>"
            . "<td>RMH Man Si Mn</td>"
            . "<td>RMH Man Vanadium</td>"
            . "</tr>";
    foreach ($data as $row) {
        $erdat = substr($row["ERDAT"], 6, 2) . "." . substr($row["ERDAT"], 4, 2) . "." . substr($row["ERDAT"], 0, 4);
        $erzet = substr($row["ERZET"], 0, 2) . ":" . substr($row["ERZET"], 2, 2) . ":" . substr($row["ERZET"], 4, 2);
        //$parking_time = substr($row["PARKING_TIME"], 0, 2) . ":" . substr($row["PARKING_TIME"], 2, 2) . ":" . substr($row["PARKING_TIME"], 4, 2);
        $lrf_in_time = substr($row["LRF_IN_TIME"], 0, 2) . ":" . substr($row["LRF_IN_TIME"], 2, 2) . ":" . substr($row["LRF_IN_TIME"], 4, 2);
        $lrf_out_time = substr($row["LRF_OUT_TIME"], 0, 2) . ":" . substr($row["LRF_OUT_TIME"], 2, 2) . ":" . substr($row["LRF_OUT_TIME"], 4, 2);
        $email_msg .= "<tr>"
                . "<td>" . $row["AUFNR"] . "</td>"
                . "<td>" . $row["ZHEAT"] . "</td>"
                . "<td>" . $erdat . "</td>"
                . "<td>" . $erzet . "</td>"
                . "<td>" . $row["SRLNO"] . "</td>"
                . "<td>" . $row["PARKING_TIME"] . "</td>"
                . "<td>" . $lrf_in_time . "</td>"
                . "<td>" . $lrf_out_time . "</td>"
                . "<td>" . $row["LRF_POWER"] . "</td>"
                . "<td>" . $row["LRF_F_TEMP"] . "</td>"
                . "<td>" . $row["LRF_L_TEMP"] . "</td>"
                . "<td>" . $row["LRF_P_F_TEMP"] . "</td>"
                . "<td>" . $row["LIME_HOPPER"] . "</td>"
                . "<td>" . $row["AMGRAPH1"] . "</td>"
                . "<td>" . $row["AMGRAPH2"] . "</td>"
                . "<td>" . $row["SIMN_HOPPER6"] . "</td>"
                . "<td>" . $row["SIMN_HOPPER7"] . "</td>"
                . "<td>" . $row["FESI_HOPPER"] . "</td>"
                . "<td>" . $row["RMH_SPONGE"] . "</td>"
                . "<td>" . $row["RMH_ALU_WR"] . "</td>"
                . "<td>" . $row["RMH_AMOR_GRAPH"] . "</td>"
                . "<td>" . $row["RMH_BR"] . "</td>"
                . "<td>" . $row["RMH_CAL_CR"] . "</td>"
                . "<td>" . $row["RMH_C"] . "</td>"
                . "<td>" . $row["RMH_CORE_WR"] . "</td>"
                . "<td>" . $row["RMH_DOLOMITE"] . "</td>"
                . "<td>" . $row["RMH_FE_CR"] . "</td>"
                . "<td>" . $row["RMH_FE_MN"] . "</td>"
                . "<td>" . $row["RMH_FE_SI"] . "</td>"
                . "<td>" . $row["RMH_FE_TN"] . "</td>"
                . "<td>" . $row["RMH_FLUOR"] . "</td>"
                . "<td>" . $row["RMH_LIME"] . "</td>"
                . "<td>" . $row["RMH_NI"] . "</td>"
                . "<td>" . $row["RMH_SI_MN"] . "</td>"
                . "<td>" . $row["RMH_VN"] . "</td>"
                . "</tr>";
        //echo "<tr><td>".$row["VC_COMPANY_NAME"]."</td><td>".$row["VC_FIRST_NAME"]."</td><td>".$row["BIRTH_DATE"]."</td></tr>";
    }
    $email_msg .= "</table>";
    //echo "</table>";
} else {
    $email_msg .= "<p>No LRF Data 07:00 to 15:00</p>";
}

//select CCM data

$sql = "select * from sapsr3.ZPP_SMS_CCM_DATA@dbsap_iip "
        . "where concat(erdat,erzet) between '" . $date1 . "' and '" . $date2 . "' "
        . "order by erdat asc, TO_NUMBER(srlno) asc";

$stmt = $conn->prepare($sql);

$data = array();
if ($stmt->execute() or die($stmt->errorInfo()[2])) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
}

if (!empty($data)) {
    $email_msg .= "<p>CCM Data</p>";
    $email_msg .= "<table border='1'>";
    //echo "<table border='2'>";
    $email_msg .= "<tr>"
            . "<th>Order No</th>"
            . "<th>Heat No</th>"
            . "<th>Date</th>"
            . "<th>Time</th>"
            . "<th>Serial No</th>"
            . "<th>Casting Start Time</th>"
            . "<th>Casting End Time</th>"
            . "<th>CCM 1st Temp</th>"
            . "<th>CCM 2nd Temp</th>"
            . "<th>CCM 3rd Temp</th>"
            . "<th>CCM 4th Temp</th>"
            . "<th>CCM 5th Temp</th>"
            . "<th>Sequence No.</th>"
            . "</tr>";
    foreach ($data as $row) {
        $erdat = substr($row["ERDAT"], 6, 2) . "." . substr($row["ERDAT"], 4, 2) . "." . substr($row["ERDAT"], 0, 4);
        $erzet = substr($row["ERZET"], 0, 2) . ":" . substr($row["ERZET"], 2, 2) . ":" . substr($row["ERZET"], 4, 2);
        $cstim = substr($row["CAST_S_TIME"], 0, 2) . ":" . substr($row["CAST_S_TIME"], 2, 2) . ":" . substr($row["CAST_S_TIME"], 4, 2);
        $cetim = substr($row["CAST_E_TIME"], 0, 2) . ":" . substr($row["CAST_E_TIME"], 2, 2) . ":" . substr($row["CAST_E_TIME"], 4, 2);
        $email_msg .= "<tr>"
                . "<td>" . $row["AUFNR"] . "</td>"
                . "<td>" . $row["ZHEAT"] . "</td>"
                . "<td>" . $erdat . "</td>"
                . "<td>" . $erzet . "</td>"
                . "<td>" . $row["SRLNO"] . "</td>"
                . "<td>" . $cstim . "</td>"
                . "<td>" . $cetim . "</td>"
                . "<td>" . $row["CCM_1_TEMP"] . "</td>"
                . "<td>" . $row["CCM_2_TEMP"] . "</td>"
                . "<td>" . $row["CCM_3_TEMP"] . "</td>"
                . "<td>" . $row["CCM_4_TEMP"] . "</td>"
                . "<td>" . $row["CCM_5_TEMP"] . "</td>"
                . "<td>" . $row["SEQNO"] . "</td>"
                . "</tr>";
        //echo "<tr><td>".$row["VC_COMPANY_NAME"]."</td><td>".$row["VC_FIRST_NAME"]."</td><td>".$row["BIRTH_DATE"]."</td></tr>";
    }
    $email_msg .= "</table>";
    //echo "</table>";
} else {
    $email_msg .= "<p>No CCM Data 07:00 to 15:00</p>";
}

$email_msg .= "</html>";

$mail = new SendMail();

$recipient = array();
/* $recipient[0]["type"] = "ADD";
  $recipient[0]["email"] = "dheo.pratama@ispatindo.com"; */

$recipient[0]["type"] = "ADD";
$recipient[0]["email"] = "yoan.budiatmoko@mittalsteel.com";
$recipient[1]["type"] = "CC";
$recipient[1]["email"] = "saurabh.mishra@mittalsteel.com";
$recipient[2]["type"] = "CC";
$recipient[2]["email"] = "rakesh.singh@mittalsteel.com";
$recipient[3]["type"] = "CC";
$recipient[3]["email"] = "manish.jain@mittalsteel.com";
$recipient[4]["type"] = "BCC";
$recipient[4]["email"] = "hary.purwantoro@mittalsteel.com";
$recipient[5]["type"] = "BCC";
$recipient[5]["email"] = "vicky.ardiansyah@mittalsteel.com";

$mail->sendTheMailAdv("SMS Data 07:00 - 15:00", $email_msg, $recipient);

$myfile = fopen("reminder_eaf_2.txt", "w") or die("Unable to open file!");
$txt = "Job " . date("Y-m-d H:i:s") . " running \n";
fwrite($myfile, $txt);
fclose($myfile);
?>