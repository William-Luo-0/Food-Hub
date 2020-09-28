
<?php
if (isset($_GET["ID"])) {
    $sql = "SELECT * FROM restaurant WHERE UID=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./restaurant.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($results);
        echo '
        <a class="btn btn-warning btn-lg mt-3" href="../restaurant.php">Go Back</a>
        <main role="main" class="container">
            <div class="starter-template">
                    <h1>'.$result["Name"].'</h1>';
        $sql = "SELECT * FROM address WHERE AID=?";
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./restaurant.php?error=sqlerror2");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $result["AID"]);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            $result2 = mysqli_fetch_assoc($results);
            $sql = "SELECT * FROM postalcode WHERE PostalCode=?";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ./restaurant.php?error=sqlerror3");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $result2["PostalCode"]);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                $result3 = mysqli_fetch_assoc($results);
                echo '<p class="lead">Phone Number: ' . preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $result["PhoneNumber"]) . '</p>
                      <p class="lead">' . $result2["HouseNumber"] . ' ' . $result2["Street"] . ', ' . $result3["Province"] . ', ' . $result3["City"] . ', ' . $result2["PostalCode"] . '</p>';
                if (isset($_SESSION["AccountType"]) && $_SESSION["AccountType"] == "Customer") {
                    echo '<a class="btn btn-outline-success" href="./orderform.php?ID='.$_GET["ID"].'&Type=Restaurant">Make an order</a>';
                }
                if (isset($_SESSION["AccountType"]) && $_SESSION["AccountType"] == "Restaurant") {
                    if (isset($_SESSION["UID"]) && $_SESSION["UID"] == $_GET["ID"]) {
                        echo '<a class="btn btn-outline-success" href="./createitem.php">Add a menu item</a>';
                    }
                }
                $address = $result2["Street"] . ', ' . $result3["Province"] . ', ' . $result3["City"] . ', ' . $result3["PostalCode"];
                echo "<div class='d-flex justify-content-center pt-3'><div id='map' style='width: 520px; height: 420px;'></div></div>
                    <script>
                    function initMap() {
                      var geocoder = new google.maps.Geocoder();
                      geocoder.geocode({'address': '".$address."'}, function(res, status) {
                          if (status === 'OK') {
                               var map = new google.maps.Map(
                                    document.getElementById('map'), {zoom: 16, center: res[0].geometry.location});
                               var marker = new google.maps.Marker({position: res[0].geometry.location, map: map});
                          } else {
                              alert('Google maps geocoder failed: ' + status);
                          }
                      });
                    }
                        </script>
                    <script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAgiw_wUVJBfwFyYAWvQlcpDLLZT8Ceapo&callback=initMap'></script>";

                echo '</div>
                </main>';
            }
        }
    }
    echo '<form class="form-inline mb-4" action="./restaurant.php?ID=' . $_GET["ID"] . '"" method="get">
                <input type="text" class="form-control" id="ID" name="ID" hidden value="'.$_GET["ID"].'">
                <div class="input-group-prepend pr-3">
                    <div class="input-group-text">Sort by price</div>
                </div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">';
    if (isset($_GET["psort"])) {
        if ($_GET["psort"] == 1) {
            echo '<label class="btn btn-info active">
                  <input type="radio" id="Ascending" name="psort" class="form-check-input" value="1" autocomplete="off" checked>';
        } else {
            echo '<label class="btn btn-info">
                  <input type="radio" id="Ascending" name="psort" class="form-check-input" value="1" autocomplete="off">';
        }
    } else {
        echo '<label class="btn btn-info">
              <input type="radio" id="Ascending" name="psort" class="form-check-input" value="1" autocomplete="off">';
    }
    echo '
                    Ascending <i class="fas fa-sort-numeric-down pl-2"></i>
                    </label>';
    if (isset($_GET["psort"])) {
        if ($_GET["psort"] == 2) {
            echo '<label class="btn btn-info active">
                  <input type="radio" id="Descending" name="psort" class="form-check-input" value="2" autocomplete="off" checked>';
        } else {
            echo '<label class="btn btn-info">
                  <input type="radio" id="Descending" name="psort" class="form-check-input" value="2" autocomplete="off">';
        }
    } else {
        echo '<label class="btn btn-info">
              <input type="radio" id="Descending" name="psort" class="form-check-input" value="2" autocomplete="off">';
    }
    echo 'Descending <i class="fas fa-sort-numeric-up pl-2"></i>
                    </label>
                </div>
                <div class="input-group px-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Min</div>
                    </div>
                    <input type="number" class="form-control" id="Min" name="Min" step=".01"';
    if (isset($_GET["Min"])) {
        echo ' value="'.$_GET["Min"].'"';
    }
        echo '></div>
                <div class="input-group pr-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Max</div>
                    </div>
                    <input type="number" class="form-control" id="Max" name="Max" step=".01"';
    if (isset($_GET["Max"])) {
        echo ' value="'.$_GET["Max"].'"';
    }
    echo '>
                </div>
                <button type="submit" class="btn btn-success" name="restaurantsortprice-submit">Sort</button>
        </form>';
    echo '<form class="form-inline mb-4" action="./restaurant.php?ID=" method="get">
                <input type="text" class="form-control" id="ID" name="ID" hidden value="'.$_GET["ID"].'">
                <div class="input-group-prepend pr-3">
                    <div class="input-group-text">Filter by type</div>
                </div>
                <div class="btn-group btn-group-toggle pr-3" data-toggle="buttons">';
    if (isset($_GET["tsort"])) {
        if ($_GET["tsort"] == 1) {
            echo '<label class="btn btn-info active">
                    <input type="radio" name="tsort" class="form-check-input" value="1" autocomplete="off" checked>
                    Food <i class="fas fa-hamburger pl-2"></i>
                    </label>';
        } else {
            echo '<label class="btn btn-info">
                    <input type="radio" name="tsort" class="form-check-input" value="1" autocomplete="off">
                    Food <i class="fas fa-hamburger pl-2"></i>
                    </label>';
        }
        if ($_GET["tsort"] == 2) {
            echo '<label class="btn btn-info active">
                    <input type="radio" name="tsort" class="form-check-input" value="2" autocomplete="off" checked>
                    Dessert <i class="fas fa-ice-cream pl-2"></i>
                    </label>';
        } else {
            echo '<label class="btn btn-info">
                    <input type="radio" name="tsort" class="form-check-input" value="2" autocomplete="off">
                    Dessert <i class="fas fa-ice-cream pl-2"></i>
                    </label>';
        }
        if ($_GET["tsort"] == 3) {
            echo '<label class="btn btn-info active">
                    <input type="radio" name="tsort" class="form-check-input" value="3" autocomplete="off" checked>
                    Drink <i class="fas fa-wine-glass pl-2"></i>
                    </label>';
        } else {
            echo '<label class="btn btn-info">
                    <input type="radio" name="tsort" class="form-check-input" value="3" autocomplete="off">
                    Drink <i class="fas fa-wine-glass pl-2"></i>
                    </label>';
        }
        if ($_GET["tsort"] == 4) {
            echo '<label class="btn btn-info active">
                    <input type="radio" name="tsort" class="form-check-input" value="4" autocomplete="off" checked>
                    Everything <i class="fas fa-utensils pl-2"></i>
                    </label>';
        } else {
            echo '<label class="btn btn-info">
                    <input type="radio" name="tsort" class="form-check-input" value="4" autocomplete="off">
                    Everything <i class="fas fa-utensils pl-2"></i>
                    </label>';
        }
    } else {
        echo '<label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="1" autocomplete="off">
            Food <i class="fas fa-hamburger pl-2"></i>
            </label>
            <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="2" autocomplete="off">
            Dessert <i class="fas fa-ice-cream pl-2"></i>
            </label>
            <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="3" autocomplete="off">
            Drink <i class="fas fa-wine-glass pl-2"></i>
            </label>
            <label class="btn btn-info">
            <input type="radio" name="tsort" class="form-check-input" value="4" autocomplete="off">
            Everything <i class="fas fa-utensils pl-2"></i>
            </label>';
    }
    echo        '</div>
                <button type="submit" class="btn btn-success" name="restaurantsorttype-submit">Sort</button>
        </form>
        <a class="btn btn-outline-success mb-4 btn-block" href="./restaurant.php?ID=' . $_GET["ID"] . '">Show All</a>';
    $sql = "SELECT * FROM menuitem WHERE UID=?";
    if (isset($_GET["restaurantsortprice-submit"])) {
        if (isset($_GET["Min"])) {
            if (is_numeric($_GET["Min"])) {
                $sql .= " AND Price>=" . $_GET["Min"];
            }
        }
        if (isset($_GET["Max"])) {
            if (is_numeric($_GET["Max"])) {
                $sql .= " AND Price<=" . $_GET["Max"];
            }
        }
        if (isset($_GET["psort"])) {
            if ($_GET["psort"] == 1) {
                $sql .= " ORDER BY Price ASC";
            }
            if ($_GET["psort"] == 2) {
                $sql .= " ORDER BY Price DESC";
            }
        }
    } else if (isset($_GET["restaurantsorttype-submit"])) {
        if (isset($_GET["tsort"])) {
            if ($_GET["tsort"] == 1) {
                $sql .= ' AND FoodType="Food"';
            }
            if ($_GET["tsort"] == 2) {
                $sql .= ' AND FoodType="Dessert"';
            }
            if ($_GET["tsort"] == 3) {
                $sql .= ' AND FoodType="Drink"';
            }
        }
    }
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./restaurant.php?error=sqlerror4");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $first = false;
        $counter = 0;
        while ($rows = mysqli_fetch_assoc($results)) {
            if (!$first) {
                echo '<div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="card text-center">';

                if (isset($_SESSION["UID"]) && $_GET["ID"] == $_SESSION["UID"] && $_SESSION['AccountType'] == "Restaurant") {
                  echo '
                        <div class="card-header pt-0">
                        <form class="mb-4" action = "./includes/deletemenuitem.inc.php" method = "post" >
                          <input type = "number" class="form-control" name = "ID" value = "'.$rows["IID"].'" hidden >
                          <button type="submit" name="delete-submit" class="far fa-trash-alt p-2 mr-1 mt-1 trashcan"></button>
                        </form >';
                } else {
                  echo '<div class="card-header">';
                }

                echo ''.$rows["FoodType"].'
                                </div>
                                <div class ="card-body">
                                    <h5 class="card-title">' . $rows["Name"] . '</h5>
                                    <p class="card-text">$'.$rows["Price"].'</p>
                                    <a href="menuitem.php?UID=' . $rows["UID"] . '&IID='.$rows["IID"].'" class="btn btn-primary">More Info</a>
                                </div>
                            </div>
                        </div>';
                $first = true;
                $counter += 1;
            } else if ($counter === 3) {
                echo '</div><div class="row mb-4">
                                <div class="col-sm-4">
                                <div class="card text-center">';

                    if (isset($_SESSION["UID"]) && $_GET["ID"] == $_SESSION["UID"] && $_SESSION['AccountType'] == "Restaurant") {
                      echo '
                            <div class="card-header" style="padding-top:0px;">
                              <form class="mb-4" action = "./includes/deletemenuitem.inc.php" method = "post" >
                                <input type = "number" class="form-control" name = "ID" value = "'.$rows["IID"].'" hidden >
                                <button type="submit" name="delete-submit" class="far fa-trash-alt p-2 mr-1 mt-1 trashcan"></button>
                              </form >';
                    } else {
                      echo '<div class="card-header">';
                    }

                    echo ''.$rows["FoodType"].'
                                        </div>
                                        <div class ="card-body">
                                            <h5 class="card-title">' . $rows["Name"] . '</h5>
                                            <p class="card-text">$'.$rows["Price"].'</p>
                                            <a href="menuitem.php?UID=' . $rows["UID"] . '&IID='.$rows["IID"].'" class="btn btn-primary">More Info</a>
                                        </div>
                                    </div>
                                </div>';
                $counter = 1;
            } else {
                echo '<div class="col-sm-4">
                <div class="card text-center">';

                  if (isset($_SESSION["UID"]) && $_GET["ID"] == $_SESSION["UID"] && $_SESSION['AccountType'] == "Restaurant") {
                    echo '
                          <div class="card-header" style="padding-top:0px;">
                            <form class="mb-4" action = "./includes/deletemenuitem.inc.php" method = "post" >
                              <input type = "number" class="form-control" name = "ID" value = "'.$rows["IID"].'" hidden >
                              <button type="submit" name="delete-submit" class="far fa-trash-alt p-2 mr-1 mt-1 trashcan"></button>
                            </form >';
                  } else {
                    echo '<div class="card-header">';
                  }

                      echo ''.$rows["FoodType"].'
                                </div>
                                <div class ="card-body">
                                    <h5 class="card-title">' . $rows["Name"] . '</h5>
                                    <p class="card-text">$'.$rows["Price"].'</p>
                                    <a href="menuitem.php?UID=' . $rows["UID"] . '&IID='.$rows["IID"].'" class="btn btn-primary">More Info</a>
                                </div>
                            </div>
                        </div>';
                $counter += 1;
            }
        }
        echo '</div>';
    }
} else {
    $sql = "SELECT UID, Name FROM restaurant";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./restaurant.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $first = false;
        $counter = 0;
        while ($rows = mysqli_fetch_assoc($results)) {
            if (!$first) {


                echo '<div class="row mb-4">
                                <div class="col-sm-4">
                                    <div class="card text-center">
                                        <div class ="card-body">
                                            <h5 class="card-title">' . $rows["Name"] . '</h5>
                                            <a href="restaurant.php?ID=' . $rows["UID"] . '" class="btn btn-primary">More Info</a>
                                        </div>
                                    </div>
                                </div>';
                $first = true;
                $counter += 1;
            } else if ($counter === 3) {
                echo '</div><div class="row mb-4">
                                <div class="col-sm-4">
                                    <div class="card text-center">
                                        <div class ="card-body">
                                            <h5 class="card-title">' . $rows["Name"] . '</h5>
                                            <a href="restaurant.php?ID=' . $rows["UID"] . '" class="btn btn-primary">More Info</a>
                                        </div>
                                    </div>
                                </div>';
                $counter = 1;
            } else {
                echo '<div class="col-sm-4">
                                <div class="card text-center">
                                    <div class ="card-body">
                                        <h5 class="card-title">' . $rows["Name"] . '</h5>
                                        <a href="restaurant.php?ID=' . $rows["UID"] . '" class="btn btn-primary">More Info</a>
                                    </div>
                                </div>
                            </div>';
                $counter += 1;
            }
        }
        echo '</div>';
    }
}
mysqli_stmt_close($stmt);
mysqli_close($mysqli);
?>
