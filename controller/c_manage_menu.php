<?php

// put your code here
if ($action == "manage_menu") {
  $data = array();
  if (isset($_GET["menuId"])) {
    if (isset($_POST["save"])) {
      $param["name"] = $_POST["name"];
      $param["long_name"] = $_POST["long_name"];
      $param["link"] = $_POST["link"];
      $param["icon"] = $_POST["icon"];
      $param["type"] = $_POST["type"];
      $param["active"] = $_POST["active"];
      if ($_POST["id"] == 0 || $_POST["id"] == "0") {
        // new role
        $menu = new Menu($param);
        if ($menu->insert()) {
          header('Location: index.php?action=manage_menu&success=true');
        } else {
          header('Location: index.php?action=manage_menu&roleId=0&success=false');
        }
      } else {
        // edit role
        $param["id"] = $_POST["id"];
        $menu = new Menu($param);
        if ($menu->update()) {
          header('Location: index.php?action=manage_menu&success=true');
        } else {
          header('Location: index.php?action=manage_menu&roleId=' . $param["id"] . '&success=false');
        }
      }
    } else {
      if ($_GET["menuId"] == 0 || $_GET["menuId"] == "0") {
        if (isset($_GET["success"]))
          $data["error"] = "Failed to save menu";
        $data["action"] = "New Menu";
      } else {
        if (isset($_GET["success"]))
          $data["error"] = "Failed to update menu";
        $data["action"] = "Edit Menu";
        $data["menu"] = Menu::getById($_GET["menuId"]);
      }
      require( TEMPLATE_PATH . "/edit_menu.php" );
    }
  } else {
    if (isset($_GET["success"]))
      $data["success"] = "role saved";
    $menu_list = Menu::getList();
    require( TEMPLATE_PATH . "/manage_menu.php" );
  }
}
?>