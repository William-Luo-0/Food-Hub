<?php

    header("Content-Type: application/json");

    session_start();

    include "../database.php";

    $uid = $_SESSION['UID'];

    $type = $_POST['type'] ?? 3;
    $typetext = array("Food", "Dessert", "Drink", "%")[$type];

    $grouping = $_POST['grouping'] ?? 0;
    $groupingquery = array("GROUP BY c.Name", "GROUP BY m.Name", "GROUP BY m.FoodType")[$grouping];
    $headerItem = array("c.Name", "m.Name", "m.FoodType")[$grouping];

    $items = $mysqli->query("SELECT $headerItem as headerText, SUM(Amount) as numItems, SUM(Amount * Price) as totalValue FROM customer as c
        LEFT JOIN foodorder f ON f.CustomerUID = c.UID
        LEFT JOIN foodorderitems i ON f.OID = i.OID
        LEFT JOIN menuitem m ON i.UID = m.UID AND i.IID = m.IID
        WHERE m.FoodType LIKE '$typetext' AND f.RestaurantUID = '$uid'
        " . $groupingquery);

    if (!$items) {
        http_response_code(500);
        echo json_encode(["errorMessage" => "There was an error getting the results"]);
        exit();
    }

    // else

    http_response_code(200);
    $results = [];
    while ($row = $items->fetch_assoc()) {
        $results[] = $row;
    }
    echo json_encode($results);


?>

