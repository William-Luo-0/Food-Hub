<?php
if (isset($_POST["Item-submit"])) {
    require '../database.php';
    session_start();
    $ID = $_POST["UID"];
    $Amount = $_POST["Amount"];
    $Name = $_POST["Name"];
    $Cost = $_POST["Cost"];
    $Ingredient = $_POST['Ingredient'];
    $sql = "SELECT MAX(inventoryitem.IID) FROM inventoryitem GROUP BY UID HAVING UID=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../createitem.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $ID);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($results);
        $IID = $result["MAX(inventoryitem.IID)"] + 1;
        if (isset($_POST['Ingredient']) && !empty($Ingredient)) {
            $sql = "SELECT INID FROM ingredient WHERE Name=?";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../createitem.php?error=sqlerror3");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $Ingredient);
                mysqli_stmt_execute($stmt);
                $results = mysqli_stmt_get_result($stmt);
                if ($result = mysqli_fetch_row($results)) {
                    $INID = $result[0];
                    $sql = "INSERT INTO inventoryitem (UID, IID, INID, Name, Cost, Amount) VALUES (?, ?, ?, ?, ".$Cost.", ?)";
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../createitem.php?error=sqlerror5");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "iiisi", $ID, $IID, $INID, $Name, $Amount);
                        mysqli_stmt_execute($stmt);
                    }
                } else {
                    $sql = "INSERT INTO ingredient (Name) VALUES (?)";
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../createitem.php?error=sqlerror3");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $Ingredient);
                        mysqli_stmt_execute($stmt);
                        $sql = "SELECT INID from ingredient WHERE Name=?";
                        $stmt = mysqli_stmt_init($mysqli);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../createitem.php?error=sqlerror4");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $Ingredient);
                            mysqli_stmt_execute($stmt);
                            $results = mysqli_stmt_get_result($stmt);
                            $result = mysqli_fetch_row($results);
                            $INID = $result[0];
                            $sql = "INSERT INTO inventoryitem (UID, IID, INID, Name, Cost, Amount) VALUES (?, ?, ?, ?, ".$Cost.", ?)";
                            $stmt = mysqli_stmt_init($mysqli);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ../createitem.php?error=sqlerror5");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "iiisi", $ID, $IID, $INID, $Name, $Amount);
                                mysqli_stmt_execute($stmt);
                            }
                        }
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        header("Location: ../wholesaler.php?ID=".$ID);
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
