<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="section light-blue">
      <div class="container">
        <h5 class="center white-text"><?php echo $page_title; ?></h5>
      </div>
    </div>
    <div class="container">    
      <div class="section">
        <div class="row">
          <div class="col s12">            
            <div class="card-panel">
							<div class='row'>
								<div class="col s6">
									<a href="media/mobile_app/app-scrap-inspection.apk">Download Mobile Apps</a>
								</div>
								<div class="col s6">
									<form method="get" action="index.php">
										<input type="hidden" name="action" value="<?php echo $action; ?>">
										<div class="row">
											<div class="input-field col s6">
												<input placeholder="Slip Number" id="src_wsnum" type="text" name="src_wsnum" class="validate" value="<?php echo $src_wsnum; ?>">
												<label for="src_wsnum">Slip Number</label>
											</div>
											<div class="col s6 input-field">
												<button class="btn waves-effect waves-light" type="submit" name="search" value="true">
													Search <i class="material-icons right">search</i>
												</button>
											</div>
										</div>
									</form>
								</div>
								<?php 								
								if(isset($_GET["success"])) {
									$success = $_GET["success"];
									if(strtoupper($success) == "TRUE") {
										echo '<div class="chip teal lighten-2">'.
														$_GET["message"].
														'<i class="close material-icons">close</i>
													</div>';
									}
								}
								?>
							</div>
              <table class="responsive-table striped bordered table-ticket ">
                <thead>
                  <tr class="blue white-text">
                    <th>Inspection Number</th>
                    <th>Vendor</th>
                    <th>Vehicle Number</th>
                    <th>Date</th>
										<th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($data["inspection"])) {
                    foreach($data["inspection"] as $row) {
                      ?>
                  <tr>
                    <td><?php echo $row["WSNUM"]; ?></td>
                    <td><?php echo $row["NAME1"]; ?></td>
                    <td><?php echo $row["VEHICLE_NO"]; ?></td>
                    <td><?php echo $row["CRT_DT"]; ?></td>
										<td class="center"><button onclick="inspectionDetail('<?php echo $row["WSNUM"]; ?>')" type="button" class="btn btn-flat btn-small"><?php if($action=="scrap_inspection_edit") {?><i class="material-icons">edit</i><?php } else { ?><i class="material-icons">remove_red_eye</i><?php } ?></button></td>
                  </tr>
                      <?php
                    }
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
                    $totalpages = $data["total_page"];
                    if (isset($_GET["page"])) {
                      $currentpage = $_GET["page"];
                    }
                    // if not on page 1, don't show back links
                    if ($currentpage > 1) {
                       // show << link to go back to page 1 
                       echo '<li class="waves-effect"><a href="?action='.$action.'&page=1"><i class="material-icons">&#xE5DC;</i></a></li>';
                       // get previous page num
                       $prevpage = $currentpage - 1;
                       // show < link to go back to 1 page
                       echo '<li class="waves-effect"><a href="?action='.$action.'&page='.$prevpage.'"><i class="material-icons">chevron_left</i></a></li>';
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
                             echo '<li class="waves-effect"><a href="?action='.$action.'&page=' . $x . '">' . $x . '</a></li>';
                          } // end else
                       } // end if 
                    } // end for

                    // if not on last page, show forward and last page links        
                    if ($currentpage != $totalpages) {
                      // get next page
                      $nextpage = $currentpage + 1;
                      // echo forward link for next page 
                      echo '<li class="waves-effect"><a href="?action='.$action.'&page='.$nextpage.'"><i class="material-icons">chevron_right</i></a></li>';
                      // echo forward link for lastpage
                      echo '<li class="waves-effect"><a href="?action='.$action.'&page='.$totalpages.'"><i class="material-icons">&#xE5DD;</i></a></li>';
                    } // end if
                    /****** end build pagination links ******/

                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  
    <script>
      function inspectionDetail(wsnum) {
        window.location.assign("index.php?action=<?php echo $action; ?>&wsnum="+wsnum);
      }
    </script>
  </body>
</html>
