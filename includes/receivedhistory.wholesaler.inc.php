<?php
    $redirect = "order.php";
    if (strpos($_SERVER['REQUEST_URI'], 'profile.php') == true) {
        $redirect = "profile.php";
    }
    $sql= "SELECT count(inventoryorder.OID) FROM inventoryorder WHERE WholesalerUID=?";
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

    $sql = "SELECT restaurant.Name,
                inventoryorder.OID,
                inventoryorder.OrderDate,
                inventoryorder.FulfilledDate,
                orderduration.OrderDuration
            FROM inventoryorder
            INNER JOIN orderduration ON inventoryorder.OrderDate=orderduration.OrderDate AND inventoryorder.FulfilledDate=orderduration.FulfilledDate
            INNER JOIN restaurant ON restaurant.UID=inventoryorder.RestaurantUID
            WHERE inventoryorder.WholesalerUID=? ";
    if (isset($_GET["orderby"]) && isset($_GET["order"])) {
        echo '<table class="table" id="order-history">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>';
        if ($_GET["orderby"] == 'OID') {
            if ($_GET["order"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OID&order=DESC#order-history">ID <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OID DESC";
            } else if ($_GET["order"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OID&order=ASC#order-history">ID <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OID ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?orderby=OID&order=DESC#order-history">ID</a></th>';
        }
        if ($_GET["orderby"] == 'Name') {
            if ($_GET["order"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=Name&order=DESC#order-history">Customer <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY Name DESC";
            } else if ($_GET["order"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=Name&order=ASC#order-history">Customer <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY Name ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?orderby=Name&order=DESC#order-history">Customer</a></th>';
        }
        if ($_GET["orderby"] == 'OrderDate') {
            if ($_GET["order"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDate&order=DESC#order-history">Order Date <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OrderDate DESC";
            } else if ($_GET["order"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDate&order=ASC#order-history">Order Date <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OrderDate ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDate&order=DESC#order-history">Order Date</a></th>';
        }
        if ($_GET["orderby"] == 'FulfilledDate') {
            if ($_GET["order"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=FulfilledDate&order=DESC#order-history">Fulfilled Date <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY FulfilledDate DESC";
            } else if ($_GET["order"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=FulfilledDate&order=ASC#order-history">Fulfilled Date <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY FulfilledDate ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?orderby=FulfilledDate&order=DESC#order-history">Fulfilled Date</a></th>';
        }
        if ($_GET["orderby"] == 'OrderDuration') {
            if ($_GET["order"] == 'ASC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDuration&order=DESC#order-history">Order Duration <i class="fas fa-sort-up"></i></a></th>';
                $sql .= "ORDER BY OrderDuration DESC";
            } else if ($_GET["order"] == 'DESC') {
                echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDuration&order=ASC#order-history">Order Duration <i class="fas fa-sort-down"></i></a></th>';
                $sql .= "ORDER BY OrderDuration ASC";
            }
        } else {
            echo '<th scope="col"><a href="'.$redirect.'?orderby=OrderDuration&order=DESC#order-history">Order Duration</a></th>';
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
                    <th scope="col"><a href="'.$redirect.'?orderby=OID&order=DESC#order-history">ID</a></th>
                    <th scope="col"><a href="'.$redirect.'?orderby=Name&order=DESC#order-history">Customer</a></th>
                    <th scope="col"><a href="'.$redirect.'?orderby=OrderDate&order=DESC#order-history">Order Date</a></th>
                    <th scope="col"><a href="'.$redirect.'?orderby=FulfilledDate&order=DESC#order-history">Fulfilled Date</a></th>
                    <th scope="col"><a href="'.$redirect.'?orderby=OrderDuration&order=DESC#order-history">Order Duration</a></th>
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
                    <td><a class="btn btn-primary" href="../inventoryorder.php?ID=' . $rows["OID"] . '">View Order</a></td>
                </tr>
                ';
            $orderNumber += 1;
        };
    }
    echo '</tbody></table>';
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
?>