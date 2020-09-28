<?php
include "database.php";
require "header.php";
?>

    <main role="main" class="container">
        <div class="starter-template">
            <h1>Reports</h1>
            <p class="lead">Extract information about orders.</p>
        </div>
    </main>

<div class="container">
    <?php require "includes/reports.inc.php"; ?>
</div>

<?php
require "footer.php";
?>
