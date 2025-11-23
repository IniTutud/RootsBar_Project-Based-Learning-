<?php
include 'config/db.php';

// Ambil data produk dari database
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query Error : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manajemen Produk - ROOT'S BAR</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: serif;
    }
  </style>
</head>

<body class="bg-[#1e3a8a] text-white overflow-hidden">
  <div class="flex h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#1e3a8a] flex flex-col justify-between py-6">
      <div>
        <div class="flex items-center gap-3 px-6 mb-8">
          <div class=" rounded-lg flex items-center justify-center">
            <img src="logo.png" alt="Logo" class="w-10" />
          </div>
          <h1 class="text-white font-extrabold text-xl">ROOT'S BAR</h1>
        </div>

        <!-- MENU -->
        <nav class="space-y-3 px-4">
          <a href="dashboardadmin.html"
            class="flex items-center gap-3 py-3 px-5 text-white hover:bg-white hover:text-[#001A70] rounded-full font-semibold transition">
            <i class="fas fa-th-large"></i> Dashboard
          </a>

          <a href="pesanan.html"
            class="flex items-center gap-3 py-3 px-5 text-white hover:bg-white hover:text-[#001A70] rounded-full font-semibold transition">
            <i class="fas fa-shopping-bag"></i> Pesanan
          </a>

          <a href="produk.html"
            class="flex items-center gap-3 py-3 px-5 bg-white text-[#001A70] rounded-full font-semibold shadow-md">
            <i class="fas fa-box"></i> Manajemen Produk
          </a>
        </nav>
      </div>

      <!-- LOGOUT -->
      <button onclick="openLogoutPopup()"
        class="flex items-center gap-3 justify-center py-3 px-6 mx-6 bg-red-500 hover:bg-red-600 text-white rounded-full font-semibold shadow-lg transition">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </button>
    </aside>

    <!-- DELETE POPUP -->
 <div id="trashPopup" class="fixed inset-0 bg-black/60 flex items-center justify-center hidden z-50">
  <div class="bg-red-600 p-6 rounded-3xl text-center w-[320px] shadow-xl">

    <img src="Properties/kuceng.png" class="w-52 mx-auto mb-4" />

    <h2 class="text-2xl font-bold mb-2">Are you sure?</h2>
    <p class="text-sm mb-5">
      Deleting a Product will permanently remove it from your system
    </p>

    <input type="hidden" id="deleteProductId">

    <div class="flex justify-center gap-3">
      <button onclick="closePopup()" class="px-4 py-2 bg-white text-black rounded-lg font-semibold">
        No, keep product
      </button>
      <button onclick="confirmDelete()" class="px-4 py-2 bg-black/20 rounded-lg font-semibold text-white">
        Yes, remove product
      </button>
    </div>
  </div>
</div>


    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto">
      <!-- HEADER greeting -->
      <div class="flex justify-between items-center px-8 pt-8 pb-4">
        <h1 class="text-4xl font-extrabold">Product</h1>
        <p class="text-xl">
          Selamat datang, <span class="text-yellow-300">sh4rleez!</span>
        </p>
      </div>

      <!-- SEARCH + ADD PRODUCT -->
      <div class="flex gap-4 items-center px-8 pb-6">
        <!-- SEARCH -->
        <div class="relative flex-1 max-w-md">
          <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <input type="text" placeholder="Cari Product"
            class="w-full rounded-full pl-12 pr-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none" />
        </div>

        <!-- ADD PRODUCT BUTTON -->
        <button onclick="openAddPopup()"
          class="bg-yellow-400 text-[#001A70] px-6 py-3 rounded-xl font-bold shadow-md hover:bg-yellow-300 transition">
          + Add Product
        </button>
      </div>

      <!-- TABLE WRAPPER -->
      <section class="px-8 pb-10">
        <div class="bg-[#1e40af] rounded-3xl p-6 shadow-xl">
          <!-- TABLE HEADER -->
          <div class="grid grid-cols-4 font-bold bg-[#FFF8DC] text-[#001A70] p-4 rounded-xl mb-4 text-center">
            <span>Nama Product</span>
            <span>Category</span>
            <span>Price</span>
            <span>Action</span>
          </div>

          <!-- PRODUCT LIST -->
          <div class="space-y-4">
            <!-- ITEM 1 -->
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <div
                class="grid grid-cols-4 bg-[#1e3a8a] border border-blue-400 p-4 rounded-xl items-center text-center text-white">
                <span><?= htmlspecialchars($row['name']) ?></span>
                <span><?= htmlspecialchars($row['category']) ?></span>
                <span>Rp. <?= number_format($row['price'], 0, ',', '.') ?></span>
                <div class="flex justify-center gap-4 text-lg">
                  <i onclick="openEditPopup(<?= $row['id'] ?>)"
                    class="fas fa-edit cursor-pointer hover:text-yellow-400 transition"></i>
                  <i class="fas fa-trash cursor-pointer hover:text-red-500 transition"
                    onclick="openDeletePopup(<?= $row['id'] ?>)"></i>

                </div>
              </div>
            <?php endwhile; ?>



          </div>
        </div>
      </section>
    </main>
  </div>



  <!-- ADD PRODUCT POPUP -->
  <div id="addProductPopup"
    class="fixed inset-0 backdrop-blur hidden items-center justify-center z-50 transition-all duration-300">
    <div id="addProductBox" class="bg-[#102F76] w-[90%] max-w-4xl rounded-3xl p-8 relative">
      <!-- CLOSE BUTTON -->
      <button onclick="closeAddPopup()" class="absolute right-5 top-5 text-white text-2xl hover:text-red-400">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <!-- TITLE -->
      <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2">
        <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mb-[30px]" />
        New Menu
        <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mt-[30px]" />
      </h2>

      <!-- FORM START -->
      <form action="add_product.php" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 flex gap-8">

        <!-- LEFT INPUT -->
        <div class="flex flex-col items-center">
          <div class="w-56 h-56 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-lg">
            Insert 1:1 picture
          </div>
          <input type="file" name="image" required
            class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />

          <div class="w-20 h-20 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-[10px] mt-6">
            Insert ingredients
          </div>
          <input type="file" name="ingredients"
            class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />
        </div>

        <!-- RIGHT FORM -->
        <div>
          <label class="text-[#F6D932] font-semibold">Nama Product</label>
          <input type="text" name="name" required
            class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white" />

          <label class="text-[#F6D932] font-semibold">Category</label>
          <select name="category" required
            class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]">
            <option value="">Select a Category</option>
            <option>Asinan</option>
            <option>Manisan</option>
            <option>Golden Fil</option>
          </select>

          <label class="text-[#F6D932] font-semibold">Price</label>
          <input type="number" name="price" required placeholder="15000"
            class="w-full mt-1 mb-6 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]" />
          <label class="text-[#F6D932] font-semibold">Description</label>
          <input type="text" name="description" required
            class="w-full mt-1 mb-6 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]" />

          <button type="submit"
            class="bg-yellow-400 px-10 py-3 rounded-xl font-bold text-[#001A70] hover:bg-yellow-300 transition flex justify-end">
            Save
          </button>
        </div>
      </form>
      <!-- FORM END -->

    </div>
  </div>

  <!-- EDIT PRODUCT POPUP -->
  <div id="editProductPopup"
    class="fixed inset-0 backdrop-blur hidden items-center justify-center z-50 transition-all duration-300">
    <div id="editProductBox" class="bg-[#102F76] w-[90%] max-w-4xl rounded-3xl p-8 relative">
      <!-- CLOSE BUTTON -->
      <button onclick="closeEditPopup()" class="absolute right-5 top-5 text-white text-2xl hover:text-red-400">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <!-- TITLE -->
      <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2">
        <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mb-[30px]" />
        Edit Menu
        <img src="Properties/Menu_Section/bintang.png" class="w-[30px] mt-[30px]" />
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- LEFT : IMAGE INPUT -->
        <div class="flex flex-col items-center">
          <div class="w-56 h-56 bg-[#0a1f4a] rounded-xl flex items-center justify-center text-white text-lg">
            Change 1:1 Picture
          </div>

          <input type="file"
            class="mt-4 text-sm text-white file:bg-yellow-300 file:border-0 file:px-4 file:py-4 file:rounded-full file:text-[#001A70] file:font-bold" />
        </div>

        <!-- RIGHT : FORM -->
        <div>
          <label class="text-[#F6D932] font-semibold">Nama Produk</label>
          <input type="text" placeholder="Beef Ham"
            class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white" />

          <label class="text-[#F6D932] font-semibold">Deskripsi</label>
          <input type="text"
            placeholder="Rasa Beef + Patties adalah roti panggang gurih berisi daging beef lembut dan patties yang padat. Kamu mendapatkan perpaduan keju leleh dan saus yang menambah rasa. Isian dagingnya memberi pengalaman makan yang mantap dan cocok untuk kamu yang ingin pilihan roti panggang yang lebih mengenyangkan."
            class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] border border-[#F1E9D4] text-white" />

          <label class="text-[#F6D932] font-semibold">Kategori</label>
          <select class="w-full mt-1 mb-4 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]">
            <option>Select a Category</option>
            <option>Asinan</option>
            <option>Manisan</option>
            <option>Golden Fil</option>
          </select>

          <label class="text-[#F6D932] font-semibold">Price</label>
          <input type="text" placeholder="Rp. 15.000"
            class="w-full mt-1 mb-6 p-3 rounded-lg bg-[#102F76] text-white border border-[#F1E9D4]" />

          <button onclick="showSuccessNotif()"
            class="bg-yellow-400 px-10 py-3 rounded-xl font-bold text-[#001A70] hover:bg-yellow-300 transition flex justify-end">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="notifSuccess" class="fixed bottom-6 right-6 bg-green-500 text-white font-bold px-6 py-3 rounded-xl shadow-xl
            opacity-0 translate-y-4 transition-all duration-300 z-[999]">
    Produk berhasil ditambahkan!
  </div>

  <div id="logoutPopup" class="fixed inset-0 hidden z-50 flex items-center justify-center backdrop-blur-sm bg-black/20">

    <div
      class="bg-red-600 w-[90%] max-w-md rounded-3xl p-8 text-center text-white shadow-2xl scale-90 opacity-0 transition-all duration-300"
      id="logoutBox">

      <!-- ICON -->
      <div class="flex justify-center mb-4">
        <i class="fa-regular fa-circle-xmark text-6xl"></i>
      </div>

      <!-- TEXT -->
      <h2 class="text-2xl font-extrabold mb-2">Are you sure?</h2>
      <p class="text-sm opacity-90 mb-6">You’ll need to log in again to access your account.</p>

      <!-- BUTTONS -->
      <div class="flex justify-center gap-4 mt-4">
        <button onclick="closeLogoutPopup()"
          class="px-6 py-2 border-2 border-white text-white rounded-xl hover:bg-white hover:text-red-600 transition font-bold">
          Cancel
        </button>

        <button onclick="confirmLogout()"
          class="px-6 py-2 bg-white text-red-600 rounded-xl font-bold hover:bg-gray-200 transition">
          Confirm
        </button>
      </div>

    </div>
  </div>




  <script>
    const trashPopup = document.getElementById("trashPopup");
  const deleteProductId = document.getElementById("deleteProductId");

  function openDeletePopup(id) {
    deleteProductId.value = id;
    trashPopup.classList.remove("hidden");
  }

  function closePopup() {
    trashPopup.classList.add("hidden");
  }

  function confirmDelete() {
    const id = deleteProductId.value;
    window.location.href = "delete_product.php?id=" + id;
  }

    function openAddPopup() {
      document.getElementById("addProductPopup").classList.remove("hidden");
      document.getElementById("addProductPopup").classList.add("flex");
    }

    function closeAddPopup() {
      const popup = document.getElementById("addProductPopup");
      const box = document.getElementById("addProductBox");

      box.classList.add("opacity-0", "scale-95");
      box.classList.remove("opacity-100", "scale-100");

      setTimeout(() => {
        popup.classList.add("hidden");
        box.classList.remove("opacity-0", "scale-95");
        box.classList.add("opacity-100", "scale-100");
      }, 300);
    }

    function showSuccessNotif() {
      closeAddPopup(); // otomatis tutup popup dulu

      setTimeout(() => {
        const notif = document.getElementById("notifSuccess");

        notif.classList.remove("opacity-0", "translate-y-4");
        notif.classList.add("opacity-100", "translate-y-0");

        setTimeout(() => {
          notif.classList.add("opacity-0", "translate-y-4");
          notif.classList.remove("opacity-100", "translate-y-0");
        }, 2500);

      }, 300); // tunggu popup selesai animasinya
    }

    function openEditPopup() {
      const popup = document.getElementById("editProductPopup");
      const box = document.getElementById("editProductBox");

      popup.classList.remove("hidden");
      popup.classList.add("flex");

      // animasi muncul
      setTimeout(() => {
        box.classList.add("opacity-100", "scale-100");
        box.classList.remove("opacity-0", "scale-95");
      }, 10);
    }

    function closeEditPopup() {
      const popup = document.getElementById("editProductPopup");
      const box = document.getElementById("editProductBox");

      // animasi keluar
      box.classList.add("opacity-0", "scale-95");
      box.classList.remove("opacity-100", "scale-100");

      setTimeout(() => {
        popup.classList.add("hidden");
        popup.classList.remove("flex");

        // reset biar popup bisa muncul lagi normal
        box.classList.remove("opacity-0", "scale-95");
        box.classList.add("opacity-100", "scale-100");
      }, 300);
    }

    function showSuccessNotif() {
      // Nutup popup edit dulu
      closeEditPopup();

      setTimeout(() => {
        const notif = document.getElementById("notifSuccess");

        notif.classList.remove("opacity-0", "translate-y-4");
        notif.classList.add("opacity-100", "translate-y-0");

        // hilang otomatis
        setTimeout(() => {
          notif.classList.add("opacity-0", "translate-y-4");
          notif.classList.remove("opacity-100", "translate-y-0");
        }, 2500);
      }, 300); // tunggu popup selesai animasi
    }
  </script>

  <script>
    const logoutPopup = document.getElementById("logoutPopup");
    const logoutBox = document.getElementById("logoutBox");

    function openLogoutPopup() {
      logoutPopup.classList.remove("hidden");
      setTimeout(() => {
        logoutBox.classList.remove("scale-90", "opacity-0");
        logoutBox.classList.add("scale-100", "opacity-100");
      }, 10);
    }

    function closeLogoutPopup() {
      logoutBox.classList.add("scale-90", "opacity-0");
      logoutBox.classList.remove("scale-100", "opacity-100");

      setTimeout(() => {
        logoutPopup.classList.add("hidden");
      }, 200);
    }

    function confirmLogout() {
      closeLogoutPopup();
      setTimeout(() => {
        window.location.href = "LoginAdmin.html"; // arahkan ke halaman login kamu
      }, 300);
    }
  </script>

  <script>
  // CEK JIKA URL ADA ?msg=added
  const urlParams = new URLSearchParams(window.location.search);
  const msg = urlParams.get("msg");

  if (msg === "added") {
    showSuccessNotif();

    // hapus parameter dari URL biar notif tidak muncul lagi saat refresh
    window.history.replaceState({}, document.title, "produk.php");
  }
</script>
</body>

</html>