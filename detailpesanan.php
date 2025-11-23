<?php include "config/db.php"; 
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
    
    <!-- Header Back Button -->
    <div class="flex items-center gap-4 mb-6">
      <button onclick="history.back()" class="text-yellow-300 hover:text-yellow-400 transition">
        <i class="fas fa-arrow-left text-3xl"></i>
      </button>
      <h1 class="text-5xl font-extrabold text-yellow-300">Detail Pesanan</h1>
    </div>

    <!-- garis lurus-->
    <div class="border-t-2 border-yellow-300 mb-10"></div>

    <!-- Content Grid -->
    <div class="grid grid-cols-2 gap-8">
      
      <!-- Left Column: Customer Info -->
      <div class="space-y-8">
        
        <!-- Nama Pelanggan -->
        <div>
          <p class="text-lg mb-2">Nama Pelanggan</p>
          <p class="text-2xl font-bold">Fadhil Nawwaf</p>
        </div>

        <!-- No Telepon -->
        <div>
          <p class="text-lg mb-2">No Telepon</p>
          <p class="text-2xl font-bold">081234567890</p>
        </div>

        <!-- Alamat -->
        <div>
          <p class="text-lg mb-2">Alamat</p>
          <p class="text-2xl font-bold">Jl. Terserah No.10</p>
        </div>

        <!-- Service Option -->
        <div>
          <p class="text-lg mb-2">Service Option</p>
          <span class="bg-red-500 text-white px-6 py-2 rounded-lg text-xl font-bold inline-block">Delivery</span>
        </div>

      </div>

      <!-- Order Details -->
      <div>
        
        <!-- Products Table -->
        <div class="bg-yellow-400 rounded-3xl overflow-hidden mb-6">
          
          <!-- Table Header -->
          <div class="grid grid-cols-4 gap-4 text-[#1e3a8a] font-bold p-4 text-center">
            <span>Produk</span>
            <span>Price</span>
            <span>QTY</span>
            <span>Subtotal</span>
          </div>

          <!-- Table Body -->
          <div class="bg-[#1e40af] p-4 space-y-3">
            
            <!-- Item 1 -->
            <div class="grid grid-cols-4 gap-4 items-center text-center text-yellow-300 pb-3 border-b border-yellow-300/30">
              <span>Beef Ham</span>
              <span>Rp. 15.000</span>
              <span>2</span>
              <span>Rp. 30.000</span>
            </div>

            <!-- Item 2 -->
            <div class="grid grid-cols-4 gap-4 items-center text-center text-yellow-300 pb-3">
              <span>Choco + choco</span>
              <span>Rp. 20.000</span>
              <span>1</span>
              <span>Rp. 20.000</span>
            </div>

          </div>

          <!-- Total -->
          <div class="bg-[#1e40af] px-4 pb-4">
            <div class="text-right text-xl font-bold">
              Total : <span class="text-yellow-300">Rp. 50.000</span>
            </div>
          </div>

        </div>

        <!-- Status Section -->
        <div class="flex items-center gap-4 mb-6">
          <span class="text-2xl font-bold">Status :</span>
         <span id="orderStatusText" 
      class="bg-yellow-400 text-[#1e3a8a] px-6 py-2 rounded-xl   text-lg font-bold">
  PENDING
</span>

<button class="px-8 py-2 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition text-lg">
            Save
          </button>

          <button onclick="openStatusPopup()" 
        class="text-blue-300 hover:text-blue-400 underline text-sm">
  Ubah status
</button>


       
          
        </div>

      </div>

    </div>

  </div>

  <!-- POPUP UBAH STATUS -->
<div id="statusPopup"
     class="fixed inset-0 backdrop-blur hidden items-center justify-center z-50 transition-all duration-300">

  <div id="statusBox"
       class="bg-[#102F76] w-[90%] max-w-md rounded-2xl p-8 relative opacity-100 scale-100 transition-all duration-300">

    <!-- Close -->
    <button onclick="closeStatusPopup()" 
            class="absolute right-5 top-5 text-white text-2xl hover:text-red-400">
      <i class="fa-solid fa-xmark"></i>
    </button>

    <!-- Title -->
    <h2 class="text-2xl font-extrabold text-white mb-6 flex items-center gap-2">
      <img src="Properties/Menu_Section/bintang.png" class="w-6" />
      Ubah Status Pesanan
      <img src="Properties/Menu_Section/bintang.png" class="w-6" />
    </h2>

    <!-- Status Buttons -->
    <div class="flex flex-col gap-4">

      <button class="w-full bg-yellow-400 text-[#102F76] font-bold py-3 rounded-xl hover:bg-yellow-300 transition"
              onclick="setStatus('PENDING')">
        PENDING
      </button>

      <button class="w-full bg-blue-400 text-white font-bold py-3 rounded-xl hover:bg-blue-300 transition"
              onclick="setStatus('ON PROCESS')">
        ON PROCESS
      </button>
      <button class="w-full bg-blue-200 text-white font-bold py-3 rounded-xl hover:bg-blue-300 transition"
              onclick="setStatus('ON DELIVERY')">
        ON DELIVERY
      </button>

      <button class="w-full bg-green-500 text-white font-bold py-3 rounded-xl hover:bg-green-400 transition"
              onclick="setStatus('DONE')">
        DONE
      </button>

      <button class="w-full bg-red-500 text-white font-bold py-3 rounded-xl hover:bg-red-400 transition"
              onclick="setStatus('CANCELLED')">
        CANCELLED
      </button>

    </div>
  </div>
</div>
 

<script>
  function openStatusPopup() {
    const popup = document.getElementById("statusPopup");
    const box   = document.getElementById("statusBox");

    popup.classList.remove("hidden");
    popup.classList.add("flex");

    setTimeout(() => {
      box.classList.add("opacity-100", "scale-100");
      box.classList.remove("opacity-0", "scale-95");
    }, 10);
  }

  function closeStatusPopup() {
    const popup = document.getElementById("statusPopup");
    const box   = document.getElementById("statusBox");

    box.classList.add("opacity-0", "scale-95");
    box.classList.remove("opacity-100", "scale-100");

    setTimeout(() => {
      popup.classList.add("hidden");
      popup.classList.remove("flex");

      box.classList.remove("opacity-0", "scale-95");
      box.classList.add("opacity-100", "scale-100");
    }, 300);
  }

  // Update Status
  function setStatus(status) {
    const statusBox = document.getElementById("orderStatusText");

    statusBox.textContent = status;

    // warna otomatis
    if (status === "PENDING") statusBox.className = "bg-yellow-400 text-[#1e3a8a] px-6 py-2 rounded-lg text-lg font-bold";
    if (status === "ON PROCESS") statusBox.className = "bg-blue-400 text-white px-6 py-2 rounded-lg text-lg font-bold";
    if (status === "ON DELIVERY") statusBox.className = "bg-blue-400 text-white px-6 py-2 rounded-lg text-lg font-bold";
    if (status === "DONE") statusBox.className = "bg-green-500 text-white px-6 py-2 rounded-lg text-lg font-bold";
    if (status === "CANCELLED") statusBox.className = "bg-red-500 text-white px-6 py-2 rounded-lg text-lg font-bold";

    closeStatusPopup();
  }
</script>


</body>
</html>