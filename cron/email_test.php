<?php
ini_set( "error_log" , "../log/php-error.log" );
define( "DB_DSN", "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.0.18)(PORT = 1521))(CONNECT_DATA = (SID = MAKESS20)))" );
define( "DB_USERNAME", "hrpay" );
define( "DB_PASSWORD", "hrpay" );

require "../classes/SendMail.php" ;
require '../classes/it_inquiry.php';
require '../classes/employee.php';
$recipient = "dheo.pratama@mittalsteel.com";

$sendMail = new SendMail();

//sendITTicketMailToUser($ticket_no, $subject, $priority, $status, $req_by_name, $recipient, $category)
if($sendMail->sendITTicketMailToUser(209, "Intranet Test, Abaikan", "H", "O", "Dheo", $recipient, "S")) {
  echo "Message Sent";
} else {
  echo $sendMail->errorMessage;
}
?>