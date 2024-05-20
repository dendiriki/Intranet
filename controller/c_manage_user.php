<?php

// put your code here
if($action == "manage_user") {
  $data = array();
  if (isset($_GET["userId"])) {
    if (isset($_GET["addRole"])) {
      $user_id = $_GET["userId"];
      $role_id = $_GET["roleId"];
      $user = new User();
      $result = $user->addUserRole($user_id, $role_id);
      if ($result["status"] == "ok") {
        $data["success"] = $result["msg"];
      } else {
        $data["error"] = $result["msg"];
      }
      $data["action"] = "Edit User";
      $data["user"] = User::getNameById($_GET["userId"]);
      $data["role"] = User::getUserRole($_GET["userId"]);
      $data["role_list"] = Role::getList();
      require( TEMPLATE_PATH . "/edit_user.php" );
    } elseif (isset($_GET["deleteRole"])) {
      $user_id = $_GET["userId"];
      $role_id = $_GET["roleId"];
      $user = new User();
      $result = $user->deleteUserRole($user_id, $role_id);
      if ($result == true) {
        $data["success"] = "User Role Deleted";
      } else {
        $data["error"] = "Failed to delete User Role";
      }
      $data["action"] = "Edit User";
      $data["user"] = User::getNameById($_GET["userId"]);
      $data["role"] = User::getUserRole($_GET["userId"]);
      $data["role_list"] = Role::getList();
      require( TEMPLATE_PATH . "/edit_user.php" );
    } else {
      if(isset($_POST["save"])) {
        //save or update data
        $user = new User();
        $param["username"] = $_POST["username"];
        $bday = Employee::getBirthDateByEmpNo($_POST["company"],$_POST["payroll"]);
        if(!empty($bday)) {
          $param["password"] = md5($bday.$_POST["payroll"]);
        } else {
          $param["password"] = md5("welcome");
        }        
        $param["company"] = $_POST["company"];
        if($param["company"] == null) $param["company"] = "";
        $param["payroll"] = $_POST["payroll"];
        $param["name"] = strtoupper($_POST["name"]);
        if(empty($param["payroll"])) {
          $param["type"] = "EX";
        } else {
          $param["type"] = "LC";
        }
        $cek_user = $user->isExist($param["username"], $param["payroll"], $param["company"]);   
        if(!empty($cek_user)) {
          $error = "User%20already%20exist";
          header("Location: index.php?action=manage_user&userId=".$cek_user."&error=".$error);
        } else {
          $user->setParam($param);
          if($user->insert()) {
            $success = "User%20Saved";
            header("Location: index.php?action=manage_user&success=".$success);
          }          
        }
      } else {
        if ($_GET["userId"] == "0") {
          if (isset($_GET["error"]))
            $data["error"] = $_GET["error"];
          $data["action"] = "New User";
        } else {
          if (isset($_GET["error"]))
            $data["error"] = $_GET["error"];
          $data["action"] = "Edit User";
          $data["user"] = User::getNameById($_GET["userId"]);
          $data["role"] = User::getUserRole($_GET["userId"]);
          $data["role_list"] = Role::getList();
        }
        require( TEMPLATE_PATH . "/edit_user.php" );
      }
    }
  } elseif(isset($_GET["ajax_reset_pass"])){
    ajaxResetPass();
  } elseif(isset($_GET["ajax_get_name"])){
    ajaxGetName();
  } else {
    if (isset($_GET["success"]))
      $data["success"] = "User saved";
    $user_list = User::getList();
    require( TEMPLATE_PATH . "/manage_user.php" );
  }
}

function ajaxResetPass() {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $result = array();
  if (!empty($username) && !empty($password)) {
    $user = new User();
    $data["username"] = $username;
    $data["password"] = md5($password);
    $data["reset"] = "1";
    $user->setParam($data);
    $changePassword = $user->update();
    if ($changePassword == true) {
      $result["status"] = "ok";
    }
  } else {
    $result["status"] = "fail";
    $result["msg"] = "Please Fill All Fields";
  }
  echo json_encode($result);
}

function ajaxGetName() {
  $emp_no = $_POST["emp_no"];
  $comp_no = $_POST["comp_no"];
  $result = array();
  if(!empty($emp_no)) {
    $employee = new Employee();
    $name = $employee->getNameByEmpNo($comp_no, $emp_no);
    if(!empty($name)) {
      $result["status"] = "ok";
      $result["name"] = $name;
    } else {
      $result["status"] = "fail";
      $result["msg"] = "Employee Does Not Exist";
    }
  } else {
    $result["status"] = "fail";
    $result["msg"] = "Please Fill All Fields";
  }
  echo json_encode($result);
}
?>