<?php

header("Content-Type: application/json");

session_start();

include "../database.php";

// make sure required fields present

$uid = $_SESSION['UID'];
$auid = $_POST['auid'] ?? null;


$res = $mysqli->query("DELETE FROM autorestock WHERE UID = '$uid' AND AUID = '$auid'");

if (!$res) {
    http_response_code(500);
    echo json_encode(["errorMessage" => "Deletion failed."]);
}

// else
http_response_code(200);
echo json_encode(["status" => "success"]);

?>

