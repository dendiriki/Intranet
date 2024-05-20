<?php

if ($action == "it_ticket") {
  if (!isset($_SESSION['intra-username'])) {
    header("Location: index.php?action=login&last_action=" . $action);
    die();
  }
  $mail = new SendMail();
  $inquiry = new ItInquiry();
  $user = new User();
  $role_it_support = $user->checkUserRoleByRoleName($username, "IT_SUPPORT");
  $role_it_manager = $user->checkUserRoleByRoleName($username, "IT_MANAGER");
  $data = array();
  if (isset($_GET["ticket"])) {
    $employee = new Employee();
    $data["kategori"] = $inquiry->getCategoryList();
    $data["employee"] = $user->getList();
    $ticket_id = $_GET["ticket"];
    if (isset($_POST["save"])) {
      $req_by_full = explode("-", $_POST["req_by"]);
      $ticket_data["req_by"] = trim($req_by_full[0]);
      $req_by_name = $req_by_full[0];
      if(isset($req_by_full[1])) {
        $req_by_name = trim($req_by_full[1]);
      }
      $up_category = $_POST["up_kategori"];
      $ticket_data["category"] = $_POST["kategori"];
      $ticket_data["subject"] = $_POST["subjek"];
      $ticket_data["detail"] = $_POST["detail"];
      $attachment1 = $_FILES["attachment1"];
      $attachment2 = $_FILES["attachment2"];

      $ticket_data["priority"] = $_POST["priority"];
      $ticket_data["create_date"] = date("d-m-Y H:i"); // date format DD-MM-YYYY HH24:MI
      $ticket_data["create_by"] = $username;
      $ticket_data["status"] = $_POST["status"];
      if(empty($ticket_data["status"])) {
        $ticket_data["status"] = "O";
      }
      $reply_content = $_POST["reply"];
      if (isset($_POST["pic"])) {
        $ticket_data["pic"] = $_POST["pic"];
        if(!empty($ticket_data["pic"])) {
          if($ticket_data["status"] == "O") {
            $ticket_data["status"] = "P";
          }
        }
      }

      if ($ticket_data["status"] == "X") {
        $ticket_data["closed_date"] = date("d-m-Y H:i");
      }
      if ($_POST["ticket_no"] == "0") {
        //new ticket
        //to do, save ticket
        $inquiry->setData($ticket_data);
        // restrict filetypes and size
        $cek1 = checkFile($attachment1);
        $cek2 = checkFile($attachment2);
        
        if ($cek1 == true && $cek2 == true) {
          $hasil = $inquiry->insert();
          if ($hasil != 0) {
            //insert attachment
            if (!empty($attachment1["name"])) {
              $inquiry->uploadAttachment($hasil, $attachment1);
            }

            if (!empty($attachment2["name"])) {
              $inquiry->uploadAttachment($hasil, $attachment2);
            }
            //create log
            $inquiry->insertStatusLog($hasil, $username, $ticket_data["status"]);
            //send email to user
            $user_email_addr = $employee->getMailById($ticket_data["req_by"]);
            //$user = $employee->getById($username);
            if(!empty($user_email_addr) && $user_email_addr != "-") {
              $mail->sendITTicketMailToUser($hasil, $ticket_data["subject"], $ticket_data["priority"], $ticket_data["status"], $req_by_name, $user_email_addr, $up_category);
            }
            //send email to IT only if status open
            if($ticket_data["status"] == "O") {
              $it_list = $user->getUserListByRole("4");
              $it_user_list = array();
              foreach($it_list as $val) {
                $it_user_list[] = $val["username"];
              }
              $it_email_addr = $employee->getMailByIdMulti($it_user_list);
              if(!empty($it_email_addr)) {
                $mail->sendITTicketMailToIT($hasil, $ticket_data["subject"], $ticket_data["priority"], $req_by_name, $it_email_addr, $up_category);
              }
            } 
            
            header("Location: index.php?action=it_ticket&success=true");
          } else {
            header("Location: index.php?action=it_ticket&ticket=0");
          }
        } else {
          $user = new User();
          $data["it_support"] = $role_it_support;//$user->checkUserRoleByRoleName($username, "IT_SUPPORT");
          if($data["it_support"] == 0) {
            $data["it_support"] = $role_it_manager;
          }
          if ($data["it_support"] >= 1) {
            $data["it_support_list"] = $user->getUserListByRole(array("4","5"));
          }
          $ticket_data["id"] = "0";
          $ticket_data["req_by"] = $_POST["req_by"];
          $ticket_data["up_category"] = $_POST["up_kategori"];
          $inquiry->setData($ticket_data);
          $data["inquiry"] = $inquiry;
          $data["error"] = "File type not allowed or file size over 10mb";
          require( TEMPLATE_PATH . "/ticket_edit.php" );
          die();
        }
      } else {
        //edit ticket
        $ticket_data["id"] = $_POST["ticket_no"];
        $ticket_data["last_change_by"] = $username;
        $create_log = false;
        $is_send_email = false;
        $last_status = $inquiry->getTicketStatus($ticket_data["id"]);
        if ($last_status != $ticket_data["status"]) {
          $create_log = true;
          $is_send_email = true;          
        }
        $inquiry->setData($ticket_data);
        //var_dump($ticket_data);
        $cek1 = checkFile($attachment1);
        $cek2 = checkFile($attachment2);
        if($cek1 == true && $cek2 == true) {
          $cek_pic = true;
          if($ticket_data["status"] == "X") {
            if(empty($ticket_data["pic"])) {
              $cek_pic = false;
            } else {
              $cek_pic = true;
            }
          }
          
          $error_msg = "";
          if($cek_pic == true) {
            if($last_status == "X" || $last_status == "C") {
              $hasil = false;
              $error_msg = "Ticket Locked";
            } else {
              $hasil = $inquiry->update();
            }              
          } else {
            $hasil = false;
            $error_msg = "untuk close ticket, PIC tidak boleh kosong";
          }          

          if ($hasil == true) {
            //insert attachment
            if (!empty($attachment1["name"])) {
              $inquiry->uploadAttachment($ticket_data["id"], $attachment1);
            }

            if (!empty($attachment2["name"])) {
              $inquiry->uploadAttachment($ticket_data["id"], $attachment2);
            }
            if (!empty($reply_content)) {
              $inquiry->insertReply($ticket_data["id"], $username, $reply_content);
              $is_send_email = true;
            }

            if ($create_log == true) {
              //status changed
              $inquiry->insertStatusLog($ticket_data["id"], $username, $ticket_data["status"]);
            }
            
            if($is_send_email == true) {
              //send email to user
              $user_email_addr = $employee->getMailById($ticket_data["req_by"]);
              //$user = $employee->getById($username);
              if(!empty($user_email_addr) && $user_email_addr != "-") {
                $mail->sendITTicketMailToUser($ticket_data["id"], $ticket_data["subject"], $ticket_data["priority"], $ticket_data["status"],$req_by_name, $user_email_addr, $up_category);
              }
            }

            header("Location: index.php?action=it_ticket&success=true");
          } else {
            header("Location: index.php?action=it_ticket&ticket=" . $ticket_data["id"] . "&error=".$error_msg);
          }
        } else {
          $user = new User();
          $data["it_support"] = $role_it_support;//$user->checkUserRoleByRoleName($username, "IT_SUPPORT");
          if($data["it_support"] == 0) {
            $data["it_support"] = $role_it_manager;
          }
          if ($data["it_support"] >= 1) {
            $data["it_support_list"] = $user->getUserListByRole(array("4","5"));
          }
          $inquiry->setData($ticket_data);
          $data["inquiry"] = $inquiry;
          $data["error"] = "File type not allowed or file size over 10mb";
          require( TEMPLATE_PATH . "/ticket_edit.php" );
          die();
        }
        
      }
    } else {
      $user = new User();
      $data["it_support"] = $role_it_support;//$user->checkUserRoleByRoleName($username, "IT_SUPPORT");
      if($data["it_support"] == 0) {
        $data["it_support"] = $role_it_manager;
      }
      if ($data["it_support"] >= 1 || $ticket_id > 0) {
        $data["it_support_list"] = $user->getUserListByRole(array("4","5"));
      }
      if ($ticket_id == 0) {
        //new
        //default username
        $param["req_by"] = $username;
        $param["req_name"] = $inquiry->getEmployeeName($username);
        $param["id"] = 0;
        $data["authcheck"] = 0;
        $newInquiry = new ItInquiry($param);
        $data["inquiry"] = $newInquiry;
        $data["page_title"] = "New Ticket";
        require( TEMPLATE_PATH . "/ticket_edit.php" );
      } else {
        //edit      
        $data["page_title"] = "Edit Ticket";
        $data["inquiry"] = $inquiry->getById($ticket_id);
        $data["status_log"] = $inquiry->getStatusLog($ticket_id);
        $data["authcheck"] = 0;
        if ($data["inquiry"]->create_by != $username &&
                $data["inquiry"]->req_by != $username &&
                $data["inquiry"]->pic != $username) {
          $data["authcheck"] = 1;
        }

        if (empty($data["inquiry"]->pic)) {
          $data["authcheck"] = 0;
        }
        $extension = $employee->getExtById($data["inquiry"]->req_by);
        $data["attachment"] = $inquiry->getAttachment($ticket_id);
        $data["replies"] = $inquiry->getReply($ticket_id);
        require( TEMPLATE_PATH . "/ticket_edit.php" );
      }
    }
  } else {

    if (isset($_GET["assign_to_me"])) {
      $update_pic = $inquiry->updatePIC($_GET["assign_to_me"], $username);
      if ($update_pic == true) {
        //update status log
        $inquiry->insertStatusLog($_GET["assign_to_me"], $username, "P");
        header("Location: index.php?action=it_ticket&success=true");
      } else {
        header("Location: index.php?action=it_ticket&error=".$update_pic);
      }
    } else {
      $data["it_support_list"] = $user->getUserListByRole(array("4","5"));
      $page = 1;
      if (isset($_GET["page"])) {
        $page = $_GET["page"];
      }
      $filter = array();
      
      if(isset($_SESSION["filter-category"])) {$filter["category"] = $_SESSION["filter-category"];}
      if(isset($_SESSION["filter-priority"])) {$filter["priority"] = $_SESSION["filter-priority"];}
      if(isset($_SESSION["filter-status"])) {$filter["status"] = $_SESSION["filter-status"];}
      if(isset($_SESSION["filter-created_date"])) {$filter["created_date"] = $_SESSION["filter-created_date"];}
      if(isset($_SESSION["filter-pic"])) {$filter["pic"] = $_SESSION["filter-pic"];}
      if(isset($_SESSION["filter-subject"])) {$filter["subject"] = $_SESSION["filter-subject"];}
      $filter["rows"] = 15; //default 15 rows per page
      if(isset($_SESSION["filter-rows"])) {$filter["rows"] = $_SESSION["filter-rows"];}
      
      if (isset($_GET["category"])) {
        $_SESSION["filter-category"] = $_GET["category"];
        if (!empty($_GET["category"])) {
          $filter["category"] = $_GET["category"];
        } else {
          $filter["category"] = null;
        }
      }
      if (isset($_GET["priority"])) {        
        $_SESSION["filter-priority"] = $_GET["priority"];
        if (!empty($_GET["priority"])) {
          $filter["priority"] = $_GET["priority"];
        } else {
          $filter["priority"] = null;
        }
      }
      if (isset($_GET["status"])) {
        $_SESSION["filter-status"] = $_GET["status"];
        if (count($_GET["status"])>0) {
          $filter["status"] = $_GET["status"];
        } else {
          $filter["status"] = null;
        }
      }
      if (isset($_GET["created_date"])) {
        $_SESSION["filter-created_date"] = $_GET["created_date"];
        if (!empty($_GET["created_date"])) {
          $filter["created_date"] = $_GET["created_date"];
        } else {
          $filter["created_date"] = null;
        }
      }      
      if (isset($_GET["pic"])) {
        $_SESSION["filter-pic"] = $_GET["pic"];
        if (!empty($_GET["pic"])) {
          $filter["pic"] = $_GET["pic"];
        } else {
          $filter["pic"] = null;
        }
      }
      if (isset($_GET["subject"])) {
        $_SESSION["filter-subject"] = $_GET["subject"];
        if (!empty($_GET["subject"])) {
          $filter["subject"] = $_GET["subject"];
        } else {
          $filter["subject"] = null;
        }
      }
      if (isset($_GET["rows_per_page"])) {
        $_SESSION["filter-rows"] = $_GET["rows_per_page"];
        if (!empty($_GET["rows_per_page"])) {
          $filter["rows"] = $_GET["rows_per_page"];
        } else {
          $filter["rows"] = 15;
        }
      }
      $ext_number = Employee::getExtById($username);
      $legend_status = $inquiry->getStatusList();
      $legend_priority = $inquiry->getPriorityList();
      if ($role_it_support >= 1 || $role_it_manager >= 1) {
        $data["inquiry_list"] = $inquiry->getList($filter["rows"], $page, $filter, "*");
      } else {
        $data["inquiry_list"] = $inquiry->getList($filter["rows"], $page, $filter, $username);
      }
      require( TEMPLATE_PATH . "/ticket_list.php" );
    }
  }
}

if ($action == "ajax_get_category") {
  $up_cat = $_GET["sup_cat"];
  echo json_encode(ItInquiry::getSubCategory($up_cat));
}

function checkFile($file) {
  if (empty($file["name"])) {
    return true;
  }
  $allowed_file_type = ItInquiry::getAllowedFileType();
  $allowed_file_size = 10485760; /* 10mb */
  $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  if (!in_array($file_extension, $allowed_file_type)) {
    return false;
  }
  $file_size = $file["size"];
  if ($file_size >= $allowed_file_size) {
    return false;
  }
  return true;
}
