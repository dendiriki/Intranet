<?php

// put your code here
if($action == "conf_list") {
  $conf = new Conference();
  if (isset($_GET["room_id"])) {

    if (isset($_POST["save"])) {
      $room_id = $_POST["room_id"];
      $long_book = "N";
      if($_POST["long_book"] == "on") {
        $long_book = "Y";
      }
      
      $pickedDate = DateTime::createFromFormat('d M, Y', $_POST["date"]);
      $date = $pickedDate->format("d-m-Y");
      
      if(isset($_POST["date2"])){
        $pickedDate = DateTime::createFromFormat('d M, Y', $_POST["date2"]);
        $date2 = $pickedDate->format("d-m-Y");
      }
      
      $start = $_POST["start"];
      $end = $_POST["end"];
      $by = $_POST["by"];
      $dept = $_POST["dept"];
      $remark = $_POST["remark"];
      $ip = getUserIP();
      $check = $conf->checkBooking($room_id, $date, $date2, $start, $end, $long_book);
      if ($check == 0) {
        $conf->insertBooking($room_id, $date, $date2, $start, $end, $by, $dept, $remark, $ip, $long_book);
        $successMsg = "Your Booking was Saved";
      } else {
        $errorMsg = "This Conference Room is already booked at timespan";
      }
    }
    $room = $conf->getConferenceRoomById($_GET["room_id"]);
    $today = date("d-m-Y");
    $book_list = $conf->getConferenceBookingByDateAndRoom($today, $_GET["room_id"]);

    require( TEMPLATE_PATH . "/conference_detail.php" );
  } else {
    $room_list = $conf->getConferenceRoomList();
    require( TEMPLATE_PATH . "/conference_list.php" );
  }
}
?>