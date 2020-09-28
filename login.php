<?php
include "database.php";
require "header.php";
?>
<main>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Login</h1>
            <p class="lead">Please fill in the information below to login or register a new account.</p>
            <hr class="my-4">
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'invalidemail') {
                    echo '<p class="error-text">Email address is not registered.</p>';
                } else if ($_GET['error'] == 'incorrectpassword') {
                    echo '<p class="error-text">Password is incorrect.</p>';
                }
            } else if (isset($_GET['register'])) {
                if ($_GET['register'] == 'success') {
                    echo '<p class="success-text">Registration successful!</p>';
                }
            }
            ?>
        </div>
    </div>
    <div class="container">
        <form class="needs-validation" novalidate action="./includes/login.inc.php" method="post">
            <div class="form-group">
                <label for="AccountType">Select Account Type</label>
                <select class="form-control" id="AccountType" name="AccountType" required>
                    <?php
                    if (isset($_GET["Type"]) && $_GET["Type"] == "Customer") {
                        echo '<option selected>Customer</option>';
                    } else {
                        echo '<option>Customer</option>';
                    }
                    if (isset($_GET["Type"]) && $_GET["Type"] == "Restaurant") {
                        echo '<option selected>Restaurant</option>';
                    } else {
                        echo '<option>Restaurant</option>';
                    }
                    if (isset($_GET["Type"]) && $_GET["Type"] == "Wholesaler") {
                        echo '<option selected>Wholesaler</option>';
                    } else {
                        echo '<option>Wholesaler</option>';
                    }
                    ?>
                </select>
                <div class="invalid-feedback">
                    Please choose an account type.
                </div>
            </div>
            <div class="form-group">
                <label for="Email Address">Email address</label>
                <input type="email" class="form-control" id="Email Address" name="EmailAddress" placeholder="Enter email" required>
                <div class="invalid-feedback">
                    Please enter an email address.
                </div>
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="login-submit">Login</button>
        </form>

        <a class="btn btn-success btn-lg btn-block my-2" href="register.php" role="register">Register</a>
    </div>
</main>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php
require "footer.php";
?>
