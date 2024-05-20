<!DOCTYPE html>
<html lang="en">
	<?php include 'common/header.php' ?> 
  <body>
		<?php include 'common/navigation.php' ?>
		<div class="section light-blue">
      <div class="container">
        <h5 class="white-text">Insert PA Manual</h5>
      </div>
    </div>
		<div class="section">
			<div class="container">      
        <div class="row">
					<?php 
					if(isset($success)) {
					?>
					<div class="col s12 m12">
						<div class="card-panel teal">
							<span class="white-text"><?php echo $success; ?></span>
						</div>
					</div>
					<?php
					}
					?>
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content"> 
                <form method="post" action="#" enctype="multipart/form-data">
									<div class="row">
										<div class="col s12">
											<div class="input-field">
												<select name="VC_COMP_CODE">
													<?php 
													foreach ($company as $comp) {
														echo '<option value="'.$comp["VC_COMP_CODE"].'">'.$comp["VC_COMP_CODE"]." - ".$comp["VC_COMPANY_NAME"].'</option>';
													}
													?>
												</select>
												<label>Select Company</label>
											</div>
										</div>
										<div class="col s12">
											<div class="input-field">
												<select name="VC_GROUP">
													<?php 
													foreach ($group as $row) {
														echo '<option value="'.$row["id"].'">'.$row["id"]." - ".$row["name"].'</option>';
													}
													?>
												</select>
												<label>Select Company</label>
											</div>
										</div>
										<div class="col s12">
											<div class="input-field">
												<input type="date" name="DT_PERIOD_DT" id="VC_DATE">
												<label class="active" for="VC_DATE">Period</label>
											</div>
										</div>
										<div class="col s12">
											<div class="input-field">
												<input type="number" step="any" name="NU_LOAN_AMOUNT" id="NU_LOAN_AMOUNT">
												<label class="active" for="NU_LOAN_AMOUNT">Amount</label>
											</div>
										</div>
										<div class="col s12">
											<div class="input-field">
												<button class="waves-effect waves-light btn light-blue darken-4" type="submit" name="save" value="true">save</button>
											</div>											
										</div>
									</div>
											
								</form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
		<div class="section">
			<div class="container">
				<div class="row">
          <div class="col s12 m12">
						<div class="card">
							<?php 
							
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'common/footer.php' ?>  
		<script>
			$(document).ready(function(){
				$('select').material_select();
				
				
			});
		</script>
  </body>
</html>
