<?php
// produk.php - Full UI (single file) with Add / Edit / Delete functionality
// Requirements: config/db.php should define $conn = mysqli_connect(...);
// This file handles actions via GET/POST: add, update, delete, get (JSON)

include 'config/db.php';

// Ensure uploads directory exists
$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Helper: sanitize input
function inp($v) {
    return trim($v ?? '');
}

// Handle AJAX fetch of a single product
if (isset($_GET['action']) && $_GET['action'] === 'get' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($row);
    exit;
}

// Handle Delete (via GET for simplicity; you can convert to POST if preferred)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    // Optionally fetch image path to delete the file
    $stmt = mysqli_prepare($conn, "SELECT image FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $r = mysqli_fetch_assoc($res);
    if ($r && !empty($r['image'])) {
        $imgPath = __DIR__ . '/' . $r['image'];
        if (file_exists($imgPath)) @unlink($imgPath);
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: produk.php?msg=deleted");
        exit;
    } else {
        $error = mysqli_error($conn);
    }
}

// Handle Add Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = mysqli_real_escape_string($conn, inp($_POST['name']));
    $category = mysqli_real_escape_string($conn, inp($_POST['category']));
    $price = mysqli_real_escape_string($conn, inp($_POST['price']));
    $description = mysqli_real_escape_string($conn, inp($_POST['description']));

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['image']['tmp_name'];
        $orig = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (!in_array($ext, $allowed)) {
            $error = "Format gambar tidak didukung.";
        } else {
            $newName = 'uploads/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $orig);
            move_uploaded_file($tmp, __DIR__ . '/' . $newName);
            $imagePath = $newName;
        }
    }

    if (!isset($error)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO products (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssiss", $name, $category, $price, $description, $imagePath);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: produk.php?msg=added");
            exit;
        } else {
            $error = mysqli_error($conn);
        }
    }
}

// Handle Update Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = (int) ($_POST['id'] ?? 0);
    $name = mysqli_real_escape_string($conn, inp($_POST['name']));
    $category = mysqli_real_escape_string($conn, inp($_POST['category']));
    $price = mysqli_real_escape_string($conn, inp($_POST['price']));
    $description = mysqli_real_escape_string($conn, inp($_POST['description']));

    // fetch existing image
    $stmt = mysqli_prepare($conn, "SELECT image FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $existing = mysqli_fetch_assoc($res);
    $imagePath = $existing['image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // remove old file
        if (!empty($imagePath) && file_exists(__DIR__ . '/' . $imagePath)) {
            @unlink(__DIR__ . '/' . $imagePath);
        }
        $tmp = $_FILES['image']['tmp_name'];
        $orig = basename($_FILES['image']['name']);
        $newName = 'uploads/' . time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $orig);
        move_uploaded_file($tmp, __DIR__ . '/' . $newName);
        $imagePath = $newName;
    }

    $stmt = mysqli_prepare($conn, "UPDATE products SET name = ?, category = ?, price = ?, description = ?, image = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssissi", $name, $category, $price, $description, $imagePath, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: produk.php?msg=updated");
        exit;
    } else {
        $error = mysqli_error($conn);
    }
}

// Fetch products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Error : " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Manajemen Produk - ROOT'S BAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>body{font-family:serif;} </style>
  </head>
  <body class="bg-[#1e3a8a] text-white">
    <div class="flex min-h-screen">
      <!-- SIDEBAR -->
      <aside class="w-64 bg-[#102F76] flex flex-col justify-between py-6">
        <div>
          <div class="flex items-center gap-3 px-6 mb-8">
            <div class="rounded-lg flex items-center justify-center">
              <img src="logo.png" alt="Logo" class="w-10" />
            </div>
            <h1 class="text-white font-extrabold text-xl">ROOT'S BAR</h1>
          </div>
          <nav class="space-y-3 px-4">
            <a href="dashboardadmin.php" class="flex items-center gap-3 py-3 px-5 text-white hover:bg-white hover:text-[#001A70] rounded-full font-semibold transition">
              <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="pesanan.php" class="flex items-center gap-3 py-3 px-5 text-white hover:bg-white hover:text-[#001A70] rounded-full font-semibold transition">
              <i class="fas fa-shopping-bag"></i> Pesanan
            </a>
            <a href="produk.php" class="flex items-center gap-3 py-3 px-5 bg-white text-[#001A70] rounded-full font-semibold shadow-md">
              <i class="fas fa-box"></i> Manajemen Produk
            </a>
          </nav>
        </div>
        <button onclick="openLogoutPopup()" class="flex items-center gap-3 justify-center py-3 px-6 mx-6 bg-red-500 hover:bg-red-600 text-white rounded-full font-semibold shadow-lg transition">
          <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </button>
      </aside>

      <!-- MAIN -->
      <main class="flex-1 overflow-y-auto">
        <div class="flex justify-between items-center px-8 pt-8 pb-4">
          <h1 class="text-4xl font-extrabold">Products</h1>
          <p class="text-xl">Selamat datang, <span class="text-yellow-300">admin</span></p>
        </div>

        <div class="flex gap-4 items-center px-8 pb-6">
          <div class="relative flex-1 max-w-md">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input id="searchInput" type="text" placeholder="Cari Product" class="w-full rounded-full pl-12 pr-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none">
          </div>
          <button onclick="openAddPopup()" class="bg-yellow-400 text-[#001A70] px-6 py-3 rounded-xl font-bold shadow-md hover:bg-yellow-300 transition">+ Add Product</button>
        </div>

        <section class="px-8 pb-10">
          <div class="bg-[#1e40af] rounded-3xl p-6 shadow-xl">
            <div class="grid grid-cols-4 font-bold bg-[#FFF8DC] text-[#001A70] p-4 rounded-xl mb-4 text-center">
              <span>Nama Product</span><span>Category</span><span>Price</span><span>Action</span>
            </div>

            <div id="productList" class="space-y-4">
<?php while ($row = mysqli_fetch_assoc($result)): ?>
  <div class="grid grid-cols-4 bg-[#1e3a8a] border border-blue-400 p-4 rounded-xl items-center text-center text-white">
    <div class="flex items-center gap-4">
      <?php if (!empty($row['image']) && file_exists(__DIR__ . '/' . $row['image'])): ?>
        <img src="<?= htmlspecialchars($row['image']) ?>" alt="" class="w-12 h-12 rounded-md object-cover">
      <?php else: ?>
        <div class="w-12 h-12 rounded-md bg-[#0a1f4a] flex items-center justify-center text-xs">No Image</div>
      <?php endif; ?>
      <span class="text-left"><?= htmlspecialchars($row['name']) ?></span>
    </div>
    <span><?= htmlspecialchars($row['category']) ?></span>
    <span>Rp. <?= number_format($row['price'], 0, ',', '.') ?></span>
    <div class="flex justify-center gap-4 text-lg">
      <i onclick="openEditPopup(<?= $row['id'] ?>)" class="fas fa-edit cursor-pointer hover:text-yellow-400 transition"></i>
      <i onclick="deleteProduct(<?= $row['id'] ?>)" class="fas fa-trash cursor-pointer hover:text-red-500 transition"></i>
    </div>
  </div>
<?php endwhile; ?>
            </div>
          </div>
        </section>
      </main>
    </div>

    <!-- ADD POPUP -->
    <div id="addProductPopup" class="fixed inset-0 hidden items-center justify-center z-50 backdrop-blur">
      <div id="addProductBox" class="bg-[#102F76] w-[90%] max-w-4xl rounded-3xl p-8 relative">
        <button onclick="closeAddPopup()" class="absolute right-5 top-5 text-white text-2xl hover:text-red-400"><i class="fa-solid fa-xmark"></i></button>
        <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2">
          <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mb-[30px]"/> New Menu <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mt-[30px]"/>
        </h2>

        <form action="produk.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <input type="hidden" name="action" value="add">
          <div class="flex flex-col items-center">
            <div class="w-56 h-56 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-lg">Insert 1:1 picture</div>
            <input type="file" name="image" accept="image/*" class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />
            <div class="w-20 h-20 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-[10px] mt-6">Insert ingredients</div>
            <input type="file" name="ingredients" class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />
          </div>

          <div>
            <label class="text-[#F6D932] font-semibold">Nama Product</label>
            <input name="name" type="text" required class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white" />
            <label class="text-[#F6D932] font-semibold">Category</label>
            <select name="category" required class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]">
              <option value="">Select a Category</option>
              <option>Asinan</option><option>Manisan</option><option>Golden Fil</option>
            </select>
            <label class="text-[#F6D932] font-semibold">Price</label>
            <input name="price" type="number" required placeholder="10000" class="w-full mt-1 mb-6 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]" />
            <label class="text-[#F6D932] font-semibold">Deskripsi</label>
            <textarea name="description" class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]"></textarea>
            <div class="flex justify-end">
              <button type="submit" class="bg-yellow-400 px-6 py-3 rounded-xl font-bold text-[#001A70] hover:bg-yellow-300 transition">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- EDIT POPUP -->
    <div id="editProductPopup" class="fixed inset-0 hidden items-center justify-center z-50 backdrop-blur">
      <div id="editProductBox" class="bg-[#102F76] w-[90%] max-w-4xl rounded-3xl p-8 relative">
        <button onclick="closeEditPopup()" class="absolute right-5 top-5 text-white text-2xl hover:text-red-400"><i class="fa-solid fa-xmark"></i></button>
        <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2">
          <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mb-[30px]"/> Edit Menu <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mt-[30px]"/>
        </h2>

        <form id="editForm" action="produk.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id" id="edit_id">
          <div class="flex flex-col items-center">
            <div id="editImagePreview" class="w-56 h-56 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-lg">Change 1:1 Picture</div>
            <input type="file" name="image" accept="image/*" class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />
          </div>

          <div>
            <label class="text-[#F6D932] font-semibold">Nama Produk</label>
            <input name="name" id="edit_name" type="text" required class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white" />
            <label class="text-[#F6D932] font-semibold">Deskripsi</label>
            <textarea name="description" id="edit_description" class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white"></textarea>
            <label class="text-[#F6D932] font-semibold">Kategori</label>
            <select name="category" id="edit_category" required class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]">
              <option value="">Select a Category</option>
              <option>Asinan</option><option>Manisan</option><option>Golden Fil</option>
            </select>
            <label class="text-[#F6D932] font-semibold">Price</label>
            <input name="price" id="edit_price" type="number" required class="w-full mt-1 mb-6 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]" />
            <div class="flex justify-end">
              <button type="submit" class="bg-yellow-400 px-6 py-3 rounded-xl font-bold text-[#001A70] hover:bg-yellow-300 transition">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- NOTIF -->
    <div id="notifSuccess" class="fixed bottom-6 right-6 bg-green-500 text-white font-bold px-6 py-3 rounded-xl shadow-xl opacity-0 translate-y-4 transition-all duration-300 z-[999]">Action success!</div>

    <!-- LOGOUT POPUP -->
    <div id="logoutPopup" class="fixed inset-0 hidden z-50 flex items-center justify-center backdrop-blur-sm bg-black/20">
      <div id="logoutBox" class="bg-red-600 w-[90%] max-w-md rounded-3xl p-8 text-center text-white shadow-2xl scale-90 opacity-0 transition-all duration-300">
        <div class="flex justify-center mb-4"><i class="fa-regular fa-circle-xmark text-6xl"></i></div>
        <h2 class="text-2xl font-extrabold mb-2">Are you sure?</h2>
        <p class="text-sm opacity-90 mb-6">You’ll need to log in again to access your account.</p>
        <div class="flex justify-center gap-4 mt-4">
          <button onclick="closeLogoutPopup()" class="px-6 py-2 border-2 border-white text-white rounded-xl hover:bg-white hover:text-red-600 transition font-bold">Cancel</button>
          <button onclick="confirmLogout()" class="px-6 py-2 bg-white text-red-600 rounded-xl font-bold hover:bg-gray-200 transition">Confirm</button>
        </div>
      </div>
    </div>

<script>
// Helpers for popups
function openAddPopup(){
  const p = document.getElementById('addProductPopup');
  p.classList.remove('hidden'); p.classList.add('flex');
}
function closeAddPopup(){
  const p = document.getElementById('addProductPopup');
  p.classList.add('hidden'); p.classList.remove('flex');
}
function openEditPopup(id){
  fetch('produk.php?action=get&id='+id)
    .then(r => r.json())
    .then(data => {
      if (!data) return alert('Product not found');
      document.getElementById('edit_id').value = data.id;
      document.getElementById('edit_name').value = data.name || '';
      document.getElementById('edit_category').value = data.category || '';
      document.getElementById('edit_price').value = data.price || '';
      document.getElementById('edit_description').value = data.description || '';
      const preview = document.getElementById('editImagePreview');
      if (data.image) {
        preview.innerHTML = '<img src="'+data.image+'" class="w-56 h-56 object-cover rounded-md">';
      } else {
        preview.innerHTML = 'Change 1:1 Picture';
      }
      const p = document.getElementById('editProductPopup');
      p.classList.remove('hidden'); p.classList.add('flex');
    });
}
function closeEditPopup(){
  const p = document.getElementById('editProductPopup');
  p.classList.add('hidden'); p.classList.remove('flex');
}
function deleteProduct(id){
  if (!confirm('Delete this product?')) return;
  window.location.href = 'produk.php?action=delete&id='+id;
}

// Logout popup
const logoutPopup = document.getElementById('logoutPopup');
const logoutBox = document.getElementById('logoutBox');
function openLogoutPopup(){ logoutPopup.classList.remove('hidden'); setTimeout(()=>{ logoutBox.classList.remove('scale-90','opacity-0'); logoutBox.classList.add('scale-100','opacity-100'); },10); }
function closeLogoutPopup(){ logoutBox.classList.add('scale-90','opacity-0'); logoutBox.classList.remove('scale-100','opacity-100'); setTimeout(()=>logoutPopup.classList.add('hidden'),200); }
function confirmLogout(){ closeLogoutPopup(); setTimeout(()=>window.location.href='LoginAdmin.php',300); }

// Simple search filter (client-side)
document.getElementById('searchInput').addEventListener('input', function(e){
  const q = e.target.value.toLowerCase();
  const items = document.querySelectorAll('#productList > div');
  items.forEach(it=>{
    const txt = it.textContent.toLowerCase();
    it.style.display = txt.indexOf(q) !== -1 ? 'grid' : 'none';
  });
});

// Show notifications based on query string
(function(){
  const url = new URL(window.location.href);
  const msg = url.searchParams.get('msg');
  if (msg) {
    const n = document.getElementById('notifSuccess');
    let text = 'Success';
    if (msg === 'added') text = 'Produk berhasil ditambahkan';
    if (msg === 'updated') text = 'Produk berhasil diupdate';
    if (msg === 'deleted') text = 'Produk berhasil dihapus';
    n.textContent = text;
    n.classList.remove('opacity-0','translate-y-4'); n.classList.add('opacity-100','translate-y-0');
    setTimeout(()=>{ n.classList.add('opacity-0','translate-y-4'); n.classList.remove('opacity-100','translate-y-0'); }, 2500);
    // clean URL without reloading
    history.replaceState(null, '', location.pathname);
  }
})();
</script>
  </body>
</html>
