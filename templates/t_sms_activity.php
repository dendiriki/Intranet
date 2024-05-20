<!DOCTYPE html>
<html lang="en">
	<?php include 'common/header.php' ?> 
  <body>
		<?php include 'common/navigation.php' ?>
		<div class="section light-blue">
      <div class="container">
        <h5 class="white-text">SMS Activity</h5>
      </div>
    </div>
		<div class="section">
			<div class="container">      
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content">                
                <span class="card-title center">Upload SMS Activity</span>
                <form method="post" action="#" enctype="multipart/form-data">
									<div class="row">
										<div class="col s12 m6 l8">
											<div class="file-field input-field">
												<div class="btn">
													<span>Excel</span>
													<input type="file" name="excel" required="required">
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text">
												</div>
											</div>
										</div>
										<div class="col s12 m6 l4">
											<div class="input-field">
												<button class="waves-effect waves-light btn light-blue darken-4" type="submit" name="upload" value="true">upload</button>
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

  </body>
</html>
