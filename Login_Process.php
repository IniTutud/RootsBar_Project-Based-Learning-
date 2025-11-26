<?php
session_start();
include "config/db.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: LoginAdmin.php?error=Username tidak ditemukan!");
    exit;
}

$user = $result->fetch_assoc();

// Jika password menggunakan plain text
if ($password !== $user["password"]) {
    header("Location: LoginAdmin.php?error=Password salah!");
    exit;
}

// Jika password sudah hash (lebih aman):
// if (!password_verify($password, $user["password"])) {
//     header("Location: LoginAdmin.php?error=Password salah!");
//     exit;
// }

// LOGIN BERHASIL
$_SESSION["admin_id"] = $user["id"];
$_SESSION["admin_username"] = $user["username"];

header("Location: dashboardadmin.php");
exit;
?>
