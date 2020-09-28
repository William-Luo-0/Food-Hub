<?php
include "database.php";
require "header.php";
?>
<div class="container">
    <div class="jumbotron"><div class="row">
            <div class="col-md-10">
                <h1 class="display-4">Edit Account Information</h1>
            </div>
            <div class="col-md-2">
                <a class="btn btn-lg btn-warning my-4" href="profile.php">Go back</a>
            </div>
        </div>
        <p class="lead">Please fill in the information below to make changes to your account information.</p>
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
    <form class="needs-validation" novalidate action="./includes/profile.edit.inc.php" method="post">
        <div class="form-group">
            <label for="AccountType">Account Type</label>
            <input type="text" class="form-control" id="AccountType" name="AccountType" readonly
                <?php
                if (isset($_GET['AccountType'])) {
                    echo 'value="'.$_GET['AccountType'].'"';
                } else if (isset($_SESSION['AccountType'])) {
                    echo 'value="'.$_SESSION['AccountType'].'"';
                }
                ?>
               required
            >
        </div>
        <div class="form-group">
            <label for="Email Address">Email address</label>
            <input type="email" class="form-control" id="Email Address" name="EmailAddress" aria-describedby="emailHelp" placeholder="Enter email"
                <?php
                if (isset($_GET['EmailAddress'])) {
                    echo 'value="'.$_GET['EmailAddress'].'"';
                } else if (isset($_SESSION['EmailAddress'])) {
                    echo 'value="'.$_SESSION['EmailAddress'].'"';
                }
                ?>
                   required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <div class="invalid-feedback">
                Please enter an email address.
            </div>
        </div>
        <div class="form-group">
            <label for="Password">New Password</label>
            <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
            <div class="invalid-feedback">
                Please enter a password.
            </div>
        </div>
        <div class="form-group">
            <label for="Password Repeat">Repeat New Password</label>
            <input type="password" class="form-control" id="Password Repeat" name="PasswordRepeat" placeholder="Repeat Password">
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
                } else if (isset($_SESSION['Name'])) {
                    echo 'value="'.$_SESSION['Name'].'"';
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
                } else if (isset($_SESSION['PhoneNumber'])) {
                    echo 'value="'.$_SESSION['PhoneNumber'].'"';
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
                } else if (isset($_SESSION['Street'])) {
                    echo 'value="'.$_SESSION['Street'].'"';
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
                } else if (isset($_SESSION['HouseNumber'])) {
                    echo 'value="'.$_SESSION['HouseNumber'].'"';
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
                } else if (isset($_SESSION['ApartmentNumber'])) {
                    echo 'value="'.$_SESSION['ApartmentNumber'].'"';
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
                } if (isset($_SESSION['PostalCode'])) {
                    echo 'value="'.$_SESSION['PostalCode'].'"';
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
                } else if (isset($_SESSION['Province'])) {
                    switch ($_SESSION['Province']) {
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
                } else if (isset($_SESSION['City'])) {
                    echo 'value="'.$_SESSION['City'].'"';
                }
                ?>
                   required>
            <div class="invalid-feedback">
                Please enter a city.
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="edit-submit">Edit</button>
    </form>
    <a class="btn btn-block btn-warning" href="./profile.php" style="font-size: 1.25rem; color: #ffffff; margin-bottom: 2.5rem">Go back</a>
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
