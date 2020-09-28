<?php
include "database.php";
require "header.php";


if (!isset($_GET["ID"])) {
    echo '
        <main role="main" class="container">
            <div class="starter-template">
                    <h1>Restaurants</h1>
                    <p class="lead">All restaurants currently registered in Food Hub.</p>
            </div>
        </main>';
} ?>

<div class="container">
    <?php require "includes/restaurant.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
