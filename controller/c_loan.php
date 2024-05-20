<?php

// put your code here

if($action == "view_loan") {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  
  $loan = Loan::getLoanByPayroll($employee->payroll, $employee->company);

  require( TEMPLATE_PATH . "/view_loan.php" );
}
?>