<?php

include_once "config.php";

// This variable defines a class holding information for an active MySQL connection that can be used anywhere where this file is included.
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$mysqli) {
    die("Connection failed: " .mysqli_connect_error());
}

?>