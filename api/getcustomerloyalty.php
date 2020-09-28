<?php

    header("Content-Type: application/json");

    session_start();

    include "../database.php";

    $uid = $_SESSION['UID'];

    $type = $_POST['type'] ?? 3;
    $min = $_POST['min'] != "" ? $_POST['min'] : 0;
    $max = $_POST['max'] != "" ? $_POST['max'] : 1000000;

    $typetext = array("Food", "Dessert", "Drink", "%")[$type];

    $items = $mysqli->query("SELECT * FROM customer as c
        WHERE NOT EXISTS (
            SELECT m.IID FROM menuitem as m WHERE UID = '$uid' AND FoodType LIKE '$typetext' AND Price >= '$min' AND Price <= '$max' AND m.IID NOT IN
            (SELECT i.IID FROM foodorder f, foodorderitems i WHERE f.OID = i.OID AND f.CustomerUID = c.UID AND i.UID = m.UID AND i.IID = m.IID)
        )");

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

