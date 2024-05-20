<?php
if($action == "digilib") {
  $digilib = new Digilib();
  $data["gallery_list"] = $digilib->directoryList();
  require( TEMPLATE_PATH . "/digilib_list.php" );
}

if($action == "digilib_detail") {
  $digilib = new Digilib();
  $data = array();
  $page_title = $_GET["dir"];
  $data["title"] = $page_title;
  $data["digilib_dir"] = DIGILIB_DIR."/".$_GET["dir"]."/";
  $data["files"] = $digilib->get_files($data["digilib_dir"]);
  require( TEMPLATE_PATH . "/digilib_detail.php" );
}
?>