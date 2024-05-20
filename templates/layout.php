<!-- layout.php -->

<!DOCTYPE html>
<html lang="en">

<?php include 'common/hederdocument.php' ?> 
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Upload PDF</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if ($user_role == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=isos">ISOs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=types">Type</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=documents">Documents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=dthistdoc">Isi Documents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=docdept">Doc Dept</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=dep">Dept</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=viewapproved">User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=company">Company</a>
                        </li>
                    <?php } ?>

                    <?php if ($user_role == 'hod') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=approval">Not Approved Documents</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=new_document">New Document</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=file_list">File List</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($username)) { ?>
                        <!-- Tampilkan user info dan logout button -->
                        <form id="logout-form" action="index.php?action=logout" method="POST" style="display: none;">
                        </form>
                        <li class="nav-item">
                            <p class="nav-link"> username : <?php echo $username; ?></p>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    <?php } else { ?>
                        <!-- Tampilkan login/register links -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=login">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        if (isset($content)) {
            include $content;
        } else {
            echo '<h1>Welcome to Your App</h1>';
        }
        ?>
    </div>

    <!-- Link Bootstrap JS dari CDN -->

</body>
<?php include 'common/footerdocumen.php' ?> 

</html>
