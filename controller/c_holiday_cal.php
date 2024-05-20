<?php

// put your code here
if($action == "holiday_cal") {
  if (isset($_POST["get_events"])) {
    $cal = new Callendar();
    echo json_encode($cal->getHolidayCallendar(date("Y")));
  } else {
    require( TEMPLATE_PATH . "/holiday_cal.php" );
  }
}

if($action == "manage_cal") {
  //to do next
}
?>