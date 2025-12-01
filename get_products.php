<?php
require "config/db.php";

$category = $_GET["category"] ?? "";

$stmt = $conn->prepare("SELECT id, name, price, img, description, ingredients 
                        FROM products 
                        WHERE category = ?");
$stmt->bind_param("s", $category);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        "id" => $row["id"],                    // <-- INI YG PALING PENTING
        "name" => $row["name"],
        "price" => intval($row["price"]),
        "img" => $row["img"],
        "description" => $row["description"],
        "ingredients" => json_decode($row["ingredients"], true) ?: []
    ];
}

echo json_encode($data);
