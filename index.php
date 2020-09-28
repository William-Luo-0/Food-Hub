<?php
 include "database.php";
 require "header.php";
 ?>
<div class="container">
    <?php
    if (isset($_SESSION['Name']) && isset($_GET["login"]) && $_GET["login"] == "success") {
        echo '<div class="container text-center">
                    <p class="lead success-text mb-0">You are now logged in '.$_SESSION["Name"].'!</p>
                </div>';
    }
    ?>
    <div class="jumbotron jumbotron-fluid mb-0" id="jumbotronHomePage">
        <div class ="container-fluid">
            <h1 class="display-4"><img src="./public/images/landing/FoodHubIcon.png" style="height: 80px; padding-right:20px;">Food Hub</h1>
            <p class="lead">A simple user-friendly service for customers, restaurants, and wholesalers</p>
            <hr class="my-3" id="hrHomePage">
            <?php
                if (!isset($_SESSION['Name'])) {
                    echo '<p class="lead">Please log in or register below</p>';
                }
            ?>
        </div>
    </div>
</div>
<?php
    if (!isset($_SESSION['Name'])) {
    echo '<div class="container">
        <div class="row" style="max-width: 1110px; margin-left: 1px;">
            <div class="col-lg-4" id="CustomerLanding">
                <div class="LandingText">
                    <h1 class="TextShadow">Customer</h1>
                    <a class="btn btn-lg btn-clear-light soft-transition" role="button" href="./login.php?Type=Customer">Log in</a>
                </div>
            </div>
            <div class="col-lg-4" id="RestaurantLanding"">
                <div class="LandingText">
                    <h1 class="TextShadow">Restaurant</h1>
                    <a class="btn btn-lg btn-clear-light soft-transition" role="button" href="./login.php?Type=Restaurant">Log in</a>
                </div>
            </div>
            <div class="col-lg-4" id="WholesalerLanding">
                <div class="LandingText">
                    <h1 class="TextShadow">Wholesaler</h1>
                    <a class="btn btn-lg btn-clear-light soft-transition" role="button" href="./login.php?Type=Wholesaler">Log in</a>
                </div>
            </div>
        </div>
    </div>';
    }
?>
<div class="container mt-4">
    <div class="row">
        <div class="col" id="customerSplash">
            <div class="container  mt-2" id="customerSplashText" align="left">
                <p>Ordering food online has never been easier with FoodHub!
                    FoodHub provides customers with the ability to order food
                    from a large selection of restaurants with a simple to use
                    and minimalistic user interface. <br>
                    Customers are also provided tools to track their order
                    history and receipts of previous orders made at restaurants.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="restaurantSplash">
            <div class="container" id="restaurantSplashText" align="left">
                <p>FoodHub provides restaurant owners with the ability to list
                their restaurant for customers to order from. We provide the tools
                to create and delete menu items easily with a search functionality for
                customers. Restaurants can also order ingredients from many wholesalers
                through a user-friendly interface and order and received order histories
                are tracked and easily managed. Additionally reports and analytics are
                automatically created for every restaurant on FoodHub.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="wholesalerSplash">
            <div class="container mt-4" id="wholesalerSplashText" align="left">
                <p>FoodHub provides wholesalers with the ability to list their company for
                restaurants to order from. We provide the tools to create and delete inventory
                items easily with a search functionality for restaurants. Wholesalers can easily
                manage and view their received orders through a user-friendly interface.</p>
            </div>
        </div>
    </div>
</div>

<?php
if (!isset($_SESSION["Name"])) {
    echo '<div class="container" id="registerToday" align="center">
            <p style="font-size: 135%; padding-top: 14px;"> Register an account today!
            <a class="btn btn-lg btn-clear-light soft-transition" role="button" href="./register.php" style="margin-left: 25px;">Register</a></p>
          </div>';
}
?>
<?php
require "footer.php";
?>
