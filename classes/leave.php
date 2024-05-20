<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of leave
 *
 * @author dheo
 */
class Leave {

  //put your code here

  public function getLeave($payroll, $company) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $current_year = date("Y");
    $select_year = $current_year - 3;
    $sql = "SELECT vc_comp_code, vc_emp_code, dt_period_from, dt_period_to, 
                   dt_start_date, dt_end_date, nu_days, vc_remarks, vc_addsub_flag,
                   vc_approved_by 
            FROM emp_leave 
            WHERE vc_comp_code = '$company' 
            AND vc_emp_code = '$payroll' 
            AND vc_leave_code = 'L001'
            AND vc_cancel_flag = 'N' 
            AND to_char(dt_period_from, 'yyyymm') >= to_char(add_months(sysdate, -48), 'yyyymm')
            AND dt_period_from is not null
            AND to_char(dt_period_to, 'yyyymmdd') <= to_char(sysdate, 'yyyymmdd')
            AND (vc_approved_by is not null or upper(vc_create_machine) = 'GEN' or vc_addsub_flag in ('E', 'W'))
            AND nvl(vc_flag, '~') not in ('L', 'C', 'Y')
            ORDER BY dt_period_from ASC, dt_start_date ASC NULLS FIRST";
    $st = oci_parse($conn, $sql);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die (oci_error($conn)["message"]);
    $data = array(); $return = array();
    $i = 0;
    $balance = 0;
    while (($row = oci_fetch_assoc($st)) != false) {
      if($row["VC_ADDSUB_FLAG"] == "L" && empty($row["VC_APPROVED_BY"]) ) {
        continue;
      } else {
        $data[$i]["flag"] = $row["VC_ADDSUB_FLAG"];
        $data[$i]['payroll'] = $row["VC_EMP_CODE"];
        $data[$i]['period_from'] = $row["DT_PERIOD_FROM"];
        $data[$i]['period_to'] = $row["DT_PERIOD_TO"];
        $data[$i]['start_date'] = $row["DT_START_DATE"];
        $data[$i]['end_date'] = $row["DT_END_DATE"];
        $data[$i]['balance'] = $row["NU_DAYS"];
        $data[$i]['remarks'] = $row["VC_REMARKS"];
        $i++;
        if($row["VC_ADDSUB_FLAG"] == "A" || $row["VC_ADDSUB_FLAG"] == "W") {
          $balance += $row["NU_DAYS"];
        } else {
          $balance -= $row["NU_DAYS"];
        }
      } 
    } 
    $return["leave"] = $data;
    $return["balance"] = $balance;
    oci_free_statement($st);
    oci_close($conn);
    return $return;
  }
  
  public function applicationList($payroll, $company) {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_DSN) or die("Database Error");
    $sql = "SELECT * FROM INT_TRX_LEAVE_APPL where lv_emp_code = :payroll AND lv_comp_code = :company";
    $st = oci_parse($conn, $sql);
    oci_bind_by_name($st, ":payroll", $payroll, -1, SQLT_CHR);
    oci_bind_by_name($st, ":company", $company, -1, SQLT_CHR);
    if (!$st) {
      $e = oci_error($conn);  // For oci_parse errors pass the connection handle
      trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }
    oci_execute($st) or die(oci_error($conn)["message"]);
    $data = array();
    while(($row = oci_fetch_assoc($st)) != false) {
      $data = $row;
    }
    oci_free_statement($st);
    oci_close($conn);
    return $data;
  }
  public function applyAnnualLeave($payroll, $designation, $request_type, $from, $to, $duration, $encashment) {
    
  }
}
