<?php
if($action == 'report_shoes') {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $data = array();
  $employ = new Employee();
  $data["username"] = $username;
  $data["employee"] = $employee;
  $data["shoes"] = $employ->getShoesAllowanceDetail($employee->company, $employee->payroll);
  require( TEMPLATE_PATH . "/shoes_view.php" );
}
?>