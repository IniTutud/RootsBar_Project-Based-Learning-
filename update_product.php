<?php
include "config/db.php";

$id          = $_POST["id"];
$name        = $_POST["name"];
$category    = $_POST["category"];
$price       = $_POST["price"];
$description = $_POST["description"];

// Ambil data lama
$q = mysqli_query($conn, "SELECT img, ingredients FROM products WHERE id='$id'");
$old = mysqli_fetch_assoc($q);

$imgPath = $old["img"];
$ingredientsPath = $old["ingredients"];

// =====================
// Gambar Utama
// =====================
if (!empty($_FILES["image"]["name"])) {

    if ($old["img"] !== "none" && file_exists($old["img"])) {
        unlink($old["img"]);
    }

    $filename = time() . "_" . basename($_FILES["image"]["name"]);
    $target = "uploads/" . $filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
        $imgPath = $target;
    }
}

// =====================
// Gambar Ingredients
// =====================
$ingredientFiles = json_decode($old["ingredients"], true) ?? [];

// Jika upload baru
if (!empty($_FILES["ingredients"]["name"][0])) {

    // Hapus file lama
    foreach ($ingredientFiles as $oldFile) {
        if (file_exists($oldFile)) unlink($oldFile);
    }

    $ingredientFiles = [];

    foreach ($_FILES["ingredients"]["name"] as $i => $name) {
        if ($name === "") continue;

        $filename = time() . "_ING_" . basename($name);
        $target = "uploads/" . $filename;

        if (move_uploaded_file($_FILES["ingredients"]["tmp_name"][$i], $target)) {
            $ingredientFiles[] = $target;
        }
    }
}

$ingredientsPath = json_encode($ingredientFiles);


// =====================
// UPDATE DB
// =====================
$sql = "UPDATE products SET 
        name='$name',
        category='$category',
        price='$price',
        img='$imgPath',
        description='$description',
        ingredients='$ingredientsPath'
        WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: produk.php?msg=updated");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
