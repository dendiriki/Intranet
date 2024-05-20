<?php

if ($action == "document") {
    $title = "Documents";
    $username = isset($_SESSION['intra-username']) ? $_SESSION['intra-username'] : null;
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest'; // Assuming you store user roles in session
    $content = 'document_content.php'; // Path to the content file for documents
    require( TEMPLATE_PATH . "/layout.php" );
}
?>
