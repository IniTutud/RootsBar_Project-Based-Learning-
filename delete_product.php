<?php
include "config/db.php";

$id = $_GET['id'];

// hapus file gambar (optional)
$q = mysqli_query($conn, "SELECT img, ingredients FROM products WHERE id=$id");
$data = mysqli_fetch_assoc($q);

if ($data['img'] !== "none" && file_exists($data['img'])) {
    unlink($data['img']);
}
if ($data['ingredients'] !== "none" && file_exists($data['ingredients'])) {
    unlink($data['ingredients']);
}

// hapus dari database
mysqli_query($conn, "DELETE FROM products WHERE id=$id");

header("Location: produk.php?msg=deleted");
exit;
?>
