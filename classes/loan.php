<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loan
 *
 * @author dheo
 */
class Loan {
  //put your code here
  function getLoanByPayroll($payroll, $company) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT a.vc_emp_code AS EMP#,a.vc_srl_no AS PERIODE,a.dt_loan_date AS TANGGAL,
            (select z.vc_earnded_desc from mst_earn_ded z where z.vc_comp_code = '01' and z.vc_earnded_code = a.vc_loan_code) AS URAIAN ,
            (case when a.vc_loan_code = 'E069' then a.nu_loan_amt + a.nu_interest_amt else a.nu_loan_amt end) as  DEBET, 0 AS KREDIT
            FROM emp_loan_details a
            WHERE a.vc_comp_code ='$company'
            AND a.vc_loan_code in ('E033','E065','E066','E067','E069')
            AND to_char(a.dt_loan_date,'yyyymmdd') <= to_char(sysdate,'yyyymmdd')
            AND  a.nu_loan_amt + a.nu_interest_amt > a.nu_paid_amt
            AND a.VC_EMP_CODE ='$payroll'
            and a.vc_srl_no like '%'
            and a.vc_loan_code like '%'
            UNION 
            SELECT a.vc_emp_code AS EMP#,a.vc_srl_no AS PERIODE,a.dt_pay_month AS TANGGAL, a.vc_remark  AS URAIAN,0 AS DEBET, a.nu_paid_amt AS KREDIT
            FROM loan_cop_trans_dt a
            WHERE a.vc_comp_code = '$company'
            AND a.vc_loan_code IN ('E033','E065','E066','E067','E069')
            AND a.VC_EMP_CODE = '$payroll'
            AND to_char(a.dt_pay_month,'yyyymmdd') <= to_char(sysdate,'yyyymmdd')
            and a.vc_srl_no like '%'
            and a.vc_loan_code like '%'
            and a.vc_emp_code||a.vc_srl_no in (
                SELECT b.vc_emp_code||b.vc_srl_no 
                FROM emp_loan_details b
                WHERE b.vc_comp_code = '01'
                AND b.vc_loan_code = a.vc_loan_code
            AND  nu_loan_amt + nu_interest_amt > nu_paid_amt
            )
            ORDER BY EMP#, PERIODE
            ";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $return = array();
    $data = array();
    while (($row = oci_fetch_assoc($st)) != false) {
      $data["key"] = $row["PERIODE"];
      $data['payroll'] = $row["EMP#"];
      $data['periode'] = substr($row["PERIODE"], 6, 2)."-".substr($row["PERIODE"], 4, 2)."-".substr($row["PERIODE"], 0, 4);
      $data['tanggal'] = $row["TANGGAL"];
      $data['remark'] = $row["URAIAN"];
      $data['debit'] = $row["DEBET"];
      $data['kredit'] = $row["KREDIT"];            
      $return[] = $data;      
    }
    
    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
}
