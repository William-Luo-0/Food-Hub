<?php
include "database.php";
require "header.php";


if (!isset($_GET["ID"])) {
    echo '
    <main role="main" class="container">
        <div class="starter-template">
            <h1>Wholesalers</h1>
            <p class="lead">All wholesalers currently registered in Food Hub.</p>
        </div>
    </main>';
} ?>

<div class="container">
    <?php require "includes/wholesaler.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
