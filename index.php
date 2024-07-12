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
    header("Location: ../process/logout.php");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();