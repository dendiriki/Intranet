<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation_blank.php' ?>
    <div class='parallax'>
    <div class="container-95 main-content">
      <div class="section">
        <div class='row'>
          <div class='col s12 m3'>
            <button type="button" onclick="createTicket()" class="btn btn-medium waves-effect" style='margin: .5rem 0 1rem 0;'>
              <i class="material-icons right">&#xE031;</i>Open Ticket
            </button>
            <a href="?action=logout" class="btn btn-medium waves-effect red darken-1" style='margin: .5rem 0 1rem 0;'>
              <i class="material-icons right">&#xE879;</i>LOGOUT
            </a>
          </div>
          
          <div class='col s12 m9'>
            <ul class="collapsible" data-collapsible="accordion">
              <li>
                <div class="collapsible-header"><i class="material-icons">&#xE152;</i>Filter</div>
                <div class="collapsible-body" style="padding:5px;">
                  <div class="row" style="margin-bottom:0px;">
                    <form method="GET" action="#">
                      <input type="hidden" name="action" value="it_ticket">
                      <div class="input-field col s12 m3">
                        <select name="category">
                          <option value="" <?php if(!isset($filter["category"]) || empty($filter["category"])) {echo "selected";} ?>>All</option>
                          <option value="H" <?php if(isset($filter["category"])) {if($filter["category"] == "H") {echo "selected";}} ?>>HARDWARE</option>
                          <option value="S" <?php if(isset($filter["category"])) {if($filter["category"] == "S") {echo "selected";}} ?>>SOFTWARE</option>
                        </select>
                        <label>Category</label>
                      </div>
                    <div class="input-field col s12 m3">
                      <select name="priority">
                        <option value="" <?php if(!isset($filter["priority"]) || empty($filter["priority"])) {echo "selected";} ?>>All</option>
                        <option value="L" <?php if(isset($filter["priority"])) {if($filter["priority"] == "L") {echo "selected";}} ?>>LOW</option>
                        <option value="M" <?php if(isset($filter["priority"])) {if($filter["priority"] == "M") {echo "selected";}} ?>>MIDDLE</option>
                        <option value="H" <?php if(isset($filter["priority"])) {if($filter["priority"] == "H") {echo "selected";}} ?>>HIGH</option>
                      </select>
                      <label>Priority</label>
                    </div>
                    <div class="input-field col s12 m3">
                      <select name="status[]" multiple>
                        <option value="" <?php if(!isset($filter["status"]) || empty($filter["status"])) {echo "selected";} ?>>All</option>
                        <option value="O" <?php if(isset($filter["status"])) {if(in_array("O",$filter["status"])) {echo "selected";}} ?>>OPEN</option>
                        <option value="P" <?php if(isset($filter["status"])) {if(in_array("P",$filter["status"])) {echo "selected";}} ?>>ON PROGRESS</option>
                        <option value="N" <?php if(isset($filter["status"])) {if(in_array("N",$filter["status"])) {echo "selected";}} ?>>NEED CONFIRMATION</option>
                        <option value="X" <?php if(isset($filter["status"])) {if(in_array("X",$filter["status"])) {echo "selected";}} ?>>CLOSED</option>
                        <option value="C" <?php if(isset($filter["status"])) {if(in_array("C",$filter["status"])) {echo "selected";}} ?>>CANCELED</option>
                      </select>
                      <label>Status</label>
                    </div>
                    <div class="input-field col s12 m3">
                      <input placeholder="DD-MM-YYYY" name="created_date" id="created_date" type="text" value="<?php if(isset($filter["created_date"])) {echo $filter["created_date"];} ?>">
                      <label for="created_date">Created Date</label>
                    </div>
                    <div class="input-field col m4 s12">
                      <select id="pic" name="pic" >
                        <option value="" <?php if(!isset($filter["pic"]) || empty($filter["pic"])) {echo "selected";} ?>>Choose your option</option>
                        <?php
                        $the_pic = $filter["pic"];
                        foreach($data["it_support_list"] as $it_list) {
                          if($it_list["username"] == $the_pic) {
                            echo "<option value='".$it_list["username"]."' selected>".$it_list["name"]."</option>";
                          } else {
                            echo "<option value='".$it_list["username"]."'>".$it_list["name"]."</option>";
                          }
                        }
                        ?>
                      </select>
                      <label for="pic">Person In Charge</label>
                    </div>
                    <div class="input-field col s12 m4">
                      <input placeholder="filter your subject" name="subject" id="subject" type="text" value="<?php if(isset($filter["subject"])) {echo $filter["subject"];} ?>">
                      <label for="subject">Subject</label>
                    </div>
                    <div class='input-field col m2 s12'>
                      <select name="rows_per_page">
                        <option value="5" <?php if($filter["rows"]==5) echo "selected"?>>5</option>
                        <option value="10" <?php if($filter["rows"]==10) echo "selected"?>>10</option>
                        <option value="15" <?php if($filter["rows"]==15) echo "selected"?>>15</option>
                        <option value="20" <?php if($filter["rows"]==20) echo "selected"?>>20</option>
                        <option value="30" <?php if($filter["rows"]==30) echo "selected"?>>30</option>
                      </select>
                      <label>Rows Per Page</label>
                    </div>
                      <div class="col s12 m2 center"><button type="submit" name="refresh" value="refresh" class="btn waves-effect" style="margin-top:10px"><i class="material-icons">&#xE5D5;</i></button></div>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        
        <?php 
        if(empty($ext_number)) {
          echo '<div class="card-panel">Your Phone Extension Number is empty, please consider update your extension <a href="?action=personal_data" target="_blank"><b>HERE</b></a></div>';
        }
        ?>
        
        <div class="card-panel" style='padding:10px !important;'>
          <table class="striped bordered table-ticket responsive-table white">
            <thead>
              <tr class="medium-text light-blue darken-4 white-text">
                <th>No.</th>
                <th>Subject</th>
                <th>Category</th>
                <th>Sub<br>Category</th>
                <th>Created<br>By</th>
                <th>On Behalf</th>
                <th>PIC</th>
                <th>Created<br>Date</th>
                <th>Last Changed<br>Date</th>
                <th>Priority</th>
                <th>Status</th>
                <?php
                if($role_it_support >= 1 || $role_it_manager >= 1) {
                  echo "<th>Take<br>Ticket</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($data["inquiry_list"]["list"])) {
                foreach ($data["inquiry_list"]["list"] as $ticket) {
                  ?>
                  <tr class="small-text">
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php echo $ticket->id ?></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><a href="?action=it_ticket&ticket=<?php echo $ticket->id ?>"><?php echo $ticket->subject ?></a></td>                  
                    <td class='center' onclick="editTicket('<?php echo $ticket->id ?>')">
                      <?php echo $ticket->up_category_desc ?>
                    </td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php echo $ticket->category_desc ?></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php if(!empty($ticket->create_name)) {echo $ticket->create_name;} else {echo $ticket->create_by;} ?></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php if(!empty($ticket->req_name)) {echo $ticket->req_name;} else {echo $ticket->req_by; } ?></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><span class="tooltipped" data-position="top" data-delay="50" data-tooltip=" <?php echo $ticket->pic_name;?>"><?php echo $ticket->pic ?></span></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php echo $ticket->create_date ?></td>
                    <td onclick="editTicket('<?php echo $ticket->id ?>')"><?php echo $ticket->last_change_date ?></td>
                    <td class='center'>
                      <a class="tooltipped" data-position="top" data-delay="50" data-tooltip=" <?php echo $ticket->priority_desc;?>"><i class="material-icons medium-text" style="color: <?php echo $ticket->priority_color;?>" >&#xE000;</i></a>
                    </td>
                    <td class='center'>
                      <a class="tooltipped" data-position="top" data-delay="50" data-tooltip=" <?php echo $ticket->status_desc;?>"><i class="material-icons medium-text" style="color:<?php echo $ticket->status_color;?>">&#xE88E;</i></a>
                    </td>
                    <?php
                    if($role_it_support >= 1 || $role_it_manager >= 1) {
                      if(empty($ticket->pic) && $ticket->status == "O") {
                        echo '<td class="center"><button onclick="assignTicket('.$ticket->id.')" class="btn-flat btn-small waves-effect"><i class="material-icons medium-text">&#xE913;</i></button></td>';
                      } else {
                        echo '<td class="center"><button class="btn-flat btn-small disabled"><i class="material-icons medium-text">&#xE8DC;</i></button></td>';
                      }
                    }
                    ?>
                  </tr>
                  <?php
                }
              } else {
                echo "<tr><td colspan=9 class='center'>No Ticket Right Now</td></tr>";
              }
              ?>
            </tbody>

          </table>
          <div class='row' style="margin-bottom:0px;">
            <div class='col m12 s12'>
              <ul class="pagination">
                <?php 
                /******  build the pagination links ******/
                // range of num links to show
                $range = 3;
                $currentpage = 1;
                $totalpages = $data["inquiry_list"]["page"];
                if (isset($_GET["page"])) {
                  $currentpage = $_GET["page"];
                }
                // if not on page 1, don't show back links
                if ($currentpage > 1) {
                   // show << link to go back to page 1 
                   echo '<li class="waves-effect"><a href="?action=it_ticket&page=1"><i class="material-icons">&#xE5DC;</i></a></li>';
                   // get previous page num
                   $prevpage = $currentpage - 1;
                   // show < link to go back to 1 page
                   echo '<li class="waves-effect"><a href="?action=it_ticket&page='.$prevpage.'"><i class="material-icons">chevron_left</i></a></li>';
                } // end if 

                // loop to show links to range of pages around current page
                for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                   // if it's a valid page number...
                   if (($x > 0) && ($x <= $totalpages)) {
                      // if we're on current page...
                      if ($x == $currentpage) {
                         // 'highlight' it but don't make a link
                         echo '<li class="active disabled"><a href="#!">' . $x . '</a></li>';
                      // if not current page...
                      } else {
                         // make it a link
                         echo '<li class="waves-effect"><a href="?action=it_ticket&page=' . $x . '">' . $x . '</a></li>';
                      } // end else
                   } // end if 
                } // end for

                // if not on last page, show forward and last page links        
                if ($currentpage != $totalpages) {
                  // get next page
                  $nextpage = $currentpage + 1;
                  // echo forward link for next page 
                  echo '<li class="waves-effect"><a href="?action=it_ticket&page='.$nextpage.'"><i class="material-icons">chevron_right</i></a></li>';
                  // echo forward link for lastpage
                  echo '<li class="waves-effect"><a href="?action=it_ticket&page='.$totalpages.'"><i class="material-icons">&#xE5DD;</i></a></li>';
                } // end if
                /****** end build pagination links ******/

                ?>
              </ul>
            </div>
            
          </div>
            
        </div>
        <div class='card-panel' style='padding:5px !important;'>
          <div class='card-content'>
            <div class="row small-text">
              <div class='col s12 m3'>
                <ul class="collection with-header">
                  <li class="collection-header"><h6>Priority Legend</h6></li>
                  <?php 
                  foreach($legend_priority as $lp) {
                    echo '<li class="collection-item item-small">'.$lp["desc"].'<i class="material-icons secondary-content medium-text" style="color: '.$lp["color"].'" >&#xE000;</i></li>';
                  }
                  ?>
                </ul>
              </div>
              <div class='col s12 m3'>
                <ul class="collection with-header">
                  <li class="collection-header"><h6>Status Legend</h6></li>
                  <?php 
                  foreach($legend_status as $ls) {
                    echo '<li class="collection-item item-small">'.$ls["desc"].'<i class="material-icons secondary-content medium-text" style="color: '.$ls["color"].'" >&#xE88E;</i></li>';
                  }
                  ?>
                </ul>
              </div>
              <div class='col s12 m6'>
                <ul class="collection with-header">
                  <li class="collection-header"><h5>IT SUPPORT TICKETING SYSTEM</h5></li>
                  <li class="collection-item">You Are Logged in as (<?php echo $username; ?>) <?php echo $employee->name; ?></li>
                  <?php 
                  if(empty($ext_number)) {
                    echo '<li class="collection-item">Your Phone Extension Number is empty, please consider update your extension <a href="?action=personal_data" target="_blank"><b>HERE</b></a></li>';
                  }
                  ?>
                  <li class="collection-item">Back To <a href="http://intranet.ispatindo.com" target="_blank">Intranet</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <?php include 'common/footer_blank.php' ?>  

    <script>
      /*auto refresh interval 5 menit*/
      var time = new Date().getTime();
      $(document.body).bind("mousemove keypress", function(e) {
        time = new Date().getTime();
      });

      function refresh() {
        if(new Date().getTime() - time >= 300000) 
          window.location.reload(true);
        else 
          setTimeout(refresh, 10000);
      }

      setTimeout(refresh, 10000);
      /*-----------------------------*/
      
      function editTicket(ticket_id) {
        location = "index.php?action=it_ticket&ticket="+ticket_id;
      }

      function createTicket() {
        location = "index.php?action=it_ticket&ticket=0";
      }
      
      function assignTicket(ticket_id) {
        var r = confirm("Apakah anda yakin mengambil tiket ini?");
        if (r == true) {
          location = "index.php?action=it_ticket&assign_to_me="+ticket_id;
        }
      }
            
      $(document).ready(function() {
        <?php
        if(isset($_GET["success"])) {
          echo "Materialize.toast('Ticket Saved', 4000);";
        } 
        
        if(isset($_GET["error"])) {
          echo "Materialize.toast('".$_GET["error"]."', 4000);";
        }
        ?>
        $('.parallax').parallax();
        $('select').material_select();
      });
    </script>
  </body>
</html>
