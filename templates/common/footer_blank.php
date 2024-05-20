</main>
<?php 
if(empty($username)){
?>

<div class="fixed-action-btn hide-on-large-only">
  <a class="btn-floating btn-large red tooltipped" href="#modal-login"data-position="top" data-delay="50" data-tooltip="Login">
    <i class="large material-icons">&#xE0DA</i>
  </a>
</div>

<form action="index.php?action=login" method="post">
  <input type="hidden" name="login" value="true" />
  <div id="modal-login" class="modal" style="max-width: 300px;">
    <div class="modal-content">
      <h4>Login</h4>
      <div class="row">

        <div class="input-field col s12">
          <input name="username" placeholder="Username" id="username" type="text" class="validate" required="required">
          <label for="first_name">Username(Payroll Number)</label>
        </div>
        <div class="input-field col s12">
          <input name="password" id="password" type="password" class="validate" required="required">
          <label for="last_name">Password</label>
        </div>

      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" name="login" value="login" class="modal-action waves-effect waves-green btn-flat">Login</button>
      <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</button>
    </div>
  </div>
</form>
<?php 
} else {
?>
<div class="fixed-action-btn hide-on-large-only">
  <a class="btn-floating btn-large red tooltipped" href="?action=logout" data-position="top" data-delay="50" data-tooltip="Logout">
    <i class="large material-icons">&#xE879</i>
  </a>
</div>
<?php
}
?>

<!--  Scripts-->
<script src="templates/vendor/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="templates/vendor/materialize/js/materialize.min.js" type="text/javascript"></script>
<script src="templates/js/init.js" type="text/javascript"></script>