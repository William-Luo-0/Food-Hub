<?php
include "database.php";
require "header.php";
?>

<main role="main" class="container">
    <?php
    if (isset($_GET['edit'])) {
        if ($_GET['edit'] == 'success') {
            echo '<div class="jumbotron text-center" style="padding-top: 1rem; padding-bottom: 0.5rem">
                    <p class="success-text">Account information successfully edited!</p>
                   </div>';
        }
    }
    ?>
    <div class="jumbotron text-center" style="padding-bottom: 1rem">
        <h1 class="display-4"> <?php echo $_SESSION['Name']; ?>'s Profile </h1>
        <hr class="my-4">
        <p class="lead"> <?php echo $_SESSION['AccountType']; ?> </p>
    </div>
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-10">
                <h1 class="display-4">Account Information</h1>
            </div>
            <div class="col-md-2">
                <a class="btn btn-lg btn-success my-4" href="profile.edit.php">Edit</a>
            </div>
        </div>
        <p class="lead">Your personal information is below.</p>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <p class="lead">Name: <?php echo $_SESSION['Name']; ?></p>
            </div>
            <div class="col-md-6">
                <p class="lead">Email Address: <?php echo $_SESSION['EmailAddress']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="lead">Account Type: <?php echo $_SESSION['AccountType']; ?></p>
            </div>
            <div class="col-md-6">
                <p class="lead">Password: ************</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="lead">Phone Number: <?php echo preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $_SESSION['PhoneNumber']); ?></p>
            </div>
            <div class="col-md-6">
                <p class="lead">Street: <?php echo $_SESSION['Street']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="lead">House Number: <?php echo $_SESSION['HouseNumber']; ?></p>
            </div>
            <div class="col-md-6">
                <p class="lead">Apartment Number: <?php echo $_SESSION['ApartmentNumber']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="lead">Postal Code: <?php echo $_SESSION['PostalCode']; ?></p>
            </div>
            <div class="col-md-6">
                <p class="lead">Province: <?php echo $_SESSION['Province']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="lead">City: <?php echo $_SESSION['City']; ?></p>
            </div>
        </div>
    </div>
    <?php
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
