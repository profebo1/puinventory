<?php
session_start();
$_SESSION["curuser"] = "admin";

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    // Prepared statement to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT uname, pword FROM sysusers WHERE uname = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Bind the result variables
        $stmt->bind_result($uname, $pword);
        $stmt->fetch();

        // Verify if the provided password matches the one stored in the database
        if ($password == $pword) {
            // Passwords match, authentication successful
            $_SESSION['uname'] = $uname;
            $_SESSION['pword'] = $pword;
            // $_SESSION['user_role'] = $user_role;
            // $_SESSION['user_auth_level'] = $user_auth_level;

            // Set last activity time
            $_SESSION['last_activity'] = time();
            $_SESSION["login_success"] = "Welcome to the PU Inventory System $username";
            header("Location: ../dashboard.php");
            // $grabbers->logActivity($username, basename($_SERVER['PHP_SELF']), $username . ' logged in successfully');
            exit();
        } else {
            $_SESSION["login_error"] = "invalid email/password. Check and retry!";
            header("Location: ../index.php");
        }
    } else {
        $_SESSION["login_error"] = "invalid email/password. Check and retry!";
        header("Location: ../index.php");
        // echo "<script>alert('User: $username not found in the database')</script>";
    }

    $stmt->close();
} else {
    $_SESSION["login_error"] = "$username is not a valid PentVars email";
    header("Location: ../../index.php");
}
