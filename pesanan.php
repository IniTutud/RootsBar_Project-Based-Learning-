<?php
require "config/db.php";

// ambil semua orders
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan - ROOT'S BAR</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="shortcut icon" href="Properties/logo.png" type="image/x-icon" />
  <style>
    body {
      font-family: serif;
    }
  </style>
</head>

<body class="bg-[#1e3a8a] text-white overflow-hidden">

<div class="flex h-screen">

  <!-- Sidebar -->
 <aside class="w-64 bg-[#1e3a8a] flex flex-col justify-between py-6">
      <div>
        <div class="flex items-center gap-3 px-6 mb-8">
          <div class=" rounded-lg flex items-center justify-center">
             <img src="logo.png" alt="Logo" class="w-10">
          </div>
        <h1 class="text-white font-extrabold text-xl">ROOT'S BAR</h1>
      </div>

      <nav class="space-y-2 px-3">
        <a href="dashboardadmin.php" class="flex items-center gap-3 py-3 px-6 text-white hover:bg-white hover:text-[#1e3a8a] rounded-full font-semibold transition">
          <i class="fas fa-th-large"></i>
          <span>Dashboard</span>
        </a>

        <a href="pesanan.php" class="flex items-center gap-3 py-3 px-6 bg-white text-[#1e3a8a] rounded-full font-semibold shadow-md">
          <i class="fas fa-shopping-bag"></i>
          <span>Pesanan</span>
        </a>

        <a href="produk.php" class="flex items-center gap-3 py-3 px-6 text-white hover:bg-white hover:text-[#1e3a8a] rounded-full font-semibold transition">
          <i class="fas fa-box"></i>
          <span>Manajemen Produk</span>
        </a>
      </nav>
    </div>

   <button onclick="openLogoutPopup()" class="flex items-center gap-3 justify-center py-3 px-6 mx-6 bg-red-500 hover:bg-red-600 text-white rounded-full font-semibold shadow-lg transition">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </button>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 overflow-y-auto">

    <!-- Header greeting -->
    <div class="flex justify-between items-center px-8 pt-8 pb-4">
      <div>
        <h1 class="text-4xl font-extrabold">Order</h1>
        <p class="text-sm text-gray-300 mt-1">5 Orders found</p>
      </div>
      <p class="text-xl">Selamat datang, <span class="text-yellow-300 font-bold">sh4rlec!</span></p>
    </div>

    <!-- Filter Tabs dan Date Picker -->
    <div class="flex justify-between items-center px-8 pb-6">
      
      <!-- Tabs Filter -->
      <div class="flex gap-4" id="orderTabs">

    <button data-status="ALL" class="order-tab px-6 py-2 bg-white text-[#1e3a8a] rounded-full font-bold shadow-md">
        All orders
    </button>

    <button data-status="PENDING" class="order-tab px-6 py-2 text-white hover:bg-white/10 rounded-full font-semibold transition">
        Pending
    </button>

    <button data-status="ON PROCESS" class="order-tab px-6 py-2 text-white hover:bg-white/10 rounded-full font-semibold transition">
        On Process
    </button>

    <button data-status="ON DELIVERY" class="order-tab px-6 py-2 text-white hover:bg-white/10 rounded-full font-semibold transition">
        On Delivery
    </button>

    <button data-status="CANCELLED" class="order-tab px-6 py-2 text-white hover:bg-white/10 rounded-full font-semibold transition">
        Cancelled
    </button>

    <button data-status="DONE" class="order-tab px-6 py-2 text-white hover:bg-white/10 rounded-full font-semibold transition">
        Completed
    </button>

</div>

      <!-- Date Picker -->
      <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full border border-white/30">
        <i class="fas fa-calendar text-white"></i>
         <input id="filterDate" type="date" class="bg-transparent text-white placeholder-gray-300 outline-none w-24 font-semibold">
      </div>
    </div>

    <!-- Table -->
    <section class="px-8 pb-6">
      <div class="bg-[#1e40af] rounded-3xl overflow-hidden shadow-xl p-6">

        <!-- Table Header -->
        <div class="grid grid-cols-6 gap-4 text-sm font-bold bg-[#f5f5dc] text-[#1e3a8a] p-4 rounded-xl mb-4">
          <span>Id</span>
          <span>Name</span>
          <span>Price</span>
          <span>Date</span>
          <span>Status</span>
          <span>Details</span>
        </div>

        <!-- Table Body -->
       <div class="space-y-3">

<?php while($row = $result->fetch_assoc()): ?>

 <div class="grid grid-cols-6 gap-4 items-center text-sm p-4 rounded-xl border-2 border-white/30 bg-[#1e3a8a] 
            order-row" 
     data-status="<?= $row['status'] ?>"
     data-date="<?= date('Y-m-d', strtotime($row['created_at'])) ?>">

      
      <!-- ID -->
      <span class="font-semibold">#<?= $row['id'] ?></span>

      <!-- NAME -->
      <span><?= $row['first_name'] . " " . $row['last_name'] ?></span>

      <!-- TOTAL PRICE -->
      <span>Rp. <?= number_format($row['total'], 0, ',', '.') ?></span>

      <!-- DATE -->
      <span><?= date("d/m/Y", strtotime($row['created_at'])) ?></span>

      <!-- STATUS -->
      <span>
        <?php
          $status = $row['status'];
          $color = "bg-gray-500";

          if ($status == "PENDING") $color = "bg-yellow-500";
          if ($status == "ON PROCESS") $color = "bg-blue-500";
          if ($status == "ON DELIVERY") $color = "bg-purple-500";
          if ($status == "DONE") $color = "bg-green-500";
        ?>
        <span class="<?= $color ?> text-white px-5 py-1.5 rounded-full text-xs font-bold inline-block">
          <?= $status ?>
        </span>
      </span>

      <!-- DETAIL BUTTON -->
      <a href="detailpesanan.php?id=<?= $row['id'] ?>" 
         class="text-blue-300 hover:text-white transition font-semibold">
        Lihat Detail
      </a>

  </div>

<?php endwhile; ?>

</div>


      </div>
    </section>

  </main>

</div>

<div id="logoutPopup"
     class="fixed inset-0 hidden z-50 flex items-center justify-center backdrop-blur-sm bg-black/20">

  <div class="bg-red-600 w-[90%] max-w-md rounded-3xl p-8 text-center text-white shadow-2xl scale-90 opacity-0 transition-all duration-300"
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
      window.location.href = "LoginAdmin.php"; // arahkan ke halaman login kamu
    }, 300);
  }
</script>

<script>
const tabs = document.querySelectorAll(".order-tab");
const rows = document.querySelectorAll(".order-row");

tabs.forEach(tab => {
    tab.addEventListener("click", () => {

        // HILANGKAN ACTIVE DARI SEMUA TAB
        tabs.forEach(t => {
            t.classList.remove("bg-white", "text-[#1e3a8a]", "font-bold", "shadow-md");
            t.classList.add("text-white");
        });

        // ACTIVEKAN TAB YANG DIKLIK
        tab.classList.add("bg-white", "text-[#1e3a8a]", "font-bold", "shadow-md");
        tab.classList.remove("text-white");

        const status = tab.dataset.status;

        rows.forEach(row => {
            const rowStatus = row.dataset.status;

            if (status === "ALL" || rowStatus === status) {
                row.style.display = "grid";
            } else {
                row.style.display = "none";
            }
        });
    });
});
</script>

<script>
const dateInput = document.getElementById("filterDate");
const orderRows = document.querySelectorAll(".order-row");

dateInput.addEventListener("change", function () {
    const selectedDate = this.value; // format: yyyy-mm-dd

    if (!selectedDate) {
        orderRows.forEach(r => r.style.display = "grid");
        return;
    }

    orderRows.forEach(row => {
        const rowDateText = row.querySelector(".order-date").innerText.trim(); 
        const [d, m, y] = rowDateText.split("/"); // dd/mm/yyyy

        const rowDate = `${y}-${m}-${d}`; // ubah ke format yyyy-mm-dd

        if (rowDate === selectedDate) {
            row.style.display = "grid";
        } else {
            row.style.display = "none";
        }
    });
});
</script>



</body>
</html>