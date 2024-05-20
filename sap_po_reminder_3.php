<?php
ini_set( "error_reporting" , E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED );
ini_set( "error_log" , "log/php-error.log" );
ini_set( "display_errors", true );

define( "PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" ); //Local
define( "DB_USERNAME", "production" );
define( "DB_PASSWORD", "production" );

include "classes/SendMail.php";
$mail = new SendMail();
$conn = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);

$sql = " select a.ebeln,
           d.lifnr,
           d.name1,
           d.adrnr,
           a.ekgrp,
           to_char(to_date(a.bedat, 'YYYYMMDD'), 'DD/MM/YYYY') as po_date
      FROM sapsr3.ekko@dbsap_iip a,
           sapsr3.ekpo@dbsap_iip b,
           sapsr3.mara@dbsap_iip c,
           sapsr3.lfa1@dbsap_iip d,
           sapsr3.eket@dbsap_iip e
     where a.mandt = b.mandt
       and a.mandt = c.mandt
       and a.mandt = d.mandt
       and a.ebeln = b.ebeln
       and b.matnr = c.matnr
       and a.lifnr = d.lifnr
       and a.mandt = e.mandt
       and b.ebeln = e.ebeln
       and b.ebelp = e.ebelp
       and a.mandt = '600'
       AND a.BSTYP = 'F'
       and a.bukrs = 'INDO'
       and a.loekz = ' '
       and a.bsart in ('DGP', 'DJW', 'DMP', 'IGP', 'IJW', 'IMP', 'ZCAP')
       and a.zzporeldate is not null
       and a.BEDAT between '20210901' and '99999999'
       and b.loekz = ' '
       and e.wemng <= 0
       and e.etenr = '0001'
       and to_date(e.eindt, 'YYYYMMDD') - TRUNC(sysdate) = 3
       and b.elikz = ' '
       and a.frgke in ('G','R')
       and a.ebeln || b.ebelp NOT in
           (select ebeln || ebelp from sapsr3.ZMM_PO_EXC@dbsap_iip)
     group by a.ebeln,
              d.lifnr,
              d.name1,
              d.adrnr,
              a.ekgrp,
              to_char(to_date(a.bedat, 'YYYYMMDD'), 'DD/MM/YYYY')
     order by 1 asc";
$stmt = $conn->prepare($sql);
$data1 = array();
if($stmt->execute() or die($stmt->errorInfo()[2])){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data1[] = $row;
    }
}


if(!empty($data1)){
    foreach ($data1 as $val) {
        $ebeln = $val["EBELN"];
        $adrnr = $val["ADRNR"];
        $ekgrp = $val["EKGRP"];
        $sql = "select a.ebeln,
                 b.ebelp,
                 b.matnr,
                 b.TXZ01,
                 to_char(to_date(e.eindt, 'YYYYMMDD'), 'DD/MM/YYYY') as eindt,
                 b.menge,
                 b.meins,
                 d.lifnr,
                 d.name1,
                 to_char(to_date(a.bedat, 'YYYYMMDD'), 'DD/MM/YYYY') as po_date
            FROM sapsr3.ekko@dbsap_iip a,
                 sapsr3.ekpo@dbsap_iip b,
                 sapsr3.mara@dbsap_iip c,
                 sapsr3.lfa1@dbsap_iip d,
                 sapsr3.eket@dbsap_iip e
           where a.mandt = b.mandt
             and a.mandt = c.mandt
             and a.mandt = d.mandt
             and a.ebeln = b.ebeln
             and b.matnr = c.matnr
             and a.lifnr = d.lifnr
             and a.mandt = e.mandt
             and b.ebeln = e.ebeln
             and b.ebelp = e.ebelp
             and a.mandt = '600'
             AND a.BSTYP = 'F'
             and a.bukrs = 'INDO'
             and a.loekz = ' '
             and a.bsart in
                 ('DGP', 'DJW', 'DMP', 'IGP', 'IJW', 'IMP', 'ZCAP')
             and a.zzporeldate is not null
             and a.BEDAT between '20210901' and '99999999'
             and b.loekz = ' '
             and e.wemng <= 0
             and e.etenr = '0001'
             and to_date(e.eindt, 'YYYYMMDD') - TRUNC(sysdate) = 3
             and a.ebeln || b.ebelp NOT in
                 (select ebeln || ebelp from sapsr3.ZMM_PO_EXC@dbsap_iip)
             and a.ebeln = '$ebeln'
           order by 1, 2 asc";
        $stmt = $conn->prepare($sql);
        $data2 = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data2[] = $row;
            }
        }
    
    $sql = "SELECT max(SMTP_ADDR)as cust
            FROM SAPSR3.ADR6@DBSAP_IIP
            WHERE CLIENT = '600'
            AND ADDRNUMBER = '$adrnr'
            and PERSNUMBER = ' '";
    $stmt = $conn->prepare($sql);
    $data3 = array();
    if($stmt->execute() or die($stmt->errorInfo()[2])){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data3[] = $row["CUST"];
        }
    }
    
    list($mail_cust) = $data3;
    
    $sql = "SELECT max(SMTP_ADDR) as PURC
            FROM sapsr3.t024@dbsap_iip
            WHERE mandt = '600'
            and ekgrp = '$ekgrp'";
    $stmt = $conn->prepare($sql);
    $data4 = array();
    if($stmt->execute() or die($stmt->errorInfo()[2])){
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data4[] = $row["PURC"];
        }
    }
    
    if($mail_cust <> ''){
                $sql = "SELECT mailid
                FROM ZSAP_MAIL_ID
                WHERE TCODE = 'PO_CC'
                AND STS IN ('1','2')";
        $stmt = $conn->prepare($sql);
        $cc = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $cc[] = $row["MAILID"];
            }
        }
        
        $sql = "SELECT mailid
                FROM ZSAP_MAIL_ID
                WHERE TCODE = 'PO_CC'
                AND STS = '3'";
        $stmt = $conn->prepare($sql);
        $bcc = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $bcc[] = $row["MAILID"];
            }
        }
        
        $recipient = array();
        $rc = 0;
        if(!empty($data3)){
            foreach($data3 as $row){
                $recipient[$rc]["type"] = "ADD";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($cc)){
            foreach($cc as $row){
                $recipient[$rc]["type"] = "CC";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($data4)){
            foreach($data4 as $row){
                $recipient[$rc]["type"] = "CC";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($bcc)){
            foreach($bcc as $row){
                $recipient[$rc]["type"] = "BCC";
                $recipient[$rc]["email"] = $row;
                echo $row;
                $rc++;
            }
        }
        
        
    } else {

        $sql = "SELECT mailid
                FROM ZSAP_MAIL_ID
                WHERE TCODE = 'PO_DEF'
                AND STS = '1'";
        $stmt = $conn->prepare($sql);
        $add = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $add[] = $row["MAILID"];
            }
        }
        
        $sql = "SELECT mailid
                FROM ZSAP_MAIL_ID
                WHERE TCODE = 'PO_DEF'
                AND STS = '2'";
        $stmt = $conn->prepare($sql);
        $cc = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $cc[] = $row["MAILID"];
            }
        }
        
        $sql = "SELECT mailid
                FROM ZSAP_MAIL_ID
                WHERE TCODE = 'PO_DEF'
                AND STS = '3'";
        $stmt = $conn->prepare($sql);
        $bcc = array();
        if($stmt->execute() or die($stmt->errorInfo()[2])){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $bcc[] = $row["MAILID"];
            }
        }
        
        $recipient = array();
        $rc = 0;
        if(!empty($add)){
            foreach ($add as $row){
                $recipient[$rc]["type"] = "ADD";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($cc)){
            foreach($cc as $row){
                $recipient[$rc]["type"] = "CC";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($data4)){
            foreach($data4 as $row){
                $recipient[$rc]["type"] = "CC";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        if(!empty($bcc)){
            foreach($bcc as $row){
                $recipient[$rc]["type"] = "BCC";
                $recipient[$rc]["email"] = $row;
                $rc++;
            }
        }
        
    }
        $email_msg1 .= "Dear Sir/Madam, <br><br>";
	$email_msg1 .= "Please see the delivery date for the below mentioned orders are getting due within 3 days.<br><br>";
	$email_msg1 .= "Kindly take necessary action from your end.<br><br>";
	$email_msg1 .= "<table>";
	$email_msg1 .= "<tr><td>Purchase Order No.</td><td>:</td><td>".$val["EBELN"]."</td></tr>";
	$email_msg1 .= "<tr><td>Purchase Order Date</td><td>:</td><td>".$val["PO_DATE"]."</td></tr>";
	$email_msg1 .= "<tr><td>Vendor Code</td><td>:</td><td>".$val["LIFNR"]."</td></tr>";
	$email_msg1 .= "<tr><td>Vendor Name</td><td>:</td><td>".$val["NAME1"]."</td></tr>";
	$email_msg1 .= "</table><br>";
        $email_msg1 .= "PURCHASE ORDER DETAILS.<br>";
        
        $vebeln = 'XXX';
        $c = 1;
        if ($vebeln <> $ebeln){
            if ($vebeln <> 'XXX'):
                        
            endif;
        foreach($data2 as $val2){
        $email_msg2 .= "<table>";
        $email_msg2 .= "<tr><td>$c.</td><td>PO Item</td><td>:</td><td>".$val2["EBELP"]."</td></tr>";
        $email_msg2 .= "<tr><td></td><td>Item Code</td><td>:</td><td>".$val2["MATNR"]."</td></tr>";
        $email_msg2 .= "<tr><td></td><td>Item Description</td><td>:</td><td>".$val2["TXZ01"]."</td></tr>";
        $email_msg2 .= "<tr><td></td><td>Unit</td><td>:</td><td>".$val2["MEINS"]."</td></tr>";
        $email_msg2 .= "<tr><td></td><td>Quantity</td><td>:</td><td>".$val2["MENGE"]."</td></tr>";
        $email_msg2 .= "<tr><td></td><td>Promised Date</td><td>:</td><td>".$val2["EINDT"]."</td></tr>";
        $email_msg2 .= "</table><br>";
        $c++;
        $vebeln = $ebeln;
        }
        
        }

        $email_msg3 .= $email_msg1. '<br>' .$email_msg2;
        $email_msg4 .= "Note: This is system generated reminder email,<br>";
        $email_msg4 .= "Please  ignore if you have already dispatched the material.(You can share the dispatch details).<br>";
        $email_msg4 .= "LD shall be applicable as per the terms of the order for overdue delivery item.";
        
        $email_msg .= $email_msg3. '<br>' .$email_msg4;
        
        $mail->sendTheMailPU("PO Delivery Reminder II", $email_msg, $recipient);
        $email_msg1 = $email_msg2 = $email_msg3 = $email_msg4 = $email_msg = '';
        }
    
}

echo $email_msg."<BR>";
$mail = new SendMail();

?>