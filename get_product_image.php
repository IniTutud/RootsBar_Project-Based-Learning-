<?php
include "config/db.php";

$id = $_GET['id'];

$query = "SELECT img FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>
