<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($action == "logout") {
  unset($_SESSION['intra-username']);
  header("Location: index.php");
}

?>