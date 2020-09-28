<?php
if (isset($_POST['fulfill-submit'])) {
    require '../database.php';
    $Type = $_POST["Type"];
    $OrderID = $_POST["OrderID"];
    $OrderDate = $_POST["OrderDate"];;
    if (!isset($_POST["Type"]) || !isset($_POST["OrderID"]) || !isset($_POST["OrderDate"])) {
        header("Location: ../index.php");
        exit();
    }
    date_default_timezone_set('America/Vancouver');
    $date = new DateTime(date('Y-m-d H:i:s'));
    $fulfilledDate = $date->format('Y-m-d H:i:s');
    $date2 = new DateTime($OrderDate);
    $duration = $date->getTimestamp() - $date2->getTimestamp();
    $sql = "UPDATE orderduration SET FulfilledDate=?, OrderDuration=? WHERE OrderDate=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sis", $fulfilledDate, $duration, $OrderDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        if ($Type == 'Restaurant') {
            header("Location: ../foodorder.php?ID=".$OrderID);
            exit();
        } else if ($Type == 'Wholesaler') {
            header("Location: ../inventoryorder.php?ID=".$OrderID);
            exit();
        }
    }
}
?>
