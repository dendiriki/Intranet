<?php  
if($action == "view_gallery" ) {
  viewGalletyList();
}

if($action == "view_gallery_detail") {
  viewGalleryDetail();
}

function viewGalletyList() {
  global $globalMenu;
  global $username;
  global $menu;
  global $employee;
  $gallery = new Gallery();
  $data["gallery_list"] = $gallery->directoryList();
  require( TEMPLATE_PATH . "/gallery_list.php" );
}

function viewGalleryDetail() {
  global $username;
  global $menu;
  global $employee;
  $gallery = new Gallery();
  $data = array();
  if (isset($_GET["dir"])) {
    $data["dir"] = $_GET["dir"];
  }
  require( TEMPLATE_PATH . "/gallery_detail.php" );
}
?>