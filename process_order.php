<?php
require "config/db.php";
header("Content-Type: application/json");

// Aktifkan debug
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Ambil JSON dari fetch()
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Validasi data
if (!$data || !isset($data["items"])) {
    echo json_encode(["status" => "error", "message" => "Invalid data"]);
    exit;
}

$first   = $data["first_name"];
$last    = $data["last_name"];
$phone   = $data["phone"];
$addr    = $data["address"];
$service = $data["service_type"];   // <-- 'delivery' / 'pickup'
$subtotal = $data["subtotal"];
$shipping = $data["shipping"];
$total    = $data["total"];
$items    = $data["items"];

// --- Insert ke tabel orders ---
$stmt = $conn->prepare("
    INSERT INTO orders 
    (first_name, last_name, phone, address, service_type, status, subtotal, shipping, total, created_at)
    VALUES (?, ?, ?, ?, ?, 'PENDING', ?, ?, ?, NOW())
");

$stmt->bind_param(
    "sssssiii",
    $first,
    $last,
    $phone,
    $addr,
    $service,
    $subtotal,
    $shipping,
    $total
);

$stmt->execute();
$order_id = $stmt->insert_id;

// --- Insert item-list ---
$itemStmt = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, qty, price, subtotal)
    VALUES (?, ?, ?, ?, ?)
");

foreach ($items as $item) {
    $pid  = $item["product_id"];
    $qty  = $item["qty"];
    $price = $item["price"];
    $sub   = $price * $qty;

    $itemStmt->bind_param("iiidd", $order_id, $pid, $qty, $price, $sub);
    $itemStmt->execute();
}

echo json_encode(["status" => "success", "order_id" => $order_id]);
exit;
?>
