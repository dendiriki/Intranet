<?php
if($action == 'sap_user') {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $sapUser = new SapUser();
  if(isset($_GET["reset"])) {
    if($sapUser->unlockAccount($_GET["reset"]) == true) {
      header("Location: index.php?action=sap_user&success=true");
    } else {
      header("Location: index.php?action=sap_user&error=true");
    }
  } else {
    $msg = array();
    if(isset($_GET["success"])) {
      $msg["class"] = "green-text";
      $msg["text"] = "User Unlocked";
    }
    
    if(isset($_GET["error"])) {
      $msg["class"] = "red-text";
      $msg["text"] = "Operation Error";
    }
    $user_list = $sapUser->getList();
    require( TEMPLATE_PATH . "/sap_user_list.php" );
  }
}

?>