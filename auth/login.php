<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap/css/all.css">
</head>

<body class="main-body">

    <div class="row">
        <div class="col-12 title">
            <h2>PU Inventory Management System</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="login-container">

                <div class="login-form">

                    <div class="col-6">

                        <h2>Login</h2>
                        <form>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <button type="submit">Login</button>
                        </form>

                    </div>
                    <div class="col-6">
                        <div class="welcome-message">
                            <h3>Welcome!</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco
                                laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap/js/bootstrap.min.js"></script>
</body>

</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap/css/all.css">
    <link rel="stylesheet" href="../assets/css/font-awesome/all.min.css">
</head>

<body class="main-body">

    <!-- <div class="row title-row">
        <div class="col-12 title">
            
        </div>
    </div> -->
    <!-- <h2 class="title">PU Inventory Management System</h2> -->
    <div class="row">
        <div class="col-12">
            <div class="login-container">
                <div class="login-form">
                    <div class="col-6">
                        <div class="welcome-message">
                            <h3>PU STORES <br>
                                MANAGEMENT SYSTEM
                            </h3>
                            <p>
                                Welcome to the PUINVMS. This system is engineered and managed by the Digital Services
                                Unit of the Pentecost University.
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- <h2>Login</h2> -->
                        <span class="emoji"><i class="icon fa-solid fa-circle-user"></i></span>
                        <form action="../process/process-login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success">Login</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/font-awesome/all.min.js"></script>
</body>

</html>