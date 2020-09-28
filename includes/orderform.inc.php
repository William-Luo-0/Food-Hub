<?php
    if (isset($_GET["ID"]) && isset($_GET["Type"])) {
        echo '<div class="container">
                <form action="./includes/makeorder.inc.php" method="post">
                    <div class="form-group">
                        <input type="number" class="form-control" name="ID" value="'.$_GET["ID"].'" hidden>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="Type" value="'.$_GET["Type"].'" hidden>
                    </div>';
        if ($_SESSION["AccountType"] == "Customer" && $_GET["Type"] == "Restaurant") {
            $sql = "SELECT Name FROM restaurant WHERE UID=?";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                $result = mysqli_fetch_assoc($results);
                echo '<div class="form-group">
                            <label for="Name">Restaurant Name</label>
                            <input type="text" class="form-control" name="Name" value="' . $result["Name"] . '" readonly>
                        </div>
                        <div class="form-row">';
                $sql = "SELECT * FROM menuitem WHERE UID=?";
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    $options = "";
                    while ($rows = mysqli_fetch_assoc($results)) {
                        $options .= '<option value="'.$rows["IID"].'">'.$rows["Name"].' - $'.$rows["Price"].' - '.$rows["FoodType"].'</option>';
                    }
                    for ($index = 1; $index < 9; $index++) {
                        echo '
                        <div class="form-group col-md-10">
                            <label for="Item'.$index.'">Item '.$index.': </label>
                            <select class="form-control" name="Item'.$index.'">
                                <option selected value="-1">Select an item</option>
                                '.$options.'
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="Name">Qty: </label>
                            <input type="number" class="form-control" name="Qty'.$index.'">
                        </div>';
                    }
                    echo '</div>
                          <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="order-submit">Place Order</button>
                          </form></div>';
                }
            }
        } else if ($_SESSION["AccountType"] == "Restaurant" && $_GET["Type"] == "Wholesaler") {
            $sql = "SELECT Name FROM wholesaler WHERE UID=?";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                $result = mysqli_fetch_assoc($results);
                echo '<div class="form-group">
                            <label for="Name">Wholesaler Name</label>
                            <input type="text" class="form-control" name="Name" value="' . $result["Name"] . '" readonly>
                        </div>
                        <div class="form-row">';
                $sql = "SELECT * FROM inventoryitem WHERE UID=?";
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    $options = "";
                    while ($rows = mysqli_fetch_assoc($results)) {
                        $options .= '<option value="'.$rows["IID"].'">'.$rows["Name"].' - $'.$rows["Cost"].' - Amount: '.$rows["Amount"].'</option>';
                    }
                    for ($index = 1; $index < 9; $index++) {
                        echo '
                        <div class="form-group col-md-10">
                            <label for="Item'.$index.'">Item '.$index.': </label>
                            <select class="form-control" name="Item'.$index.'">
                                <option selected value="-1">Select an item</option>
                                '.$options.'
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="Name">Qty: </label>
                            <input type="number" class="form-control" name="Qty'.$index.'">
                        </div>';
                    }
                    echo '</div>
                          <button type="submit" class="btn btn-primary btn-lg btn-block my-4" name="order-submit">Place Order</button>
                          </form></div>';
                }
            }
        } else {
            header("Location: ../index.php");
            exit();
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    } else {
        header("Location: ../index.php");
        exit();
    }
?>