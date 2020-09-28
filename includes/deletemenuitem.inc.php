<?php
    if (isset($_POST["delete-submit"])) {
        require '../database.php';
        session_start();
        $IID = $_POST["ID"];
        $ID = $_SESSION["UID"];
        $sql = "DELETE FROM menuitem WHERE UID=? AND IID=?";
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./restaurant.php?ID=".$ID."&error=sqlerror1");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ii", $ID, $IID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ../restaurant.php?ID=".$ID."&delete=success");
            exit();
        }
    }
?>