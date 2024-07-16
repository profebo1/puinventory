<?php

session_start();
include 'process/functions.php';
$pagname = "Stocks";
head($pagname);

?>

<body>
    <div class="dashboard-container">
        <?= sidebar() ?>
        <main class="main-content">
            <?= getheader("") ?>
            <section class="content">
                <!-- Content will be dynamically injected here -->
            </section>
        </main>
    </div>



    <?php
    include 'includes/modals.php';
    scripts() ?>


</body>

</html>