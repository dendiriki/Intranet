<?php

$image_folder = '\\\\10.1.0.18\\HR PHoto';
$default_pic = "templates/images/user.png";
$pic = null;
$subdir = null;
$company = $_GET['company'];
if (isset($_GET['img']) && basename($_GET['img']) == $_GET['img']) {
  $subdir = $_GET["department"];
  $pic = $image_folder . "\\" . $subdir . "\\" . $_GET['img'];
}
$ext = null;

if (file_exists($pic) && is_readable($pic) && $company == '01') {
  //$pic = $default_pic;
  $ext = substr($pic, -3);
} else {
  echo "Network unreachable";
  $pic = $default_pic;
  $ext = substr($pic, -3);
} 

$mime = false;

switch ($ext) {
  case 'jpg':
    $mime = 'image/jpeg';
    break;
  case 'gif':
    $mime = 'image/gif';
    break;
  case 'png':
    $mime = 'image/png';
    break;
  default:
    $mime = false;
}

if ($mime) {
  header('Content-type: ' . $mime);
  header('Content-length: ' . filesize($pic));
  $file = @ fopen($pic, 'r');
  if ($file) {
    fpassthru($file);
    exit;
  }
}
?>