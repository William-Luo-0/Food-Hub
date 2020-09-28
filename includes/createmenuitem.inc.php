<?php
    if (isset($_POST["Item-submit"])) {
        require '../database.php';
        session_start();
        $ID = $_POST["UID"];
        $FoodType = $_POST["FoodType"];
        $Name = $_POST["Name"];
        $Price = $_POST["Price"];
        $Ingredient1 = $_POST['Ingredient1'];
        $Ingredient2 = $_POST['Ingredient2'];
        $Ingredient3 = $_POST['Ingredient3'];
        $Ingredient4 = $_POST['Ingredient4'];
        $Ingredient5 = $_POST['Ingredient5'];
        $Ingredient6 = $_POST['Ingredient6'];
        $Ingredient7 = $_POST['Ingredient7'];
        $Ingredient8 = $_POST['Ingredient8'];
        $Ingredients = [$Ingredient1, $Ingredient2, $Ingredient3, $Ingredient4, $Ingredient5, $Ingredient6, $Ingredient7, $Ingredient8];
        $Qty1 = $_POST['Qty1'];
        $Qty2 = $_POST['Qty2'];
        $Qty3 = $_POST['Qty3'];
        $Qty4 = $_POST['Qty4'];
        $Qty5 = $_POST['Qty5'];
        $Qty6 = $_POST['Qty6'];
        $Qty7 = $_POST['Qty7'];
        $Qty8 = $_POST['Qty8'];
        $Qtys = [$Qty1, $Qty2, $Qty3, $Qty4, $Qty5, $Qty6, $Qty7, $Qty8];
        $sql = "SELECT MAX(menuitem.IID) FROM menuitem GROUP BY UID HAVING UID=?";
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../createitem.php?error=sqlerror1");
                exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $ID);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            $result = mysqli_fetch_assoc($results);
            $IID = $result["MAX(menuitem.IID)"] + 1;
            $sql = "INSERT INTO menuitem (UID, IID, Name, Price, FoodType) VALUES (?, ?, ?, ".$Price.", ?)";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../createitem.php?error=sqlerror2");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "iiss", $ID, $IID, $Name, $FoodType);
                mysqli_stmt_execute($stmt);
                for ($index = 1; $index < count($Ingredients) + 1; $index++) {
                    if (isset($_POST['Ingredient'.$index]) && is_numeric($Qtys[$index - 1]) && $Qtys[$index - 1] > 0) {
                        $sql = "SELECT INID FROM ingredient WHERE Name=?";
                        $stmt = mysqli_stmt_init($mysqli);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../createitem.php?error=sqlerror3");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $Ingredients[$index - 1]);
                            mysqli_stmt_execute($stmt);
                            $results = mysqli_stmt_get_result($stmt);
                            if ($result = mysqli_fetch_row($results)) {
                                $INID = $result[0];
                                $sql = "INSERT INTO menuitemingredient (UID, IID, INID, Amount) VALUES (?, ?, ?, ?)";
                                $stmt = mysqli_stmt_init($mysqli);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("Location: ../createitem.php?error=sqlerror5");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "iiii", $ID, $IID, $INID, $Qtys[$index - 1]);
                                    mysqli_stmt_execute($stmt);
                                }
                            } else {
                                $sql = "INSERT INTO ingredient (Name) VALUES (?)";
                                $stmt = mysqli_stmt_init($mysqli);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    header("Location: ../createitem.php?error=sqlerror3");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $Ingredients[$index - 1]);
                                    mysqli_stmt_execute($stmt);
                                    $sql = "SELECT INID from ingredient WHERE Name=?";
                                    $stmt = mysqli_stmt_init($mysqli);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("Location: ../createitem.php?error=sqlerror4");
                                        exit();
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "s", $Ingredients[$index - 1]);
                                        mysqli_stmt_execute($stmt);
                                        $results = mysqli_stmt_get_result($stmt);
                                        $result = mysqli_fetch_row($results);
                                        $INID = $result[0];
                                        $sql = "INSERT INTO menuitemingredient (UID, IID, INID, Amount) VALUES (?, ?, ?, ?)";
                                        $stmt = mysqli_stmt_init($mysqli);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            header("Location: ../createitem.php?error=sqlerror5");
                                            exit();
                                        } else {
                                            mysqli_stmt_bind_param($stmt, "iiii", $ID, $IID, $INID, $Qtys[$index - 1]);
                                            mysqli_stmt_execute($stmt);
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
                mysqli_stmt_close($stmt);
                mysqli_close($mysqli);
                header("Location: ../restaurant.php?ID=".$ID);
                exit();
            }
        }
    } else {
        header("Location: ../index.php");
        exit();
    }
?>
