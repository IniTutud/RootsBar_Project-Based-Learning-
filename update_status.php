<?php
require "config/db.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$status = $data['status'];

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

echo json_encode(["status" => "success"]);
?>
