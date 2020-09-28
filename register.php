<?php
include "database.php";
require "header.php";
?>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Register</h1>
        <p class="lead">Please fill in the information below register a new account.</p>
        <hr class="my-4">
        <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'passwordcheck') {
                    echo '<p class="error-text">Passwords do not match, please try again.</p>';
                } else if ($_GET['error'] == 'invalidphonenumber') {
                    echo '<p class="error-text">Phone numbers must include only the numbers 0-9.</p>';
                } else if ($_GET['error'] == 'emailtaken') {
                    echo '<p class="error-text">The email address is already taken.</p>';
                }
            }
        ?>
    </div>
</div>
<div class="container">
    <form class="needs-validation" novalidate action="./includes/register.inc.php" method="post">
        <div class="form-group">
            <label for="AccountType">Select Account Type</label>
            <select class="form-control" id="AccountType" name="AccountType" required>
                <?php
                    if (isset($_GET['AccountType'])) {
                        if ($_GET['AccountType'] == 'Customer') {
                            echo '<option selected="selected">Customer</option>
                            <option>Restaurant</option>
                            <option>Wholesaler</option>';
                        } else if ($_GET['AccountType'] == 'Restaurant') {
                            echo '<option>Customer</option>
                            <option selected="selected">Restaurant</option>
                            <option>Wholesaler</option>';
                        } else if ($_GET['AccountType'] == 'Wholesaler') {
                            echo '<option>Customer</option>
                            <option>Restaurant</option>
                            <option selected="selected">Wholesaler</option>';
                        }
                    } else {
                        echo '<option>Customer</option>
                        <option>Restaurant</option>
                        <option>Wholesaler</option>';
                    }
                ?>
            </select>
            <div class="invalid-feedback">
                Please choose an account type.
            </div>
        </div>
        <div class="form-group">
            <label for="Email Address">Email address</label>
            <input type="email" class="form-control" id="Email Address" name="EmailAddress" aria-describedby="emailHelp" placeholder="Enter email"
                <?php
                    if (isset($_GET['EmailAddress'])) {
                        echo 'value="'.$_GET['EmailAddress'].'"';
                    }
                ?>
                required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="invalid-feedback">
                Please enter an email address.
            </div>
        </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" required>
            <div class="invalid-feedback">
                Please enter a password.
            </div>
        </div>
        <div class="form-group">
            <label for="Password Repeat">Repeat Password</label>
            <input type="password" class="form-control" id="Password Repeat" name="PasswordRepeat" placeholder="Repeat Password" required>
            <div class="invalid-feedback">
                Please confirm your password.
            </div>
        </div>
        <div class="form-group">
            <label for="Name">Name</label>
            <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter Full Name"
                   <?php
                   if (isset($_GET['Name'])) {
                       echo 'value="'.$_GET['Name'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a name.
            </div>
        </div>
        <div class="form-group">
            <label for="PhoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" maxlength="10" minlength="10" placeholder="Enter Phone Number"
                   <?php
                   if (isset($_GET['PhoneNumber'])) {
                       echo 'value="'.$_GET['PhoneNumber'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a phone number that is 11 digits long
            </div>
        </div>
        <div class="form-group">
            <label for="Street">Street</label>
            <input type="text" class="form-control" id="Street" name="Street" placeholder="Enter Street"
                   <?php
                   if (isset($_GET['Street'])) {
                       echo 'value="'.$_GET['Street'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a street.
            </div>
        </div>
        <div class="form-group">
            <label for="HouseNumber">House Number</label>
            <input type="text" class="form-control" id="HouseNumber" name="HouseNumber" placeholder="Enter House Number"
                   <?php
                   if (isset($_GET['HouseNumber'])) {
                       echo 'value="'.$_GET['HouseNumber'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a house number.
            </div>
        </div>
        <div class="form-group">
            <label for="ApartmentNumber">Apartment Number</label>
            <input type="text" class="form-control" id="ApartmentNumber" name="ApartmentNumber" placeholder="Enter Apartment Number (if applicable)"
                <?php
                if (isset($_GET['ApartmentNumber'])) {
                    echo 'value="'.$_GET['ApartmentNumber'].'"';
                }
                ?>
            >
        </div>
        <div class="form-group">
            <label for="PostalCode">Postal Code</label>
            <input type="text" class="form-control" id="PostalCode" name="PostalCode" placeholder="Enter Postal Code"
                   <?php
                   if (isset($_GET['PostalCode'])) {
                       echo 'value="'.$_GET['PostalCode'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a postal code.
            </div>
        </div>
        <div class="form-group">
            <label for="Province">Select Province</label>
            <select class="form-control" id="Province" name="Province" required>
                <?php
                if (isset($_GET['Province'])) {
                    switch($_GET['Province']) {
                        case 'AB':
                            echo '<option selected="selected">AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'BC':
                            echo '<option>AB</option>
                                <option selected="selected">BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'SK':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option selected="selected">SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'MB':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option selected="selected">MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'ON':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option selected="selected">ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'QC':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option selected="selected">QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'NL':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option selected="selected">NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'NS':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option selected="selected">NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'PE':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option selected="selected">PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'NB':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option selected="selected">NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'NT':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option selected="selected">NT</option>
                                <option>YT</option>
                                <option>NU</option>';
                            break;
                        case 'YT':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option selected="selected">YT</option>
                                <option>NU</option>';
                            break;
                        case 'NU':
                            echo '<option>AB</option>
                                <option>BC</option>
                                <option>SK</option>
                                <option>MB</option>
                                <option>ON</option>
                                <option>QC</option>
                                <option>NL</option>
                                <option>NS</option>
                                <option>PE</option>
                                <option>NB</option>
                                <option>NT</option>
                                <option>YT</option>
                                <option selected="selected">NU</option>';
                            break;
                    }
                } else {
                    echo '<option>AB</option>
                    <option>BC</option>
                    <option>SK</option>
                    <option>MB</option>
                    <option>ON</option>
                    <option>QC</option>
                    <option>NL</option>
                    <option>NS</option>
                    <option>PE</option>
                    <option>NB</option>
                    <option>NT</option>
                    <option>YT</option>
                    <option>NU</option>';
                }
                ?>
            </select>
            <div class="invalid-feedback">
                Please choose a province.
            </div>
        </div>
        <div class="form-group">
            <label for="City">City</label>
            <input type="text" class="form-control" id="City" name="City" placeholder="Enter City"
                   <?php
                   if (isset($_GET['City'])) {
                       echo 'value="'.$_GET['City'].'"';
                   }
                   ?>
                   required>
            <div class="invalid-feedback">
                Please enter a city.
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="register-submit">Register</button>
    </form>
</div>

<script>
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
