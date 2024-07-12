<?php
session_start();
include 'process/connect.php';
include 'process/functions.php';
$pagname = "Stocks";
head($pagname);

?>

<body>
    <div class="dashboard-container">
        <?= sidebar() ?>
        <main class="main-content">
            <?= getheader() ?>
            <section class="content">
                <div class="card">
                    <h3>Query Stocks</h3>

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