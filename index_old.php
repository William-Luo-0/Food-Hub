<?php

include "database.php";

// quick test
$res = $mysqli->query("SHOW TABLES");

echo "Available table list:";
while ($row = $res->fetch_array()) {
	echo "<li>$row[0]</li>";
}

?>
