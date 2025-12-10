<?php
include "config/db.php";

// Ambil data form
$name        = $_POST['name'];
$category    = $_POST['category'];
$price       = $_POST['price'];
$description = $_POST['description'];

// ========== UPLOAD GAMBAR UTAMA (img) ==========
$imgPath = "none";

if (!empty($_FILES['image']['name'])) {
    $filename = time() . "_" . basename($_FILES['image']['name']);
    $target = "uploads/" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $imgPath = $target;
    }
}

// ========== UPLOAD INGREDIENTS (gambar) ==========
$ingredientFiles = [];

if (!empty($_FILES["ingredients"]["name"])) {

    $fileName = basename($_FILES["ingredients"]["name"]);
    $filename = time() . "_ING_" . $fileName;
    $target = "uploads/" . $filename;

    if (move_uploaded_file($_FILES["ingredients"]["tmp_name"], $target)) {
        $ingredientFiles[] = $target; // tetap simpan dalam array biar konsisten format JSON
    }
}

$ingredientsPath = json_encode($ingredientFiles);




// ========== MASUK DB ==========
$sql = "INSERT INTO products (name, category, price, img, description, ingredients)
        VALUES ('$name', '$category', '$price', '$imgPath', '$description', '$ingredientsPath')";

if (mysqli_query($conn, $sql)) {
    header("Location: produk.php?msg=added");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
