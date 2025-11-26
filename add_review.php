<?php
header('Content-Type: application/json');
include "config/db.php";

$stars  = intval($_POST["stars"]);
$review = mysqli_real_escape_string($conn, $_POST["review"]);

if ($stars < 1 || $stars > 5) {
    echo json_encode(["status" => "error", "msg" => "Invalid stars"]);
    exit;
}

$sql = "INSERT INTO reviews (stars, review) VALUES ($stars, '$review')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "msg" => mysqli_error($conn)]);
}
?>
