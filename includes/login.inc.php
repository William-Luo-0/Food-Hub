<?php
if (isset($_POST['login-submit'])) {
    require '../database.php';
    $Account_Type = $_POST['AccountType'];
    $Email_Address = $_POST['EmailAddress'];
    $Password = $_POST['Password'];
    $sql = "";
    switch($Account_Type) {
        case "Customer":
            $sql = "SELECT * FROM customer WHERE EmailAddress=?";
            break;
        case "Restaurant":
            $sql = "SELECT * FROM restaurant WHERE EmailAddress=?";
            break;
        case "Wholesaler":
            $sql = "SELECT * FROM wholesaler WHERE EmailAddress=?";
            break;
    }
    $stmt = mysqli_stmt_init($mysqli);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=sqlerror1");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $Email_Address);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        if ($rows = mysqli_fetch_assoc($results)) {
            $result_1 = $rows["Password"];
            if ($Password !== $result_1) {
                header("Location: ../login.php?Type=".$Account_Type."&error=incorrectpassword");
                exit();
            } else {
                session_start();
                $_SESSION['UID'] = $rows["UID"];
                $_SESSION['Name'] = $rows["Name"];
                $_SESSION['PhoneNumber'] = $rows["PhoneNumber"];
                $_SESSION['EmailAddress'] = $rows["EmailAddress"];
                $_SESSION['AID'] = $rows["AID"];
                $_SESSION['AccountType'] = $Account_Type;
                $sql = "SELECT * FROM address WHERE AID=?";
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../login.php?error=sqlerror2");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $rows["AID"]);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    $result = mysqli_fetch_assoc($results);
                    $_SESSION['Street'] = $result["Street"];
                    $_SESSION['HouseNumber'] = $result["HouseNumber"];
                    $_SESSION['ApartmentNumber'] = $result["ApartmentNumber"];
                    $_SESSION['PostalCode'] = $result["PostalCode"];
                    $sql = "SELECT * FROM postalcode WHERE PostalCode=?";
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../login.php?error=sqlerror3");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $result["PostalCode"]);
                        mysqli_stmt_execute($stmt);
                        $results = mysqli_stmt_get_result($stmt);
                        $result = mysqli_fetch_assoc($results);
                        $_SESSION['Province'] = $result["Province"];
                        $_SESSION['City'] = $result["City"];
                        header("Location: ../index.php?login=success");
                        exit();
                    }
                }
            }
        } else {
            header("Location: ../login.php?Type=".$Account_Type."&error=invalidemail");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
} else {
    header("Location: ../index.php");
    exit();
}
?>