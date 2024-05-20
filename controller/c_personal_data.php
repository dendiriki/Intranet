<?php
if($action == 'personal_data') {
  if(isset($_GET["ajax_change_pass"])) {
    ajaxChangePass();
  } elseif(isset($_GET["ajax_change_ext"])) {
    ajaxChangeExt();
  }else {
    $data = array();
    $user = new User();
    $data["username"] = $username;
    $data["employee"] = $employee;
    $data["email"] = $employee->getMailById($username);
    $data["ext"] = $employee->getExtById($username);
    require( TEMPLATE_PATH . "/personal_data.php" );
  }  
}

function ajaxChangePass() {
  $data = array();
  global $username;
  $user = new User();
  $result = array();
  if (!empty($_POST["oldpass"]) && !empty($_POST["newpass1"]) && !empty($_POST["newpass2"])) {
    $oldpass = md5($_POST["oldpass"]);
    $newpass1 = md5($_POST["newpass1"]);
    $newpass2 = md5($_POST["newpass2"]);

    if ($newpass1 == $newpass2) {
      $checkUser = $user->getById($username);
      if ($checkUser->password == $oldpass) {
        $data["username"] = $username;
        $data["password"] = $newpass1;
        $data["reset"] = "0";
        $user->setParam($data);
        $changePassword = $user->update();
        if ($changePassword == true) {
          $result["status"] = "ok";
        }
      } else {
        $result["status"] = "fail";
        $result["msg"] = "Sorry, Old Password Fields did not match with our Data";
      }
    } else {
      $result["status"] = "fail";
      $result["msg"] = "Sorry, New Password Fields did not match";
    }
  } else {
    $result["status"] = "fail";
    $result["msg"] = "Please Fill All Fields";
  }
  echo json_encode($result);
}

function ajaxChangeExt() {
  $data = array();
  global $username;
  $employee = new Employee();
  $result = array();
  if(!empty($_POST["ext"])){
    if($employee->insertExt($username, $_POST["ext"])) {
      $result["status"] = "ok";
    } else {
      $result["status"] = "fail";
      $result["msg"] = "Sorry, update extension failed";
    }
  } else {
    $result["status"] = "fail";
    $result["msg"] = "Please Fill All Fields";
  }
  echo json_encode($result);
}

?>