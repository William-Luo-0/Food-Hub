<?php
if (isset($_POST['register-submit'])) {
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
        header("Location: ../register.php?error=passwordcheck&AccountType=".$Account_Type."&EmailAddress=".$Email_Address."&Name=".$Name."&PhoneNumber=".$Phone_Number."&Street=".$Street."&HouseNumber=".$House_Number."&ApartmentNumber=".$Apartment_Number."&PostalCode=".$Postal_Code."&Province=".$Province."&City=".$City);
        exit();
    } else if (!is_numeric($Phone_Number)) {
        header("Location: ../register.php?error=invalidphonenumber&AccountType=".$Account_Type."&EmailAddress=".$Email_Address."&Name=".$Name."&Street=".$Street."&HouseNumber=".$House_Number."&ApartmentNumber=".$Apartment_Number."&PostalCode=".$Postal_Code."&Province=".$Province."&City=".$City);
        exit();
    } else {
        $sql = "";
        switch($Account_Type) {
            case "Customer":
                $sql = "SELECT EmailAddress FROM customer WHERE EmailAddress=?";
                break;
            case "Restaurant":
                $sql = "SELECT EmailAddress FROM restaurant WHERE EmailAddress=?";
                break;
            case "Wholesaler":
                $sql = "SELECT EmailAddress FROM wholesaler WHERE EmailAddress=?";
                break;
        }
        $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $Email_Address);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../register.php?error=emailtaken&AccountType=".$Account_Type."&Name=".$Name."&PhoneNumber=".$Phone_Number."&Street=".$Street."&HouseNumber=".$House_Number."&ApartmentNumber=".$Apartment_Number."&PostalCode=".$Postal_Code."&Province=".$Province."&City=".$City);
                exit();
            } else {
                $sql = "INSERT INTO postalcode (PostalCode, Province, City) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($mysqli);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../register.php?error=sqlerror1");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "sss", $Postal_Code, $Province, $City);
                    mysqli_stmt_execute($stmt);
                    $sql = "";
                    $pathInsert = 0;
                    if (empty($Apartment_Number)) {
                        $sql = "INSERT INTO address (Street, HouseNumber, PostalCode) VALUES (?, ?, ?)";
                        $pathInsert = 0;
                    } else {
                        $sql = "INSERT INTO address (Street, HouseNumber, ApartmentNumber, PostalCode) VALUES (?, ?, ?, ?)";
                        $pathInsert = 1;
                    }
                    $stmt = mysqli_stmt_init($mysqli);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../register.php?error=sqlerror2");
                        exit();
                    } else {
                        if ($pathInsert === 0) {
                            mysqli_stmt_bind_param($stmt, "sis", $Street, $House_Number, $Postal_Code);
                        } else {
                            mysqli_stmt_bind_param($stmt, "siis", $Street, $House_Number, $Apartment_Number, $Postal_Code);
                        }
                        mysqli_stmt_execute($stmt);
                        $sql = "SELECT AID FROM address WHERE Street=? AND HouseNumber=? AND ApartmentNumber=? AND PostalCode=?";
                        $stmt = mysqli_stmt_init($mysqli);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../register.php?error=sqlerror3");
                            exit();
                        } else {
                            if ($pathInsert === 0) {
                                $Apartment_Empty = -1;
                                mysqli_stmt_bind_param($stmt, "siis", $Street, $House_Number, $Apartment_Empty, $Postal_Code);
                            } else {
                                mysqli_stmt_bind_param($stmt, "siis", $Street, $House_Number, $Apartment_Number, $Postal_Code);
                            }
                            mysqli_stmt_execute($stmt);
                            $results = mysqli_stmt_get_result($stmt);
                            $rowAID =  mysqli_fetch_assoc($results);
                            $result_1 = $rowAID["AID"];
                            $sql = "";
                            switch ($Account_Type) {
                                case "Customer":
                                    $sql = "INSERT INTO customer (AID, Name, PhoneNumber, EmailAddress, Password) VALUES
                                (?, ?, ?, ?, ?)";
                                    break;
                                case "Restaurant":
                                    $sql = "INSERT INTO restaurant (AID, Name, PhoneNumber, EmailAddress, Password) VALUES
                                (?, ?, ?, ?, ?)";
                                    break;
                                case "Wholesaler":
                                    $sql = "INSERT INTO wholesaler (AID, Name, PhoneNumber, EmailAddress, Password) VALUES
                                (?, ?, ?, ?, ?)";
                                    break;
                            }
                            $stmt = mysqli_stmt_init($mysqli);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ../register.php?error=sqlerror4");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "issss", $result_1, $Name, $Phone_Number, $Email_Address, $Password);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../login.php?register=success");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
} else {
    header("Location: ../register.php");
    exit();
}
?>