<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    
    <div class="section blue">
      <h5 class="center white-text">Mobile App User List</h5>
    </div>
    <div class="container white">
      <div class='row'>
        <div class='col s12'>
          <?php
          if(!empty($msg)) {
            echo "<p class='center ".$msg["class"]."'>".$msg["text"]."</p>";
          }
          ?>
        </div>
        <div class='col s12'>
          <table class="striped bordered table-ticket">
            <thead>
              <tr class="hide-on-med-and-down blue darken-1 white-text">
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
								<th>Address</th>
								<th>Company</th>
								<th>SAP Customer Code</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(!empty($user_list)) {
                  foreach($user_list as $ulist) {
                    ?>
              <tr>
								<td class="center"><?php echo htmlspecialchars($ulist["NAME1"]); ?></td>
								<td class="center"><?php echo htmlspecialchars($ulist["EMAIL"]); ?></td>
								<td class="right-align"><?php echo htmlspecialchars($ulist["PHONE"]); ?></td>
								<td><?php echo htmlspecialchars($ulist["ADDR1"]); ?></td>
								<td class="center"><?php echo htmlspecialchars($ulist["COMP1"]); ?></td>
								<td class="center"><?php if(empty($ulist["KUNNR"])) { ?><button class='btn btn-flat btn-small' onclick="openDialogKunnr('<?php echo $ulist["USRID"]; ?>')"><i class="material-icons">add</i></button><?php } else {echo htmlspecialchars($ulist["KUNNR"]).' <button onclick="deleteKunnr(\''.$ulist["USRID"].'\')" class="btn-flat waves-effect btn-small red-text"><i class="material-icons">delete</i></button>';} ?></td></tr>
                    <?php
                  } 
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>          
    </div>
		<!-- Modal Structure -->
		<div id="modal1" class="modal" style="width: 500px;">
			<div class="modal-content">
				<h4>Add Customer Code</h4>
				<div class="row">
					<div class="input-field col s12">
						<input class="validate" type="number" id="kunnr" name="kunnr" value="" data-length="10" maxlength="10">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="waves-effect waves-green btn" onclick="addKunnr()">submit</button>
				<a href="#!" class="modal-close waves-effect waves-green btn-flat">cancel</a>				
			</div>
		</div>
		<input type="hidden" id="usrid" value="">
    <?php include 'common/footer.php' ?>  
		<script>
			$(document).ready(function(){
				$('.modal').modal();
				$('input#kunnr').characterCounter();
			});
			
			function openDialogKunnr(usrid) {
				$("#usrid").val(usrid);
				$('#modal1').modal("open");
				$("#kunnr").focus();
			}
			
			function deleteKunnr(usrid) {
				var conf = confirm("Apakah anda akan menghapus Customer Code User ini?");
				if(conf) {
					window.location.assign("index.php?action=mobile_user&del_kunnr="+usrid);
				}
			}
			
			function addKunnr() {
				var kunnr = $("#kunnr").val();
				var usrid = $("#usrid").val();
				if(kunnr) {
					if(kunnr.length != 10) {
						alert("Customer Code Invalid");
					} else {
						window.location.assign("index.php?action=mobile_user&add_kunnr="+usrid+"&kunnr="+kunnr);
					}
				} else {
					alert("Customer Code Empty!");
				}
			}
		</script>
  </body>
</html>
