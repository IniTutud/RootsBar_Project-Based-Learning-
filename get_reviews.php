<?php
header('Content-Type: application/json');
include "config/db.php";

$result = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");

$reviews = [];

while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}

echo json_encode($reviews);
?>
