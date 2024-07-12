<?php
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] != '') {

?>
    <script type="text/javascript">
        Swal.fire({
            position: "center",
            icon: "success",
            title: "Login Succes",
            text: "<?php echo $_SESSION['login_success']; ?>!",
            showConfirmButton: true,
            timer: 3500,
        });
    </script>
<?php
    unset($_SESSION['login_success']);
    // header("location:")
}
?>

<!-- login session error -->
<?php
if (isset($_SESSION['login_error']) && $_SESSION['login_error'] != '') {

?>
    <script type="text/javascript">
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Login Error",
            text: "<?php echo $_SESSION['login_error']; ?>!",
            showConfirmButton: true,
            timer: 3500
        });
    </script>
<?php
    unset($_SESSION['login_error']);
}
?>