<?php
if (isset($_POST['edit-submit'])) {
    session_start();
    require '../database.php';
    $Account_Type = $_POST['AccountType'];
    $Email_Address = $_POST['EmailAddress'];
    $Password = $_POST['Password'];
    $Password_Repeat = $_POST['PasswordRepeat'];
    $Name = $_POST['Name'];
    $Phone_Number = $_POST['PhoneNumber'];
    $Street = $_POST['Street'];
    $House_Number = $_POST['HouseNumber'];
    $Apartment_Number = $_POST['ApartmentNumber'];
    $Postal_Code = $_POST['PostalCode'];
    $Province = $_POST['Province'];
    $City = $_POST['City'];

    if ($Password !== $Password_Repeat) {
        header("Location: ../profile.edit.php?error=passwordcheck&AccountType=".$Account_Type."&EmailAddress=".$Email_Address."&Name=".$Name."&PhoneNumber=".$Phone_Number."&Street=".$Street."&HouseNumber=".$House_Number."&ApartmentNumber=".$Apartment_Number."&PostalCode=".$Postal_Code."&Province=".$Province."&City=".$City);
        exit();
    } else if (!is_numeric($Phone_Number)) {
        header("Location: ../profile.edit.php?error=invalidphonenumber&AccountType=".$Account_Type."&EmailAddress=".$Email_Address."&Name=".$Name."&Street=".$Street."&HouseNumber=".$House_Number."&ApartmentNumber=".$Apartment_Number."&PostalCode=".$Postal_Code."&Province=".$Province."&City=".$City);
        exit();
    } else {
        $sql = "";
        switch($Account_Type) {
            case "Customer":
                $sql = "SELECT UID FROM customer WHERE EmailAddress=?";
                break;
            case "Restaurant":
                $sql = "SELECT UID FROM restaurant WHERE EmailAddress=?";
                break;
            case "Wholesaler":
                $sql = "SELECT UID FROM wholesaler WHERE EmailAddress=?";
                break;
        }
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../profile.edit.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $Email_Address);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            while ($rows = mysqli_fetch_assoc($results)) {
                if ($rows["UID"] !== $_SESSION['UID']) {
                    header("Location: ../profile.edit.php?error=emailtaken&AccountType=" . $Account_Type . "&Name=" . $Name . "&PhoneNumber=" . $Phone_Number . "&Street=" . $Street . "&HouseNumber=" . $House_Number . "&ApartmentNumber=" . $Apartment_Number . "&PostalCode=" . $Postal_Code . "&Province=" . $Province . "&City=" . $City);
                    exit();
                }
            }
            $sql = "INSERT INTO postalcode (PostalCode, Province, City) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($mysqli);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../profile.edit.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "sss", $Postal_Code, $Province, $City);
                mysqli_stmt_execute($stmt);
                $sql = "UPDATE address SET Street=?, HouseNumber=?, ApartmentNumber=?, PostalCode=? WHERE AID=?";
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.edit.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "siisi", $Street, $House_Number, $Apartment_Number, $Postal_Code, $_SESSION["AID"]);
                    mysqli_stmt_execute($stmt);
                    if ($Password !== "") {
                        switch($Account_Type) {
                            case "Customer":
                                $sql = "UPDATE customer SET Name=?, PhoneNumber=?, EmailAddress=?, Password=? WHERE UID=?";
                                break;
                            case "Restaurant":
                                $sql = "UPDATE restaurant SET Name=?, PhoneNumber=?, EmailAddress=?, Password=? WHERE UID=?";
                                break;
                            case "Wholesaler":
                                $sql = "UPDATE wholesaler SET Name=?, PhoneNumber=?, EmailAddress=?, Password=? WHERE UID=?";
                                break;
                        }
                    } else {
                        switch($Account_Type) {
                            case "Customer":
                                $sql = "UPDATE customer SET Name=?, PhoneNumber=?, EmailAddress=? WHERE UID=?";
                                break;
                            case "Restaurant":
                                $sql = "UPDATE restaurant SET Name=?, PhoneNumber=?, EmailAddress=? WHERE UID=?";
                                break;
                            case "Wholesaler":
                                $sql = "UPDATE wholesaler SET Name=?, PhoneNumber=?, EmailAddress=? WHERE UID=?";
                                break;
                        }
                    }
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../profile.edit.php?error=sqlerror");
                        exit();
                    } else {
                        if (isset($Password) && isset ($Password_Repeat)) {
                            mysqli_stmt_bind_param($stmt, "ssssi", $Name, $Phone_Number, $Email_Address, $Password, $_SESSION["UID"]);
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssi", $Name, $Phone_Number, $Email_Address, $_SESSION["UID"]);
                        }
                        mysqli_stmt_execute($stmt);
                        $_SESSION['Name'] = $Name;
                        $_SESSION['PhoneNumber'] = $Phone_Number;
                        $_SESSION['EmailAddress'] = $Email_Address;
                        $_SESSION['Street'] = $Street;
                        $_SESSION['HouseNumber'] = $House_Number;
                        $_SESSION['ApartmentNumber'] = $Apartment_Number;
                        $_SESSION['PostalCode'] = $Postal_Code;
                        $_SESSION['Province'] = $Province;
                        $_SESSION['City'] = $City;
                        header("Location: ../profile.php?edit=success");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }
} else {
    header("Location: ../profile.edit.php");
    exit();
}
?>