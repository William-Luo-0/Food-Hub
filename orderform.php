<?php
include "database.php";
require "header.php";
?>

<main>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Order</h1>
            <p class="lead">Please fill in the information below to place an order.</p>
            <hr class="my-4">
        </div>
    </div>
    <?php require "includes/orderform.inc.php"; ?>
</main>

<?php
require "footer.php";
?>
