<?php
include "database.php";
require "header.php";
?>

<main role="main" class="container">
    <a class="btn btn-warning btn-lg mt-3" href="../reports.php">Go Back</a>
    <div class="starter-template">
        <h1>Customer Loyalty</h1>
        <p class="lead">Find out who has ordered all items with specified attributes.</p>
    </div>
</main>

<div class="container">
    <?php require "includes/customerloyalty.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
