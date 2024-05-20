<?php
if($action == "confirm_email") {
  confirmEmail();
}

if($action == "skip_email") {
  Employee::insertEmail($username,"-");
  header("Location: index.php");
}
?>