<?php
if (isset($_GET["UID"]) && isset($_GET["IID"])) {
    echo '<a class="btn btn-warning btn-lg mt-3" href="../wholesaler.php?ID='.$_GET["UID"].'">Go Back</a>';
    $sql = "SELECT * FROM inventoryitem WHERE UID=? AND IID=?";
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./restaurant.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $_GET["UID"], $_GET["IID"]);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($results);
        echo '<div class="container w-50 card">
                <div class="item-template">
                    <h1>'.$result["Name"].'</h1>
                    <p class="lead">Amount: '.$result["Amount"].'</p>
                    <p class="lead">$'.$result["Cost"].'</p>
                </div>
                <div style="padding: 2rem;">
                     <h4>Contains:</h4>';
        $sql = "SELECT Name FROM ingredient WHERE INID=?";
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ./restaurant.php?error=sqlerror2");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "i", $result["INID"]);
            mysqli_stmt_execute($stmt);
            $ingredients = mysqli_stmt_get_result($stmt);
            $ingredient = mysqli_fetch_assoc($ingredients);
            echo '<li>'.$ingredient["Name"].'</li>';
        }
        echo '</div>';
        if (isset($_SESSION["UID"]) && $_GET["UID"] == $_SESSION["UID"]) {
            echo '<form class="mb-4" action = "./includes/deleteinventoryitem.inc.php" method = "post" >
                    <div class="form-group" >
                        <input type = "number" class="form-control" name = "ID" value = "'.$_GET["IID"].'" hidden >
                    </div >
                    <button type = "submit" class="btn btn-danger btn-block" name = "delete-submit" > Delete inventory item </button >
                </form >';
            }
        echo '</div>';
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
} else {
    header("Location: ../index.php");
    exit();
}
?>