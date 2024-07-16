<?php

session_start();
// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    header("Location: auth/login.php");
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: process/logout.php");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();
include 'process/functions.php';
$pagname = "Main Dashboard";
head($pagname);

?>

<body>
    <div class="dashboard-container">
        <?= sidebar() ?>
        <main class="main-content">
            <header class="main-header">

                <h2>Welcome, User!</h2>
            </header>
            <section class="content">
                <div class="row">
                    <div class="col">
                        <a href="#" class="d-flex flex-column align-items-center justify-content-center text-center">
                            <i class="fa fa-shopping-basket mb-2"></i>
                            <ul class="list-unstyled">
                                <li>350</li>
                                <li>Store Items</li>
                            </ul>
                        </a>
                    </div>
                    <div class="col">
                        <div class="card">
                            <h3>Card Title</h3>
                            <p>Some content goes here.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <h3>Card Title</h3>
                            <p>Some content goes here.</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <h3>Card Title</h3>
                            <p>Some content goes here.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/font-awesome/all.min.js"></script> -->
    <?= scripts() ?>
</body>

</html>