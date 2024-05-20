<?php
if($action == "setPass") {
  $data = array();
  $user = new User();
  $data["employee"] = $employee;
  $data["action"] = "setPass";
  if (isset($_POST["submit"])) {
    $pass1 = $_POST["newpass1"];
    $pass2 = $_POST["newpass2"];
    if ($pass1 == $pass2) {
      $data["username"] = $username;
      $data["password"] = md5($pass1);
      $data["reset"] = "0";
      $user->setParam($data);
      $changePassword = $user->update();
      if ($changePassword == true) {
        $_SESSION['reset-by-admin'] = 0;
        header("Location: index.php");
      }
    } else {
      $data["error"] = "Password did not match";
      require( TEMPLATE_PATH . "/new_password.php" );
    }
  } else {
    require( TEMPLATE_PATH . "/new_password.php" );
  }
}
?>