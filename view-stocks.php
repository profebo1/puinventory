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
include 'process/connect.php';
include 'process/functions.php';
$pagname = "Stocks";
head($pagname);

?>

<body>
    <div class="dashboard-container">
        <?= sidebar() ?>
        <main class="main-content">
            <?= getheader($pagname) ?>
            <section class="content">
                <div class="card">
                    <h3>View Stocks</h3>
                    <div id="stocksContainer">
                        <?php
                        $sql = "SELECT itemid, itemName, itemDesc FROM stocks";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0) {
                        ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Current Stock</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php }

                            while ($row = $result->fetch_array()) {
                                ?>
                                    <?php
                                    $itemid = $row["itemid"];
                                    $itemName = $row["itemName"];
                                    $currentStock = currentStockLevel($itemid);
                                    $statusColor = getStatusColor($currentStock);
                                    ?>
                                    <tr>
                                        <td><?= $itemid  ?></td>
                                        <td><?= $itemName ?></td>
                                        <td><?= $row["itemDesc"] ?></td>
                                        <td><?= $currentStock ?></td>
                                        <td style="background-color: <?= $statusColor ?>">
                                            <!-- <span style="width:50px; height: 50px; background-color: <?= $statusColor ?>"></span> -->
                                        </td>
                                        <td>

                                            <!-- <a class="nav-link add-to-item" href="#" style="color: green"
                                            onclick="showAddToItemModal('<?= htmlspecialchars($row['itemid']) ?>', '<?php echo htmlspecialchars($row['itemName']) ?>', '<?= htmlspecialchars(currentStockLevel($row['itemid'])) ?>')">
                                            <i class="fa fa-plus-square" aria-hidden="true"></i> Add To Quantity
                                        </a> -->
                                            <a class="nav-link add-to-item" href="#" style="color: green" onclick="showAddToItemModal('<?= htmlspecialchars($row['itemid']) ?>', '<?= htmlspecialchars($row['itemName']) ?>', '<?= htmlspecialchars($currentStock) ?>')">
                                                <i class="fa fa-plus-square" aria-hidden="true"></i> Add-up
                                            </a>

                                        </td>
                                        <td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i> Track</a></td>
                                        <td><a href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                            </a></td>
                                        <td><a href="#" style="color: red"><i class="fa fa-trash" aria-hidden="true"></i>
                                                Delete</a></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!-- addtoitemsModal -->


    <?php
    include 'includes/modals.php';
    scripts() ?>


</body>

</html>