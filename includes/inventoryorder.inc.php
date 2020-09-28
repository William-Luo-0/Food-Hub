<?php
if (isset($_GET["ID"])) {
    // echo '<a class="btn btn-warning btn-lg mt-3" href="../profile.php">Go Back</a>';
    $sql = "SELECT restaurant.Name AS RestaurantName,
                restaurant.PhoneNumber,
                restaurant.EmailAddress,
                wholesaler.Name AS WholesalerName,
                wholesaler.UID,
                address.Street,
                address.HouseNumber,
                address.ApartmentNumber,
                address.PostalCode,
                postalcode.Province,
                postalcode.City,
                inventoryorder.OID,
                inventoryorder.OrderDate,
                inventoryorder.FulfilledDate,
                orderduration.OrderDuration
            FROM inventoryorder
            INNER JOIN orderduration ON inventoryorder.OrderDate=orderduration.OrderDate AND inventoryorder.FulfilledDate=orderduration.FulfilledDate
            INNER JOIN restaurant ON restaurant.UID=inventoryorder.RestaurantUID
            INNER JOIN wholesaler ON wholesaler.UID=inventoryorder.WholesalerUID 
            INNER JOIN address ON restaurant.AID=address.AID
            INNER JOIN postalcode ON address.PostalCode=postalcode.PostalCode
            WHERE inventoryorder.OID=? AND inventoryorder.";
    $UID = 0;
    $OrderDate = 0;
    $isFulfilled = true;
    if ($_SESSION["AccountType"] === "Wholesaler") {
        $sql .= "WholesalerUID=?";
    } else if ($_SESSION["AccountType"] === "Restaurant") {
        $sql .= "RestaurantUID=?";
    }
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./profile.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $_GET["ID"], $_SESSION["UID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($results);
        $UID = $result["UID"];
        $OrderDate = $result["OrderDate"];
        echo '<div class="container card mt-4">
                    <div class="order-template">
                        <h1 style="text-align: center;">Order ID: '.$result["OID"].'</h1>
                        <h3 style="text-align: center; text: #ffffff;"><a class="plain-anchor" href="../wholesaler.php?ID='.$result["UID"].'">Wholesaler: '.$result["WholesalerName"].'</a></h3>
                        <p style="text-align: center;">Order Date: '.$result["OrderDate"].'</p>
                        <p style="text-align: center;">Fulfilled Date: ';
        if ($result["FulfilledDate"] === "1000-01-01 00:00:00") {
            $isFulfilled = false;
            echo 'In Progress</p>';
        } else {
            echo ''.$result["FulfilledDate"].'</p>';
        }
        $timeFormat = "";
        if ($result["OrderDuration"] < 0) {
            $timeFormat = "-";
        } else {
            $hours = floor($result["OrderDuration"] / 3600);
            $mins = floor($result["OrderDuration"] / 60 % 60);
            $secs = floor($result["OrderDuration"] % 60);
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        }
        echo '<p style="text-align: center;">Order Duration: '.$timeFormat.'</p>
                        <div class="row">
                            <h3>Restaurant Information</h3>
                            <hr class="my-4">
                        </div>
                        <div class="row">
                            <div class="col"><p class="lead">Name: '.$result["RestaurantName"].'</p></div>
                        </div>
                        <div class="row">
                            <div class="col"><p class="lead">Phone Number: '.preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $result["PhoneNumber"]).'</p></div>
                        </div>
                        <div class="row">
                            <div class="col"><p class="lead">Email Address: '.$result["EmailAddress"].'</p></div>
                        </div>
                        <div class="row">
                            <div class="col"><p class="lead">Address: '.$result["HouseNumber"].'-'.$result["Street"].', '.$result["City"].', '.$result["Province"].', '.$result["PostalCode"].'</div>
                            
                        </div>
                        <div class="row">
                            <div class="col"><p class="lead">Apartment Number: '.$result["ApartmentNumber"].'</div>
                        </div>
                        <div class="row pt-4">
                            <h3>Ordered Items</h3>
                            <hr class="my-4">
                        </div>
                        <table class="table" id="order-items">
                            <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                            </tr>
                            </thead>
                            <tbody>';
        $sql = "SELECT inventoryorderitems.Amount, inventoryitem.Name, inventoryitem.Cost
                    FROM inventoryorderitems 
                    INNER JOIN inventoryitem ON inventoryorderitems.UID=inventoryitem.UID AND inventoryorderitems.IID=inventoryitem.IID 
                    WHERE OID=?";
        $stmt = mysqli_stmt_init($mysqli);
        $totalprice = 0.00;
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./profile.php?error=sqlerror2");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $_GET["ID"]);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            $orderNumber = 1;
            while ($rows = mysqli_fetch_assoc($results)) {
                echo'
                    <tr>
                        <th scape="row">' . $orderNumber . '</th>
                        <td>' . $rows["Name"] . '</td>
                        <td>' . $rows["Amount"] . '</td>
                        <td>' . $rows["Cost"] . '</td>
                    </tr>
                    ';
                $orderNumber += 1;
                $totalprice += $rows["Cost"] * $rows["Amount"];
            };
        }
        settype($totalprice, "double");
        echo '</tbody></table>
                  <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3"><p style="text-align: center;">Total Cost: '.number_format((float)$totalprice, 2, '.', '').'</p></div>
                  </div>';
        if ($_SESSION["AccountType"] == "Wholesaler" && $_SESSION["UID"] == $UID && !$isFulfilled) {
            echo '<div class="py-4">
                        <form action="includes/fulfillorder.inc.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="Type" value="Wholesaler" hidden>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="OrderID" value="' . $_GET["ID"] . '" hidden>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="OrderDate" value="' . $OrderDate . '" hidden>
                            </div>
                            <button type="submit" class="btn btn-success btn-md btn-block p-3" name="fulfill-submit">Fulfill Order</button>
                        </form>
                      </div>';
        }
        echo '</div></div>';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
} else {
    header("Location: ../index.php");
    exit();
}
?>