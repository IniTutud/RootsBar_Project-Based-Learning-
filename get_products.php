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

    // Ambil raw ingredients dari DB
    $rawIng = $row["ingredients"];

    // Normalisasi ingredients jadi ARRAY
    if (!$rawIng || $rawIng === "null" || $rawIng === "") {
        $ingredients = [];
    } else {
        $decoded = json_decode($rawIng, true);

        // Kalau gagal decode = kemungkinan JSON rusak
        if (!is_array($decoded)) {
            $ingredients = [];
        } else {
            $ingredients = $decoded;
        }
    }

    $data[] = [
        "id" => $row["id"],
        "name" => $row["name"],
        "price" => intval($row["price"]),
        "img" => $row["img"],
        "description" => $row["description"],
        "ingredients" => $ingredients
    ];
}

echo json_encode($data);
