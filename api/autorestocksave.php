<?php

    header("Content-Type: application/json");

    session_start();

    include "../database.php";

    // make sure required fields present

    $uid = $_SESSION['UID'];
    $auid = $_POST['auid'] ?? $mysqli->query("SELECT max(AUID) as maxkey FROM autorestock WHERE UID = '$uid'")->fetch_object()->maxkey + 1;
    $wholesaleruid = $_POST['wholesaleruid'] ?? null;
    $iid = $_POST['iid'] ?? null;
    $inid = $_POST['inid'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $threshold = $_POST['threshold'] ?? null;

    $res = $mysqli->query("INSERT INTO autorestock (UID, AUID, WholesalerUID, IID, INID, Amount, Threshold) VALUES ('$uid', '$auid', '$wholesaleruid', '$iid', '$inid', '$amount', '$threshold')
        ON DUPLICATE KEY UPDATE Amount='$amount', Threshold='$threshold'");

    if (!$res) {
        http_response_code(500);
        echo json_encode(["errorMessage" => "Save failed. Please ensure all values are filled in correctly."]);
        exit();
    }

    // else

    include "./runautorestock.php";
    autoRestockAll($uid);

    http_response_code(200);
    echo json_encode(["status" => "success"]);

?>

