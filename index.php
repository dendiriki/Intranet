<?php
set_time_limit(0);
require( "config.php" );
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : "home";
$username = isset($_SESSION['intra-username']) ? $_SESSION['intra-username'] : null;
$reset_by_admin = isset($_SESSION['reset-by-admin']) ? $_SESSION['reset-by-admin'] : 0;
$employee = array();
$globalMenu = Menu::getGlobalMenu();
$menu = array();
$email = null;

if (!empty($username)) {
  $employee = Employee::getById($username);
  $menu = Menu::getByUser($username);
}

/*$auth_check = User::checkAuthorization($username, $action);
if($action == "login" || $action == "logout") {
  $auth_check = true;
}
if ($auth_check == false) {
  require( TEMPLATE_PATH . "/auth_error.php" );
  exit;
}*/

if ($reset_by_admin == 1 || $reset_by_admin == "1") {
  setNewPassword();
  exit;
}

//cek email
if (!empty($username)) {
  $mail = Employee::getMailById($username);
  if ($mail == null) {
    confirmEmail();
    exit;
  }
}

//populating controllers
foreach (glob("controller/*.php") as $filename) {
  include $filename;
}

function setNewPassword() {
  $data = array();
  global $globalMenu;
  global $username;
  global $employee;
  global $menu;
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

function confirmEmail() {
  $data = array();
  global $globalMenu;
  global $username;
  global $employee;
  global $menu;
  $data["action"] = "confirm_email";
  
  if(isset($_GET["skip"])) {
    Employee::insertEmail($username, "-");
    header("Location: index.php");
  }
  
  if (isset($_POST["submit"])) {
    $email1 = strtoupper($_POST["email1"]);
    $email2 = strtoupper($_POST["email2"]);
    if ($email1 == $email2) {
      Employee::insertEmail($username, $email2);
      if(isset($_GET["last_action"])) {
        header("Location: index.php?action=".$_GET["last_action"]);
      } else {
        header("Location: index.php");
      }
      
    } else {
      $data["error"] = "Email entered not match";
      $data["email1"] = $_POST["email1"];
      $data["email2"] = $_POST["email2"];
      if(isset($_POST["ext"])) {
        if(!empty($_POST["ext"])){
          $data["ext"] = $_POST["ext"];
        }     
      }
      require( TEMPLATE_PATH . "/confirm_email.php" );
    }
    
    if(isset($_POST["ext"])) {
      if(!empty($_POST["ext"])){
        Employee::insertExt($username, $_POST["ext"]);
      }      
    }
    
  } else {
    require( TEMPLATE_PATH . "/confirm_email.php" );
  }
}

function getUserIP() {
  $client = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote = $_SERVER['REMOTE_ADDR'];

  if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
  } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
  } else {
    $ip = $remote;
  }

  return $ip;
}

?>