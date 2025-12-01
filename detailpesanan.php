<?php
require "config/db.php";

if (!isset($_GET['id'])) {
  die("Order ID not provided");
}

$order_id = intval($_GET['id']);

// ===================== AMBIL DATA ORDER =====================
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();

if (!$order) {
  die("Order tidak ditemukan.");
}

// ===================== AMBIL ITEM PESANAN =====================
$items = $conn->query("
    SELECT oi.*, p.name AS product_name 
FROM order_items oi
JOIN products p ON oi.product_id = p.id
WHERE order_id = $order_id

");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pesanan - ROOT'S BAR</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: serif;
    }
  </style>
</head>

<body class="bg-[#1e3a8a] text-white min-h-screen p-8">

  <div class="max-w-7xl mx-auto">

    <!-- Back -->
    <div class="flex items-center gap-4 mb-6">
      <a href="pesanan.php" class="text-yellow-300 hover:text-yellow-400 transition">
        <i class="fas fa-arrow-left text-3xl"></i>
      </a>
      <h1 class="text-5xl font-extrabold text-yellow-300">Detail Pesanan</h1>
    </div>

    <div class="border-t-2 border-yellow-300 mb-10"></div>

    <div class="grid grid-cols-2 gap-8">

      <!-- LEFT SIDE -->
      <div class="space-y-8">

        <div>
          <p class="text-lg mb-2">Nama Pelanggan</p>
          <p class="text-2xl font-bold"><?= $order['first_name'] . " " . $order['last_name'] ?></p>
        </div>

        <div>
          <p class="text-lg mb-2">No Telepon</p>
          <p class="text-2xl font-bold"><?= $order['phone'] ?></p>
        </div>

        <div>
          <p class="text-lg mb-2">Alamat</p>
          <p class="text-2xl font-bold"><?= $order['address'] ?></p>
        </div>

        <div>
          <p class="text-lg mb-2">Service Option</p>
          <span class="bg-red-500 text-white px-6 py-2 rounded-lg text-xl font-bold inline-block">
            <?= strtoupper($order['service_type']) ?>
          </span>
        </div>

      </div>

      <!-- RIGHT SIDE ORDER DETAIL -->
      <div>
        <div class="bg-yellow-400 rounded-3xl overflow-hidden mb-6">

          <div class="grid grid-cols-4 gap-4 text-[#1e3a8a] font-bold p-4 text-center">
            <span>Produk</span>
            <span>Harga</span>
            <span>Qty</span>
            <span>Subtotal</span>
          </div>

          <div class="bg-[#1e40af] p-4 space-y-3">

            <?php while ($item = $items->fetch_assoc()): ?>
              <div
                class="grid grid-cols-4 gap-4 items-center text-center text-yellow-300 pb-3 border-b border-yellow-300/20">
                <span><?= $item['product_name'] ?></span>
                <span>Rp. <?= number_format($item['price'], 0, ',', '.') ?></span>
                <span><?= $item['qty'] ?></span>
                <span>Rp. <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
              </div>
            <?php endwhile; ?>


          </div>

          <div class="bg-[#1e40af] px-4 pb-4">
            <div class="text-right text-xl font-bold">
              Total :
              <span class="text-yellow-300">
                Rp. <?= number_format($order['total'], 0, ',', '.') ?>
              </span>
            </div>
          </div>

        </div>

        <!-- STATUS -->
        <div class="flex items-center gap-4 mb-6">
          <span class="text-2xl font-bold">Status :</span>

          <span id="statusText" class="px-6 py-2 rounded-xl text-lg font-bold
            <?=
              $order['status'] == 'PENDING' ? 'bg-yellow-400 text-[#1e3a8a]' : (
                $order['status'] == 'ON PROCESS' ? 'bg-blue-400 text-white' : (
                  $order['status'] == 'ON DELIVERY' ? 'bg-purple-500 text-white' : (
                    $order['status'] == 'DONE' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                  ))) ?>">
            <?= $order['status'] ?>
          </span>

          <!-- SAVE BUTTON -->
          <button onclick="saveStatus()"
            class="px-8 py-2 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition text-lg">
            Save
          </button>

          <button onclick="openStatusPopup()" class="text-blue-300 hover:text-blue-400 underline text-sm">
            Ubah status
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- POPUP STATUS -->
  <div id="statusPopup" class="fixed inset-0 backdrop-blur hidden items-center justify-center z-50">

    <div id="statusBox" class="bg-[#102F76] w-[90%] max-w-md rounded-2xl p-8 relative">

      <button onclick="closeStatusPopup()" class="absolute right-5 top-5 text-white text-2xl hover:text-red-400">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <h2 class="text-2xl font-extrabold text-white mb-6 flex items-center gap-2">
        <img src="Properties/Menu_Section/bintang.png" class="w-6" />
        Ubah Status Pesanan
        <img src="Properties/Menu_Section/bintang.png" class="w-6" />
      </h2>

      <div class="flex flex-col gap-4">

        <button onclick="setStatus('PENDING')" class="w-full bg-yellow-400 text-[#102F76] font-bold py-3 rounded-xl">
          PENDING
        </button>

        <button onclick="setStatus('ON PROCESS')" class="w-full bg-blue-400 text-white font-bold py-3 rounded-xl">
          ON PROCESS
        </button>

        <button onclick="setStatus('ON DELIVERY')" class="w-full bg-purple-500 text-white font-bold py-3 rounded-xl">
          ON DELIVERY
        </button>

        <button onclick="setStatus('DONE')" class="w-full bg-green-500 text-white font-bold py-3 rounded-xl">
          DONE
        </button>

        <button onclick="setStatus('CANCELLED')" class="w-full bg-red-500 text-white font-bold py-3 rounded-xl">
          CANCELLED
        </button>

      </div>

    </div>
  </div>



  <script>
    let currentStatus = "<?= $order['status'] ?>";
    const orderId = <?= $order_id ?>;

    function openStatusPopup() {
      document.getElementById("statusPopup").classList.remove("hidden");
    }

    function closeStatusPopup() {
      document.getElementById("statusPopup").classList.add("hidden");
    }

    function setStatus(status) {
      currentStatus = status;
      document.getElementById("statusText").innerText = status;
      closeStatusPopup();
    }

    async function saveStatus() {
      const res = await fetch("update_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id: orderId,
          status: currentStatus
        })
      });

      const out = await res.json();
      if (out.status === "success") {
        alert("Status berhasil diupdate!");
      } else {
        alert("Gagal update status.");
      }
    }
  </script>

</body>

</html>