<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A central hub for inventory management providing restaurants, wholesalers,
    and customers the tools to do business.">
    <title>Food Hub</title>

    <link rel="icon" type="image/png" href="./public/images/landing/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="./public/images/landing/favicon-16x16.png" sizes="16x16">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./public/stylesheets/style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<?php
    if (!isset($_SESSION["Name"])) {
        echo '<header align="center">
                    <p style="font-size: 135%; padding-top: 14px;"> Register an account today!
                    <a class="btn btn-lg btn-clear-light soft-transition" role="button" href="./register.php" style="margin-left: 25px;">Register</a></p>
                </header>';
    }
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="index.php">
        <img src="./public/images/landing/FoodHubIcon.png" width="40" height="40" class="d-inline-block mr-2" alt="">
        <div class="d-inline-block pt-1">Food Hub</div>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item
                <?php
                    if (strpos($_SERVER['REQUEST_URI'], 'index.php') == true) {
                        echo 'active';
                    }
                ?>
            ">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <?php
                if (isset($_SESSION['Name'])) {
                    echo '<li class="nav-item ';
                    if (strpos($_SERVER['REQUEST_URI'], 'profile.php') == true) {
                        echo 'active';
                    }
                    echo '">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>';
                }
                if (isset($_SESSION['Name'])) {
                    echo '<li class="nav-item ';
                    if (strpos($_SERVER['REQUEST_URI'], 'order.php') == true) {
                        echo 'active';
                    }
                    echo '">
                        <a class="nav-link" href="order.php">Order</a>
                    </li>';
                }
                if (isset($_SESSION['Name']) && $_SESSION['AccountType'] == "Restaurant") {
                    echo '<li class="nav-item ';
                    if (strpos($_SERVER['REQUEST_URI'], 'autorestock.php') == true) {
                        echo 'active';
                    }
                    echo '">
                        <a class="nav-link" href="autorestock.php">Auto Restock</a>
                    </li>';

                    echo '<li class="nav-item ';
                    if (strpos($_SERVER['REQUEST_URI'], 'reports.php') == true) {
                        echo 'active';
                    }
                    echo '">
                        <a class="nav-link" href="reports.php">Reports</a>
                    </li>';
                }
            ?>
            <li class="nav-item
                <?php
                    if (strpos($_SERVER['REQUEST_URI'], 'restaurant.php') == true) {
                        echo 'active';
                    }
                ?>
            ">
                <a class="nav-link" href="restaurant.php">Restaurants</a>
            </li>
            <li class="nav-item
                <?php
                    if (strpos($_SERVER['REQUEST_URI'], 'wholesaler.php') == true) {
                        echo 'active';
                    }
                ?>
            ">
                <a class="nav-link" href="wholesaler.php">Wholesalers</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
                if (isset($_SESSION['Name'])) {
                    echo '<li class="nav-item">
                    <form action="includes/logout.inc.php" method="post">
                    <button type="submit" class="btn btn-md btn-clear-light soft-transition" name="logout-submit">Logout</button>
                    </form>
                    </li>';
                } else {
                    echo '<li class="nav-item">
                <a class="nav-link" href="login.php">Log in</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
                </li>';
                }
            ?>
        </ul>
    </div>
</nav>