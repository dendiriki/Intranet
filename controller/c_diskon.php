<?php
if($action == "diskon") {
  $class = new SapCommon();
  if(isset($_GET["ajax_get_so"])) {
    $vbeln = $_POST["vbeln"];
    echo json_encode($class->getDiskon($vbeln));
  } else if(isset($_GET["ajax_update_disc"])) {
    $vbeln = $_POST["vbeln"];
    $kbetr_max = $_POST["kbetr_max"].".00";
    echo json_encode($class->updateDiscount($vbeln, $kbetr_max));
  } else {
    require( TEMPLATE_PATH . "/diskon_edit.php" );
  }
  
}
?>
