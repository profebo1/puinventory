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
$pagname = "Suppliers";
head($pagname);
?>

<body>
    <div class="dashboard-container">
        <?= sidebar() ?>
        <main class="main-content">
            <?= getSupplierheader($pagname) ?>
            <section class="content">

                <div class="card">
                    <div id="suppliersContainer">
                        <?php
                        $sql = "SELECT * FROM suppliers";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0) {
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Supplier ID</th>
                                    <th scope="col">Supplier Name</th>
                                    <th scope="col">Contact Person</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        while ($row = $result->fetch_array()) {
                                    ?>
                                <tr>
                                    <td><?= $row["supplierid"] ?></td>
                                    <td><?= $row["suppliername"] ?></td>
                                    <td><?= $row["contactperson"] ?></td>
                                    <td><?= $row["contactnumber"] ?></td>
                                    <td><?= $row["address"] ?></td>
                                    <td>
                                        <a href="#" class="nav-link" style="color: green"
                                            onclick="showEditSupplierModal('<?= htmlspecialchars($row['supplierid']) ?>', '<?= htmlspecialchars($row['suppliername']) ?>', '<?= htmlspecialchars($row['contactperson']) ?>', '<?= htmlspecialchars($row['contactnumber']) ?>','<?= htmlspecialchars($row['address']) ?>')">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="nav-link" style="color: red"
                                            onclick="deleteSupplier('<?= htmlspecialchars($row['supplierid']) ?>')">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                        <p>No suppliers found.</p>
                        <?php } ?>
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