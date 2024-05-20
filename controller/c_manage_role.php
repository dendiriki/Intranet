<?php

// put your code here

if($action == "manage_role") {
  $data = array();
  if (isset($_GET["roleId"])) {
    //echo $_SERVER['REQUEST_URI'];
    if (isset($_POST["save"])) {
      //echo "save";
      $param["name"] = $_POST["name"];
      $param["desc"] = $_POST["desc"];
      if ($_POST["id"] == 0 || $_POST["id"] == "0") {
        // new role
        $role = new Role($param);
        if ($role->insert()) {
          header('Location: index.php?action=manage_role&success=true');
        } else {
          header('Location: index.php?action=manage_role&roleId=0&success=false');
        }
      } else {
        // edit role
        $param["id"] = $_POST["id"];
        $role = new Role($param);
        if ($role->update()) {
          header('Location: index.php?action=manage_role&success=true');
        } else {
          header('Location: index.php?action=manage_role&roleId=' . $param["id"] . '&success=false');
        }
      }
    } elseif (isset($_GET["addMenu"])) {
      //echo "add Menu";
      $role_id = $_GET["roleId"];
      $menu_id = $_GET["menuId"];
      $role = new Role();
      $result = $role->addMenuRole($role_id, $menu_id);

      if ($result["status"] == "ok") {
        $data["success"] = $result["msg"];
      } else {
        $data["error"] = $result["msg"];
      }
      $data["action"] = "Edit Role";
      $data["role"] = $role->getById($role_id);
      $data["menu"] = $role->getMenuRole($role_id);
      $data["menu_list"] = Menu::getList();
      require( TEMPLATE_PATH . "/edit_role.php" );
    } elseif (isset($_GET["deleteMenu"])) {
      //echo "delete Menu";
      $role_id = $_GET["roleId"];
      $menu_id = $_GET["menuId"];
      $role = new Role();
      $role->deleteMenuRole($role_id, $menu_id);
      $data["action"] = "Edit Role";
      $data["role"] = $role->getById($role_id);
      $data["menu"] = $role->getMenuRole($role_id);
      $data["menu_list"] = Menu::getList();
      require( TEMPLATE_PATH . "/edit_role.php" );
    } else {
      //echo "other";
      if ($_GET["roleId"] == 0 || $_GET["roleId"] == "0") {
        if (isset($_GET["success"]))
          $data["error"] = "Failed to save role";
        $data["action"] = "New Role";
      } else {
        if (isset($_GET["success"]))
          $data["error"] = "Failed to update role";
        $data["action"] = "Edit Role";
        $data["role"] = Role::getById($_GET["roleId"]);
        $data["menu"] = Role::getMenuRole($_GET["roleId"]);
        $data["menu_list"] = Menu::getList();
      }
      require( TEMPLATE_PATH . "/edit_role.php" );
    }
  } else {
    if (isset($_GET["success"]))
      $data["success"] = "Menu saved";
    $role_list = Role::getList();
    require( TEMPLATE_PATH . "/manage_role.php" );
  }
}
?>