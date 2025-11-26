<?php
include "config/db.php";

$stars = [0,0,0,0,0];

$query = mysqli_query($conn, "SELECT stars, COUNT(*) AS total FROM reviews GROUP BY stars");

while ($row = mysqli_fetch_assoc($query)) {
    $index = $row["stars"] - 1;
    $stars[$index] = intval($row["total"]);
}

echo json_encode($stars);
?>
