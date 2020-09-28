<?php
include "database.php";
require "header.php";


if (!isset($_GET["ID"])) {
    echo '
        <main role="main" class="container">
            <div class="starter-template">
                    <h1>Auto Restock Rules</h1>
                    <p class="lead">Set up auto restock rules.</p>
            </div>
        </main>';
} ?>

<div class="container">
    <?php require "includes/autorestock.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
