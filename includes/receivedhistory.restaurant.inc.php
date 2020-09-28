<?php
    $redirect = "order.php";
    if (strpos($_SERVER['REQUEST_URI'], 'profile.php') == true) {
        $redirect = "profile.php";
    }
    $sql= "SELECT count(foodorder.OID) FROM foodorder WHERE RestaurantUID=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./".$redirect."?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["UID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_row($results);
        echo '<p>Total Received Orders: '.$result[0].'</p>';
    }

    $sql = "SELECT customer.Name,
                        foodorder.OID,
                        foodorder.OrderDate,
                        foodOrder.FulfilledDate,
                        orderduration.OrderDuration
                    FROM foodorder
                    INNER JOIN orderduration ON foodorder.OrderDate=orderduration.OrderDate AND foodOrder.FulfilledDate=orderduration.FulfilledDate
                    INNER JOIN customer ON customer.UID=foodorder.CustomerUID
                    WHERE foodorder.RestaurantUID=? ";
    if (isset($_GET["Rorderby"]) && isset($_GET["Rorder"])) {
        echo '<table class="table" id="order-history2">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>';
        if ($_GET["Rorderby"] == 'OID') {
            if ($_GET["Rorder"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OID&Rorder=DESC#order-history2">ID <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OID DESC";
            } else if ($_GET["Rorder"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OID&Rorder=ASC#order-history2">ID <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OID ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OID&Rorder=DESC#order-history2">ID</a></th>';
        }
        if ($_GET["Rorderby"] == 'Name') {
            if ($_GET["Rorder"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=Name&Rorder=DESC#order-history2">Customer <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY Name DESC";
            } else if ($_GET["Rorder"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=Name&Rorder=ASC#order-history2">Customer <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY Name ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?Rorderby=Name&Rorder=DESC#order-history2">Customer</a></th>';
        }
        if ($_GET["Rorderby"] == 'OrderDate') {
            if ($_GET["Rorder"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDate&Rorder=DESC#order-history2">Order Date <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OrderDate DESC";
            } else if ($_GET["Rorder"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDate&Rorder=ASC#order-history2">Order Date <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OrderDate ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDate&Rorder=DESC#order-history2">Order Date</a></th>';
        }
        if ($_GET["Rorderby"] == 'FulfilledDate') {
            if ($_GET["Rorder"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=FulfilledDate&Rorder=DESC#order-history2">Fulfilled Date <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY FulfilledDate DESC";
            } else if ($_GET["Rorder"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=FulfilledDate&Rorder=ASC#order-history2">Fulfilled Date <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY FulfilledDate ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?Rorderby=FulfilledDate&Rorder=DESC#order-history2">Fulfilled Date</a></th>';
        }
        if ($_GET["Rorderby"] == 'OrderDuration') {
            if ($_GET["Rorder"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDuration&Rorder=DESC#order-history2">Order Duration <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OrderDuration DESC";
            } else if ($_GET["Rorder"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDuration&Rorder=ASC#order-history2">Order Duration <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OrderDuration ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?Rorderby=OrderDuration&Rorder=DESC#order-history2">Order Duration</a></th>';
        }
        echo '<th scope="col"></th>
            </tr>
            </thead>
            <tbody>';
    } else {
        echo '<table class="table" id="order-history2">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col"><a href="'.$redirect.'?Rorderby=OID&Rorder=DESC#order-history2">ID</a></th>
                <th scope="col"><a href="'.$redirect.'?Rorderby=Name&Rorder=DESC#order-history2">Customer</a></th>
                <th scope="col"><a href="'.$redirect.'?Rorderby=OrderDate&Rorder=DESC#order-history2">Order Date</a></th>
                <th scope="col"><a href="'.$redirect.'?Rorderby=FulfilledDate&Rorder=DESC#order-history2">Fulfilled Date</a></th>
                <th scope="col"><a href="'.$redirect.'?Rorderby=OrderDuration&Rorder=DESC#order-history2">Order Duration</a></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>';
    }
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./".$redirect."?error=sqlerror2");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["UID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $orderNumber = 1;
        while ($rows = mysqli_fetch_assoc($results)) {
            $timeFormat = "";
            if ($rows["OrderDuration"] < 0) {
                $timeFormat = "-";
            } else {
                $hours = floor($rows["OrderDuration"] / 3600);
                $mins = floor($rows["OrderDuration"] / 60 % 60);
                $secs = floor($rows["OrderDuration"] % 60);
                $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            }
            $fulfilled = "";
            if ($rows["FulfilledDate"] === "1000-01-01 00:00:00") {
                $fulfilled = 'In Progress';
            } else {
                $fulfilled = $rows["FulfilledDate"];
            }
            echo'
            <tr>
                <th scape="row">' . $orderNumber . '</th>
                <td>' . $rows["OID"] . '</td>
                <td>' . $rows["Name"] . '</td>
                <td>' . $rows["OrderDate"] . '</td>
                <td>' . $fulfilled . '</td>
                <td>' . $timeFormat . '</td>
                <td><a class="btn btn-primary" href="../foodorder.php?ID=' . $rows["OID"] . '">View Order</a></td>
            </tr>
            ';
            $orderNumber += 1;
        };
    }
    echo '</tbody></table>';
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
?>