<!DOCTYPE html>
<header>
<div class="navbar-fixed">
  <nav class="blue darken-4 nav-extended" role="navigation">
    <div class="nav-wrapper">
      <div id="logo-container" class="brand-logo">
        <div class="row margin-bottom-0">
          <div class="col m1 s12 hide-on-med-and-down"><a href="?action=home"><img src="templates/images/logointranet2.png" alt="Ispat Logo" style="height: 55px; padding-top: 8px;"/></a></div>
          <div class="col m9 s12 center-align hide-on-large-only"><div class="container">My Ispatindo Intranet</div></div>
        </div>
      </div>
      <ul class="right hide-on-med-and-down">
        <?php
        if(isset($globalMenu)) {
          foreach ($globalMenu as $gbmn) {
            ?><li><a href="?action=<?php echo $gbmn["link"]; ?>"><?php echo $gbmn["name"]; ?></a></li><?php
          }
        }
        ?>
        <?php
        if (empty($username)) {
          ?>
          <li><a href="#modal-login" class="tooltipped modal-trigger" data-position="bottom" data-delay="50" data-tooltip="Employee Login">Login</a></li>
          <?php
        } else {
          ?>
          <li class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View Your Profile"><a style="padding-left: 10px;" href="?action=personal_data"><i class="material-icons">account_box</i></a></li>
					
          <li><a href="?action=logout" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Logout from apps">Logout</a></li>
					<!--li>
            <!--a class='dropdown-button' href='#' data-activates='dropdown1'><i class="material-icons">&#xE851</i></a>
            <ul id='dropdown1' class='dropdown-content'>
              <li><a href="?action=personal_data">Profile</a></li>
              <li class="divider"></li>
              <li><a href="?action=logout">Logout</a></li>
            </ul>
          </li-->  
          <?php
        }
        ?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <?php
        if (!empty($username)) {
        ?>
        <li class="center-align blue darken-4"><b>Welcome&nbsp;<?php echo $employee->name ?></b></li>
        <?php
        }
        if(isset($globalMenu)){
        foreach($globalMenu as $gbmn) {
        ?>
        <li><a href="?action=<?php echo $gbmn["link"]; ?>"><?php echo $gbmn["name"]; ?></a></li>
        <?php
        }
        }
        if (!empty($username)) {
          foreach($menu as $mn) {
        ?>
        <li><a href="?action=<?php echo $mn["link"]; ?>"><?php echo $mn["name"]; ?></a></li>
        <?php
          }
        }
        ?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
    <?php
    /*if (!empty($username)) {      
      ?>
      <div class="nav-content hide-on-med-and-down blue darken-2" style="min-height: 38px;">
        <ul class="right">
      <?php
      foreach($menu as $mn) {
      ?>
          <li class="tooltipped <?php if($mn["id"]=="17") {echo 'amber darken-2';} ?>" data-position="bottom" data-delay="50" data-tooltip="<?php echo $mn["long_name"]; ?>"><a style="padding: 10px;" href="?action=<?php echo $mn["link"]; ?>" target="<?php echo $mn["target"]; ?>"><?php echo $mn["name"]; ?></a></li>
      <?php
      }?>
          
        </ul>
      </div>
    <?php
    } */
    ?>
  </nav>
</div>
<?php
/*if (!empty($username)) {
?>
  <div class="hide-on-med-and-down" style="padding-top:30px;"></div>
<?php
} */
?>
</header>
<main>
	<?php if(!empty($username)) { ?>
	<div class="row hide-on-med-and-down blue darken-2 margin-bottom-0" style="padding-top: 5px;">
		<?php foreach($menu as $mn) {  ?>
		<div class="col l2 m3 s12" style="padding-left:3px !important;padding-right:3px !important;">
			<a class="btn btn-small btn-block white-text waves-light <?php if($mn["id"]=="17") {echo 'amber darken-2';} else {echo "blue";} ?>" style="margin-bottom:5px;" href="?action=<?php echo $mn["link"]; ?>" target="<?php echo $mn["target"]; ?>"><?php echo $mn["name"]; ?></a>
		</div>
		<?php } ?>
	</div>
	<?php 
	}
	?>