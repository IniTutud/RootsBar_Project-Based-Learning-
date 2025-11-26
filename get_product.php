<?php
include "config/db.php";

if (!isset($_GET["id"])) {
    echo json_encode(["error" => "ID not provided"]);
    exit;
}

$id = $_GET["id"];

// ambil produk sesuai id
$query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");

if (!$query || mysqli_num_rows($query) == 0) {
    echo json_encode(["error" => "Product not found"]);
    exit;
}

$data = mysqli_fetch_assoc($query);


// kirim sebagai JSON
echo json_encode($data);
?>
