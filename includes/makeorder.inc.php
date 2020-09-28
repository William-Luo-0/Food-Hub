<?php
    if (isset($_POST["order-submit"])) {
        if (isset($_POST["ID"]) && isset($_POST["Type"])) {
            require '../database.php';
            session_start();
            $ID = $_POST['ID'];
            $Type = $_POST['Type'];
            $Item1 = $_POST['Item1'];
            $Item2 = $_POST['Item2'];
            $Item3 = $_POST['Item3'];
            $Item4 = $_POST['Item4'];
            $Item5 = $_POST['Item5'];
            $Item6 = $_POST['Item6'];
            $Item7 = $_POST['Item7'];
            $Item8 = $_POST['Item8'];
            $Items = [$Item1, $Item2, $Item3, $Item4, $Item5, $Item6, $Item7, $Item8];
            $Qty1 = $_POST['Qty1'];
            $Qty2 = $_POST['Qty2'];
            $Qty3 = $_POST['Qty3'];
            $Qty4 = $_POST['Qty4'];
            $Qty5 = $_POST['Qty5'];
            $Qty6 = $_POST['Qty6'];
            $Qty7 = $_POST['Qty7'];
            $Qty8 = $_POST['Qty8'];
            $Qtys = [$Qty1, $Qty2, $Qty3, $Qty4, $Qty5, $Qty6, $Qty7, $Qty8];
            date_default_timezone_set('America/Vancouver');
            $date = new DateTime(date('Y-m-d H:i:s'));
            $OrderDate = $date->format('Y-m-d H:i:s');
            $FulfilledDate = "1000-01-01 00:00:00";
            $sql = "INSERT INTO orderduration (OrderDate) VALUES (?)";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../orderform.php?ID=".$ID."&Type=".$Type."&error=sqlerror1");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $OrderDate);
                mysqli_stmt_execute($stmt);
                if ($Type == "Restaurant") {
                    $sql = "INSERT INTO foodorder (CustomerUID, RestaurantUID, OrderDate, FulfilledDate) VALUES (?, ?, ?, ?)";
                } else if ($Type == "Wholesaler") {
                    $sql = "INSERT INTO inventoryorder (RestaurantUID, WholesalerUID, OrderDate, FulfilledDate) VALUES (?, ?, ?, ?)";
                }
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../orderform.php?ID=".$ID."&Type=".$Type."&error=sqlerror2");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "iiss", $_SESSION["UID"], $ID, $OrderDate, $FulfilledDate);
                    mysqli_stmt_execute($stmt);
                    if ($Type == "Restaurant") {
                        $sql = "SELECT OID FROM foodorder WHERE CustomerUID=? AND RestaurantUID=? AND OrderDate=? AND FulfilledDate=?";
                    } else if ($Type == "Wholesaler") {
                        $sql = "SELECT OID FROM inventoryorder WHERE RestaurantUID=? AND WholesalerUID=? AND OrderDate=? AND FulfilledDate=?";
                    }
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../orderform.php?ID=" . $ID . "&Type=" . $Type . "&error=sqlerror3");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "iiss", $_SESSION["UID"], $ID, $OrderDate, $FulfilledDate);
                        mysqli_stmt_execute($stmt);
                        $results = mysqli_stmt_get_result($stmt);
                        $result = mysqli_fetch_assoc($results);
                        $OID = $result["OID"];
                        for ($index = 0; $index < count($Items); $index++) {
                            if ($Items[$index] != -1 && is_numeric($Qtys[$index]) && $Qtys[$index] > 0) {
                                if ($Type == "Restaurant") {
                                    $sql = "INSERT INTO foodorderitems (OID, UID, IID, Amount) VALUES (?, ?, ?, ?)";
                                } else if ($Type == "Wholesaler") {
                                    $sql = "INSERT INTO inventoryorderitems (OID, UID, IID, Amount) VALUES (?, ?, ?, ?)";
                                }
                                $stmt = mysqli_stmt_init($mysqli);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("Location: ../orderform.php?ID=" . $ID . "&Type=" . $Type . "&error=sqlerror4");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "iiii", $OID, $ID, $Items[$index], $Qtys[$index]);
                                    mysqli_stmt_execute($stmt);
                                }
                            }
                        }
                        mysqli_stmt_close($stmt);
                        mysqli_close($mysqli);
                        header("Location: ../order.php");
                        exit();
                    }
                }
            }
        } else {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }
?>