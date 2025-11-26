<?php
include "config/db.php";

if (!isset($_GET["category"])) {
    echo json_encode([]);
    exit;
}

$cat = $_GET["category"];

// Samakan format CATEGORY agar selalu UPPERCASE
$cat = strtoupper($cat);

// Ambil produk sesuai kategori
$sql = "SELECT * FROM products WHERE UPPER(category) = '$cat'";
$q = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = [
        "id" => $row["id"],
        "name" => $row["name"],
        "price" => $row["price"],
        "img" => $row["img"],
        "description" => $row["description"],
        // INGREDIENTS itu GAMBAR SATUAN — bukan array
        "ingredients" => [$row["ingredients"]]
    ];
}

echo json_encode($data);
?>
