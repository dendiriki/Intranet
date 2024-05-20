<?php
if($action == "login") {
  $last_action = "home";
  if(isset($_GET["last_action"])) {
    $last_action = $_GET["last_action"];
  }
  
  if (isset($_POST['login'])) {
    // User has posted the login form: attempt to log the user in
    $user = User::getById(strtoupper($_POST['username']));
    if (!empty($user)) {
      if (md5($_POST['password']) == $user->password) {

        // Login successful: Create a session and redirect to the homepage
        $_SESSION['intra-username'] = $user->username;
        $_SESSION['reset-by-admin'] = $user->reset;
        header("Location: index.php?action=".$last_action);
      } else {

        // Login failed: display an error message to the user
        $results['errorMessage'] = "Incorrect password. Please try again.";
        require( TEMPLATE_PATH . "/login.php" );
      }
    } else {
      // Login failed: display an error message to the user
      $results['errorMessage'] = "Username did not exist, please call IT";
      require( TEMPLATE_PATH . "/login.php" );
    }
  } else {
    if(isset($_SESSION['intra-username'])) {
      header("Location: index.php?action=".$last_action);
    } else {
      require( TEMPLATE_PATH . "/login.php" );
    }
  }
}

?>