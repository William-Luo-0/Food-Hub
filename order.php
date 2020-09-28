<?php
include "database.php";
require "header.php";
?>

<main role="main" class="container">
    <?php
    if ($_SESSION["AccountType"] === "Restaurant") {
        echo '<a class="btn btn-success btn-block mb-4 py-3" href="./wholesaler.php" style="font-size: 1.5rem;">Make an order</a>';
    } else if ($_SESSION["AccountType"] === "Customer") {
        echo '<a class="btn btn-success btn-block mb-4 py-3" href="./restaurant.php" style="font-size: 1.5rem;">Make an order</a>';
    }
    if ($_SESSION["AccountType"] !== "Wholesaler") {
        echo '<div class="jumbotron">
        <h1 class="display-4"> Order History </h1>
        <p class="lead"> History of previous orders you made. </p>
        <hr class="my-4">';
        if ($_SESSION["AccountType"] === "Customer") {
            require "./includes/orderhistory.customer.inc.php";
        } else if ($_SESSION["AccountType"] === "Restaurant") {
            require "./includes/orderhistory.restaurant.inc.php";
        }
        echo '</div>';
    }
    ?>
    <?php
    if ($_SESSION["AccountType"] !== "Customer") {
        echo '<div class="jumbotron">
        <h1 class="display-4"> Received Order History </h1>
        <p class="lead"> History of previous orders you received. </p>
        <hr class="my-4">';
        if ($_SESSION["AccountType"] === "Restaurant") {
            require "./includes/receivedhistory.restaurant.inc.php";
        } else if ($_SESSION["AccountType"] === "Wholesaler") {
            require "./includes/receivedhistory.wholesaler.inc.php";
        }
        echo '</div>';
    }
    ?>
</main>

<?php
require "footer.php";
?>
