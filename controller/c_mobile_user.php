<?php
if($action == "mobile_user") {
	if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
	$class = new MobileUser();
	
	if(isset($_GET["del_kunnr"])) {
		$usrid = $_GET["del_kunnr"];
		if($class->delKunnr($usrid)) {
			$msg["class"] = "green-text";
      $msg["text"] = "Customer Code Removed";
		} else {
			$msg["class"] = "red-text";
      $msg["text"] = "Operation Error";
		}
	}
	
	if(isset($_GET["add_kunnr"])) {
		$usrid = $_GET["add_kunnr"];
		$kunnr = $_GET["kunnr"];
		$save = $class->addKunnr($usrid,$kunnr);
		if($save["status"] == true) {
			$msg["class"] = "green-text";
      $msg["text"] = "Customer Code Linked";
		} else {
			$msg["class"] = "red-text";
      $msg["text"] = $save["message"];
		}
	}
	$user_list = $class->getList();
	require( TEMPLATE_PATH . "/mobile_user_list.php" );
}
?>