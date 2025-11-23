<?php
header("Content-Type: application/json");
include "config/db.php";

$category = isset($_GET["category"]) ? $_GET["category"] : null;

if ($category) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY id DESC");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id"          => $row["id"],
        "name"        => $row["name"],
        "category"    => $row["category"],
        "price"       => intval($row["price"]),
        "img"         => $row["img"],
        "description" => $row["description"],
        "ingredients" => $row["ingredients"]
    ];
}

echo json_encode($data);
