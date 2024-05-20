<?php
if($action == 'annual_leave') {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $data = array();
  $leave = new Leave();
  $data["username"] = $username;
  $data["employee"] = $employee;
  $data["annual_leave"] = $leave->getLeave($employee->payroll,$employee->company);
  require( TEMPLATE_PATH . "/annual_leave.php" );
}

if($action == "annual_leave_appl") {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  
  if(isset($_GET["id"])) {
    $id = $_GET["id"];
    if(isset($_GET["save"])) {      
      $payroll = $_POST["payroll"];
      $designation = $_POST["designation"];
      $request_type = $_POST["request"];
      $from = $_POST["from"];
      $to = $_POST["to"];
      $encashment = $_POST["encashment"];
      
      var_dump( $_POST );
    } else {
      require( TEMPLATE_PATH . "/annual_leave_appl.php" );
    }    
  } else {
    $leave = new Leave();
    $data["leave"] = $leave->applicationList($employee->payroll,$employee->company);
    require( TEMPLATE_PATH . "/annual_leave_appl_list.php" );
  }  
}
?>