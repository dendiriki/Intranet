<?php
ini_set("error_reporting", E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set("error_log", "log/php-error.log");
ini_set("display_errors", true);

date_default_timezone_set("Asia/Jakarta");  // http://www.php.net/manual/en/timezones.php

define("ENVIRONMENT", "PRD"); // DEV||PRD
define("MANDT", "600");

// Koneksi ke database Oracle lokal pluggable database
define("DB_DSN", "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))(CONNECT_DATA = (SERVICE_NAME = xepdb1)))");
define("PDO_DSN", "oci:dbname=(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))(CONNECT_DATA = (SERVICE_NAME = xepdb1)))");

define("DB_USERNAME", "hr");
define("DB_PASSWORD", "hr");

define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("HR_PHOTO_DIR", "\\\\localhost\\HR Photo"); 
define("GALLERY_DIR", "media/gallery");
define("DIGILIB_DIR", "media/digilib");

foreach (glob("classes/*.php") as $filename) {
  require($filename);
}

function handleException($exception) {
  require(TEMPLATE_PATH . "/error.php");
  error_log($exception->getMessage());
}

set_exception_handler('handleException');
?>
