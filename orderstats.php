<?php
include "database.php";
require "header.php";
?>

<main role="main" class="container">
    <a class="btn btn-warning btn-lg mt-3" href="../reports.php">Go Back</a>
    <div class="starter-template">
        <h1>Order Statistics</h1>
        <p class="lead">View order statistics based on various groupings.</p>
    </div>
</main>

<div class="container">
    <?php require "includes/orderstats.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
