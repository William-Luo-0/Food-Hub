<?php

    include "../database.php";

    function autoRestockAll($restaurantUID) {
        global $mysqli;

        $res = $mysqli->query("SELECT autorestock.*, COALESCE(restaurantstorage.Amount, 0) as CurrentStock, 
                (SELECT COALESCE(SUM(inventoryorderitems.Amount), 0) FROM inventoryorder
                       LEFT JOIN inventoryorderitems ON inventoryorder.OID = inventoryorderitems.OID
                       WHERE inventoryorder.FulfilledDate < \"1970-01-01 00:00:01\" AND inventoryorder.RestaurantUID = autorestock.UID AND inventoryorderitems.UID = autorestock.WholesalerUID AND inventoryorderitems.IID = autorestock.IID) AS onOrder
			FROM `autorestock` 
            LEFT JOIN restaurantstorage ON restaurantstorage.UID = autorestock.UID AND restaurantstorage.INID = autorestock.INID
            WHERE autorestock.UID = '$restaurantUID'");

        $toOrder = [];

        while ($row = $res->fetch_object()) {
            if ($row->Threshold > $row->CurrentStock + $row->onOrder) {
                if (!isset($toOrder[$row->WholesalerUID]))
                    $toOrder[$row->WholesalerUID] = [];
                $toOrder[$row->WholesalerUID][] = $row;
            }
        }

        date_default_timezone_set('America/Vancouver');
        $OrderDate = new DateTime(date('Y-m-d H:i:s'));
        $FulfilledDate = "1000-01-01 00:00:00";

        foreach ($toOrder as $wholesalerUID => $items) {
            $datestring = $OrderDate->format("Y-m-d H:i:s");
            $mysqli->query("INSERT INTO orderduration (OrderDate) VALUES ('$datestring')");
            $mysqli->query("INSERT INTO inventoryorder (RestaurantUID, WholesalerUID, OrderDate, FulfilledDate) VALUES ('$restaurantUID', '$wholesalerUID', '$datestring', '$FulfilledDate')");
            $oid = $mysqli->insert_id;

            foreach ($items as $k => $item) {
                $mysqli->query("INSERT INTO inventoryorderitems (OID, UID, IID, Amount) VALUES ('$oid', '$wholesalerUID', '$item->IID', '" . max($item->Amount, $item->Threshold - $item->CurrentStock + $item->onOrder) . "')");
            }

            date_add($OrderDate, DateInterval::createFromDateString('1 second')); // keep orderduration key unique
        }
    }

?>

