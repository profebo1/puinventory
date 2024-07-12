<?php
include 'connect.php';
function head($pagename)
{
    // Check if the user is logged in, if not, redirect to the login page
    if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
        header("Location: index.php");
        exit();
    }

    // Check if last activity time is set
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        // If last activity was more than 30 minutes ago, logout the user and redirect to login page
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();

    echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $pagename . '</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap/css/all.css">
    <link rel="stylesheet" href="assets/css/font-awesome/all.min.css">
    <link rel="stylesheet" href="assets/css/sweetalert2.css">
    <script src="assets/js/sweetalert2.js"></script>
</head>';
}

function sidebar()
{
    echo '<aside class="sidebar">
            <div class="sidebar-header">
                
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php" class="btn btn-dark"><i class="fa-solid fa-gauge"></i>  Dashboard</a></li>
                    <li><a href="view-stocks.php" class="btn btn-dark"><i class="fa-solid fa-cubes-stacked"></i>  Stocks</a></li>
                    <li><a href="suppliers.php" class="btn btn-dark"><i class="fa-solid fa-truck-field"></i>  Suppliers</a></li>
                    <li><a href="#" class="btn btn-dark"><i class="fa-solid fa-envelope"></i>  Messages</a></li>
                    <li class="submenu">
                <a href="#" class="btn btn-dark"><i class="fa-solid fa-user-shield"></i> Admin</a>
                <ul class="submenu-items">
                    <li><a href="manage-users.php" class="btn btn-dark"><i class="fa-solid fa-users"></i> Manage Users</a></li>
                    <li><a href="site-settings.php" class="btn btn-dark"><i class="fa-solid fa-cogs"></i> Site Settings</a></li>
                    <li><a href="logs.php" class="btn btn-dark"><i class="fa-solid fa-file-alt"></i> View Logs</a></li>
                </ul>
            </li>
                    <li class="closebutton"><a href="process/logout.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>  Logout</a>
                    </li>
                </ul>
            </nav>
        </aside>';
}

function getheader($pagename)
{
    echo ' <header class="main-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">' . $pagename . '</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#addNewModal">Add New</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view-stocks.php">View Stocks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="query-stocks.php" data-content="queryStocks">Query Stocks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="depleting-stocks.php" data-content="depletingStocks">Depleting Stocks</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>';
}

function getSupplierheader($pagename)
{
    echo ' <header class="main-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">' . $pagename . '</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#addSupplierModal" style="color:#800040;"><i class="fas fa-circle-plus"></i>  New
                            Supplier</a></a>

                            </li>
                        </ul>
                    </div>
                </nav>
            </header>';
}


function currentStockLevel($itemId)
{
    global $mysqli;
    $sql = "SELECT total_qty FROM stock_entries WHERE itemid = ? AND id = (SELECT MAX(id) FROM stock_entries WHERE itemid = ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $itemId, $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalQty = $result->fetch_assoc();
    $stmt->close();
    return $totalQty ? $totalQty['total_qty'] : 0;
}

function scripts()
{
    include 'process/sweetalertActions.php';
    echo '
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap/js/bootstrap.min.js"></script>
     <script src="assets/js/popper.min.js"></script>     
    <script src="assets/js/font-awesome/all.min.js"></script>
    <script src="assets/js/sweetalert2.js"></script>
    <script src="assets/js/add.js"></script>';
}
// UPDATE CURRENT STOCK LEVEL

function updateCurrentStock($staff_email, $otp)
{
    global $mysqli;
    $sql = "UPDATE otps SET `status` = 'used' WHERE genfor = ? AND otp = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('si', $staff_email, $otp);

    if ($stmt->execute()) {
        return true; // OTP status updated successfully
    } else {
        return false; // Failed to update OTP status
    }
    $stmt->close();
}

// function currentStockLevel($itemid)
// {
//     global $mysqli;
//     $sql = "SELECT total_qty FROM stock_levels WHERE itemid = ? ORDER BY date DESC LIMIT 1";
//     $stmt = $mysqli->prepare($sql);
//     $stmt->bind_param('s', $itemid);
//     $stmt->execute();
//     $stmt->bind_result($total_qty);
//     $stmt->fetch();
//     $stmt->close();
//     return $total_qty;
// }

// Function to get status color
function getStatusColor($stock)
{
    if ($stock <= 5) {
        return 'red';
    } elseif ($stock <= 10) {
        return 'orange';
    } elseif ($stock <= 15) {
        return 'yellow';
    } else {
        return 'green';
    }
}
