<?php
$koneksi = new mysqli("localhost", "root", "", "rootsbar_db"); // sesuaikan nama DB

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$result = $koneksi->query("SELECT * FROM products ORDER BY category");

$menuData = [];

while ($row = $result->fetch_assoc()) {
    $category = $row["category"];

    if (!isset($menuData[$category])) {
        $menuData[$category] = [];
    }

    $menuData[$category][] = [
       "img" => $row["img"],
        "name" => $row["name"],
        "price" => intval($row["price"]),
        "description" => $row["description"],
        "ingredients" => $row["img"]
    ];
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ROOT'S BAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="shortcut icon" href="Properties/logo.png" type="image/x-icon" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link
      rel="stylesheet"
      href="https://cdn-uicons.flaticon.com/2.6.0/uicons-brands/css/uicons-brands.css"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />

    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>

  <body class="overflow-x-hidden">
    <a class="cart-float" onclick="toggleCart()">
      <img src="Properties/cart.png" />
    </a>

    <div class="top-bar"></div>

    <!-- NAVBAR DESKTOP -->
    <nav class="desktop-nav">
      <div class="left-links">
        <a href="#home">HOME</a>
        <a href="#about">ABOUT</a>
      </div>

      <img src="Properties/logo.png" alt="Logo" class="logo" />

      <div class="right-links">
        <a href="#menu">MENU</a>
        <a href="#loc">MAPS</a>
      </div>
    </nav>

    <!-- NAVBAR MOBILE -->
    <header class="mobile-nav">
      <img src="Properties/logo.png" class="mobile-logo" />
      <button id="hamburgerBtn" class="hamburger-btn">
        <i id="hamburgerIcon" class="fa-solid fa-bars"></i>
      </button>
    </header>

    <!-- MOBILE SLIDE MENU -->
    <div id="mobileMenu" class="mobile-menu">
      <div class="menu-items">
        <a href="#home">HOME</a>
        <a href="#about">ABOUT</a>
        <a href="#menu">MENU</a>
        <a href="#loc">MAPS</a>
      </div>
    </div>

    <!-- HERO -->
    <section id="home" class="relative text-center py-40 bg-[#F1E9D4]">
      <!-- Dekorasi kiri -->
      <img
        src="Properties/Hero_Section/lettuce.png"
        alt="Lettuce"
        class="decor-left absolute top-[-20px] left-[-100px] size-[300px] md:size-[500px] rotate-[-10deg] z-[1] md:top-[-20px] md:left-[-200px]"
      />
      <img
        src="Properties/Hero_section/ham.png"
        alt="Ham"
        class="decor-left absolute top-[370px] left-[-100px] w-[180px] md:w-64 rotate-[10deg] z-[1] md:top-64 md:left-32"
      />
      <!-- Dekorasi kanan -->
      <img
        src="Properties/Hero_Section/cheese.png"
        alt="Cheese"
        class="decor-right absolute top-[70px] right-[-100px] w-[185px] md:w-64 right-6 rotate-[-10deg] z-[1] md:top-20"
      />
      <img
        src="Properties/Hero_Section/bread.png"
        alt="Bread"
        class="decor-right absolute top-[370px] right-0 w-[200px] md:w-96 rotate-[5deg] z-[1] md:top-64 md:right-0"
      />

      <!-- Konten utama -->
      <h1
        class="font-['Playfair_Display'] text-7xl md:text-10xl text-[#102f76] font-extrabold z-[3] relative no-copy"
      >
        ROOT’S BAR
      </h1>
      <p class="text-red-600 text-xl font-medium mt-2 no-copy">
        Roti Bakar Khas Bandung
      </p>
      <button class="order-btn mt-8 z-[99]" href="#menu">Order Now</button>
    </section>

    <!-- About Section -->
    <section
      id="about"
      class="px-[10%] py-20 bg-[#F1E9D4] flex flex-col md:flex-row items-center gap-14"
    >
      <!-- IMAGE (centered on mobile, right on desktop) -->
      <div class="relative w-full md:w-1/2 flex justify-center">
        <div class="relative b">
          <img
            src="Properties/About_Section/about.png"
            alt="Sandwich"
            class="rounded-[20px] z-10 relative"
          />
          <div class="absolute inset-0 translate-x-3 translate-y-3"></div>
        </div>
      </div>

      <!-- TEXT -->
      <div class="w-full md:w-1/2 text-[#102f76] text-center md:text-left">
        <h2
          class="text-[48px] font-bold mb-6 about-title no-copy underline decoration-[#c8161d] underline-offset-[10px]"
        >
          About Us
        </h2>

        <p
          class="text-[14px] md:text-[18px] text-left md leading-relaxed mb-10 p-4"
        >
          ROOT’S BAR adalah usaha kuliner yang berlokasi di Jl. Jojoran Gang 1
          No. 20, Surabaya. Usaha ini beroperasi setiap hari pukul 16.00 sampai
          22.00 WIB dan menyajikan roti bakar khas Bandung dengan konsep street
          food modern. ROOT’S BAR menghadirkan roti bakar yang dibakar langsung,
          memadukan cita rasa autentik Bandung dengan kreasi rasa yang mengikuti
          tren kuliner masa kini. Setiap menu dibuat dari bahan yang terjaga
          kualitasnya, proses yang higienis, dan rasa yang konsisten.
        </p>

        <a
          href="#menu"
          class="order-btn inline-block font-bold text-[22px] px-10 py-3 transition-transform duration-200 hover:scale-105"
        >
          Order Now
        </a>
      </div>
    </section>

    <!-- Checkerboard -->
    <img
      src="Properties/About_Section/checkered.png"
      alt="Checkerboard"
      class="w-[1900px] md:w-full"
    />

    <div id="menuPopup" class="menu-popup">
      <div class="menu-content card-style">
        <span class="close" onclick="toggleMenuPopup()">&times;</span>
        <div class="menu-detail">
          <div class="menu-popUp-img">
            <img id="popupImg" src="" alt="Menu Image" class="popup-img" />
          </div>
          <div class="menu-popUp-desc text-center relative">
            <div
              id="popupTitle"
              class="title-container text-3xl font-bold"
            ></div>

            <div class="relative star-wrapper">
              <img
                src="Properties/Menu_Section/bintang.png"
                class="absolute w-9 star-1"
              />
              <img
                src="Properties/Menu_Section/bintang.png"
                class="absolute w-9 star-2"
              />
            </div>

            <p id="popupDesc" class="description popupDesc text-[#FFFFFF]"></p>

            <div class="ingredients-title mt-4 ingredients-title">
              Ingredients
            </div>

            <div id="popupIngredients" class="ingredients-list"></div>

            <button class="add-cart-btn" onclick="addToCart()">Checkout</button>
          </div>
        </div>
      </div>
    </div>

    <div id="cartNotif" class="notification" role="alert" aria-live="assertive">
      <div class="notification-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12" />
        </svg>
      </div>
      <div class="notification-text"></div>
      <button
        class="close-button"
        aria-label="Close notification"
        onclick="this.parentElement.style.display='none';"
      >
        &times;
      </button>
    </div>

    <section id="menu" class="menu bg-[#102F76] text-white text-center py-12">
      <!-- TITLE -->
      <div class="px-10 flex items-center justify-center md:justify-start mb-8">
        <a href="Login-Admin.html">
          <img
            src="Properties/Menu_Section/bintang.png"
            class="w-[30px] mt-[60px]"
          />
        </a>
        <h1
          class="text-[50px] font-bold text-[#FFF8E5]"
          style="font-family: 'Cooper Black', sans-serif"
        >
          Our Menu
        </h1>
        <a href="LoginAdmin.php">
          <img
            src="Properties/Menu_Section/bintang.png"
            class="w-[30px] mb-[60px]"
          />
        </a>
      </div>

      <!-- TOP BORDER -->
      <div class="w-[88%] mx-auto border-t-[3px] border-yellow-400"></div>

      <!-- ROW: LEFT TEXT + RIGHT BUTTON GROUP -->
      <div class="px-10 py-[8px] md:py-4 flex justify-between items-center">
        <!-- LEFT LABEL -->
        <p
          class="md:text-[19px] tracking-wide whitespace-nowrap pr-[20px] font-semibold tracking-wide text-[#FFF8E5] md:ml-[80px] md:pr-0"
        >
          PICK A VARIANT
        </p>

        <!-- RIGHT BUTTON GROUP -->
        <div
          class="flex md:gap-5 gap-[10px] items-center md:mr-[550px] overflow-x-auto scroll-smooth"
          id="variant-scroll"
        >
          <button class="variant-btn active" data-category="ASINAN">
            ASINAN
          </button>

          <button class="variant-btn" data-category="MANISAN">MANISAN</button>

          <button class="variant-btn" data-category="GOLDEN FIL">GOLDEN FIL</button>
        </div>

        <!-- ARROW BUTTON -->
        <button
          id="scroll-right"
          class="bg-yellow-400 text-red-600 font-bold rounded-full w-7 h-7 flex-shrink-0 justify-center items-center md:hidden"
        >
          ➜
        </button>
      </div>

      <!-- BOTTOM BORDER -->

      <div class="w-[88%] mx-auto border-t-[3px] border-yellow-400"></div>

      <div
        id="menuList"
        class="mt-10 flex flex-wrap justify-center gap-10 px-6 md:w-auto mx-auto"
      >
        <!-- JS akan isi disini -->
      </div>
    </section>

    <!-- Popup Cart -->
    <div id="cartPopup" class="cart-popup">
      <div class="cart-content">
        <span class="close" onclick="toggleCart()">&times;</span>
        <div class="cart-box">
          <h2
            class="cart-title underline decoration-[#F6D932] underline-offset-4"
          >
            Keranjang
          </h2>
          <table>
            <thead>
              <tr>
                <th>Produk</th>
                <th class="price">Price</th>
                <th class="jumlah">Jumlah</th>
                <th class="subtotal">Subtotal</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <!-- <tr>
                <td>
                  <label class="custom-checkbox">
                    <input
                      type="checkbox"
                      class="item-check"
                      data-price="15000"
                      data-qty="2"
                      checked
                    />
                    <span class="checkmark"></span>
                    Beef Ham
                  </label>
                </td>
                <td class="price">Rp.15,000</td>
                <td class="jumlah" style="text-align: center">2</td>
                <td class="subtotal" style="text-align: right">Rp.30,000</td>
                <td class="remove"><span class="remove-item">×</span></td>
              </tr>

              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input
                      type="checkbox"
                      class="item-check"
                      data-price="20000"
                      data-qty="3"
                      checked
                    />
                    <span class="checkmark"></span>
                    Choco + Choco
                  </label>
                </td>
                <td class="price">Rp.20,000</td>
                <td class="jumlah" style="text-align: center">3</td>
                <td class="subtotal" style="text-align: right">Rp.60,000</td>
                <td class="remove"><span class="remove-item">×</span></td>
              </tr>

              <tr>
                <td>
                  <label class="custom-checkbox">
                    <input
                      type="checkbox"
                      class="item-check"
                      data-price="21000"
                      data-qty="1"
                      checked
                    />
                    <span class="checkmark"></span>
                    Beef + Pattis
                  </label>
                </td>
                <td class="price">Rp.21,000</td>
                <td class="jumlah" style="text-align: center">1</td>
                <td class="subtotal" style="text-align: right">Rp.21,000</td>
                <td class="remove"><span class="remove-item">×</span></td>
              </tr> -->
            </tbody>
          </table>

          <div class="select-all">
            <label class="custom-checkbox">
              <input type="checkbox" id="select-all" />
              <span class="checkmark"></span>
              PILIH SEMUA PRODUK <span class="small-grey">(0)</span>
            </label>
          </div>

          <div class="footer-cart">
            <div>Total : <strong>Rp.111.000</strong></div>
            <button>Checkout</button>
          </div>
        </div>
      </div>
    </div>

    <section
      class="min-h-[315px] sm:min-h-[550px] md:min-h-[310px] bg-no-repeat mx-auto bg-[url('/Properties/Order_Via_Section/checkered_phone.png')] bg-contain bg-top md:bg-[url('/Properties/Order_Via_Section/checkered_red.png')] md:bg-cover md:bg-center"
    >
      <div class="mx-auto">
        <!-- Judul -->
        <h2
          class="text-[#0a2458] text-4xl md:text-6xl sm:text-5xl font-extrabold tracking-wide mb-8 underline decoration-[#c8161d] underline-offset-4 no-copy justify-center align-items-center flex items-center pt-[80px] sm:pt-[114px] md:mr-[60rem]"
          style="font-family: 'Cooper Black', 'Poppins', sans-serif"
        >
          ORDER VIA
        </h2>

        <div
          class="flex justify-center md:gap-[18px] gap-[10px] mt-[-12px] md:relative md:right-0 md:bottom-[100px] md:left-[250px]"
        >
          <!-- Item -->
          <a
            href="#"
            target="_blank"
            class="bg-[#F6D932] w-[65px] h-[65px] sm:w-24 sm:h-[130px] sm:w-[130px] md:w-[200px] md:h-[100px] rounded-[25px] flex items-center justify-center shadow-[0_4px_5px_rgba(0,0,0,0.25)] hover:scale-105 transition"
          >
            <img
              src="Properties/Order_Via_Section/whatsapp.png"
              alt="WhatsApp"
              class="w-[30px] sm:w-12"
            />
          </a>

          <a
            href="#"
            target="_blank"
            class="bg-[#F6D932] w-[65px] h-[65px] sm:w-24 sm:h-[130px] sm:w-[130px] md:w-[200px] md:h-[100px] rounded-[25px] flex items-center justify-center shadow-[0_4px_5px_rgba(0,0,0,0.25)] hover:scale-105 transition"
          >
            <img
              src="Properties/Order_Via_Section/gojek_1.png"
              alt="GoFood"
              class="w-[30px] sm:w-12"
            />
          </a>

          <a
            href="#"
            target="_blank"
            class="bg-[#F6D932] w-[65px] h-[65px] sm:w-24 sm:h-[130px] sm:w-[130px] md:w-[200px] md:h-[100px] rounded-[25px] flex items-center justify-center shadow-[0_4px_5px_rgba(0,0,0,0.25)] hover:scale-105 transition"
          >
            <img
              src="Properties/Order_Via_Section/grab.png"
              alt="GrabFood"
              class="w-10 sm:w-12 md:w-[100px]"
            />
          </a>

          <a
            href="https://shopee.co.id/universal-link/now-food/shop/22348963?deep_and_deferred=1&shareChannel=copy_link"
            target="_blank"
            class="bg-[#F6D932] w-[65px] h-[65px] sm:w-24 sm:h-[130px] sm:w-[130px] md:w-[200px] md:h-[100px] rounded-[25px] flex items-center justify-center shadow-[0_4px_5px_rgba(0,0,0,0.25)] hover:scale-105 transition"
          >
            <img
              src="Properties/Order_Via_Section/shopee_1.png"
              alt="ShopeeFood"
              class="w-[30px] sm:w-12"
            />
          </a>
        </div>
      </div>
    </section>
    <!-- REVIEW & RATING Section -->
    <section class="bg-[#F1E9D4] py-16 px-6 md:px-20">
      <h2
        class="text-[#0a2458] text-4xl md:text-5xl font-extrabold tracking-wide mb-12 underline decoration-[#c8161d] underline-offset-4 text-center no-copy"
        style="font-family: 'Cooper Black', 'Poppins', sans-serif"
       
      >
        Review & Rating
      </h2>

      <div
        class="flex flex-col lg:flex-row justify-center items-center gap-12 max-w-6xl mx-auto"
      >
        <!-- LEFT: Rating Summary + Graph -->
        <div
          class="bg-[#102F76] text-white rounded-[40px] shadow-lg p-8 w-full max-w-[420px] drop-shadow-[0_4px_16px_#0b2b89]"
        >
          <div class="flex items-center gap-3 mb-4">
            <p id="avgScore" class="text-5xl font-extrabold leading-none">
              5.0
            </p>
            <div>
              <div id="avgStars" class="flex gap-1 mb-1">
                <span class="text-yellow-400 text-xl">★</span>
                <span class="text-yellow-400 text-xl">★</span>
                <span class="text-yellow-400 text-xl">★</span>
                <span class="text-yellow-400 text-xl">★</span>
                <span class="text-yellow-400 text-xl">★</span>
              </div>
              <p id="reviewCount" class="text-sm text-gray-200">12 Reviews</p>
            </div>
          </div>

          <!-- Chart -->
          <div class="w-full h-48 mt-4">
            <canvas id="ratingChart"></canvas>
          </div>
        </div>

        <!-- RIGHT: Rating Form -->
        <div
          class="bg-[#102F76] text-[#fff8e5] rounded-[40px] p-8 w-full max-w-[420px] drop-shadow-[0_4px_16px_#0b2b89]"
        >
          <label class="font-semibold text-lg mb-3 block">Your Rating</label>

          <div id="starContainer" class="flex gap-2 mb-6 text-2xl text-white">
            <i
              class="fa-regular fa-star cursor-pointer border-[1px] border-[#fff8e5] p-2 rounded-[10px] px-[13px] md:px-4"
              data-value="1"
            ></i>
            <i
              class="fa-regular fa-star cursor-pointer border-[1px] border-[#fff8e5] p-2 rounded-[10px] px-[13px] md:px-4"
              data-value="2"
            ></i>
            <i
              class="fa-regular fa-star cursor-pointer border-[1px] border-[#fff8e5] p-2 rounded-[10px] px-[13px] md:px-4"
              data-value="3"
            ></i>
            <i
              class="fa-regular fa-star cursor-pointer border-[1px] border-[#fff8e5] p-2 rounded-[10px] px-[13px] md:px-4"
              data-value="4"
            ></i>
            <i
              class="fa-regular fa-star cursor-pointer border-[1px] border-[#fff8e5] p-2 rounded-[10px] px-[13px] md:px-4"
              data-value="5"
            ></i>
          </div>

          <label class="font-semibold text-lg mb-2 block">Product Review</label>
          <textarea
            id="reviewText"
            class="w-full rounded-[20px] p-3 text-white resize-none focus:outline-none ring-1 ring-[#fff8e5] bg-black/10"
            rows="4"
            placeholder="Write your review here..."
          ></textarea>

          <button
            id="submitReview"
            class="bg-white text-[#0b2b89] font-extrabold px-6 py-2 mt-5 rounded-md shadow hover:bg-[#f6d932] hover:text-[#102f76] transition-all justify-end flex ml-auto"
          >
            SUBMIT
          </button>
        </div>
      </div>
    </section>
    <!-- CUSTOMER REVIEW SECTION -->
    <section class="bg-[#F1E9D4] py-16 px-6 md:px-20 no-copy">
      <div class="max-w mx-auto">
        <div class="flex flex-wrap justify-center gap-1">
          <!-- CARD 1 -->
          <div
            class="bg-[#102F76] text-white rounded-2xl shadow-xl w-[280px] sm:w-[300px] p-6 pb-40 relative"
            style="transform: rotate(-3deg)"
          >
            <div class="absolute top-0 left-0 w-full h-6 rounded-t-2xl"></div>

            <div class="mt-6">
              <div class="flex gap-1 text-yellow-400 mb-2 text-lg">
                <span>★</span><span>★</span><span>★</span><span>★</span
                ><span>★</span>
              </div>
              <p class="text-sm leading-snug mb-6">
                overall best, the taste, the service. i love it!! 💖🤤
              </p>

              <div class="flex items-center gap-3">
                <img
                  src="https://i.pravatar.cc/40?img=13"
                  alt="avatar"
                  class="w-8 h-8 rounded-full border-2 border-white"
                />
                <div>
                  <p class="text-sm font-semibold">Syaiful Alief</p>
                  <p class="text-xs text-white/70">@Syaifulalief00</p>
                </div>
              </div>
            </div>
          </div>

          <!-- CARD 2 -->
          <div
            class="bg-[#0b2b89] text-white rounded-2xl shadow-xl w-[280px] sm:w-[300px] p-6 pb-40 relative"
            style="transform: rotate(2deg)"
          >
            <div
              class="absolute top-0 left-0 w-full h-6 bg-[repeating-linear-gradient(90deg,#FFF8E5_0_18px,#0b2b89_18px_36px)] rounded-t-2xl"
            ></div>

            <div class="mt-6">
              <div class="flex gap-1 text-yellow-400 mb-2 text-lg">
                <span>★</span><span>★</span><span>★</span><span>★</span
                ><span>★</span>
              </div>
              <p class="text-sm leading-snug mb-6">The best.</p>

              <div class="flex items-center gap-3">
                <img
                  src="https://i.pravatar.cc/40?img=11"
                  alt="avatar"
                  class="w-8 h-8 rounded-full border-2 border-white"
                />
                <div>
                  <p class="text-sm font-semibold">Arvian Fahmi Kusuma</p>
                  <p class="text-xs text-white/70">@Arvianfahmi123</p>
                </div>
              </div>
            </div>
          </div>

          <!-- CARD 3 -->
          <div
            class="bg-[#0b2b89] text-white rounded-2xl shadow-xl w-[280px] sm:w-[300px] p-6 pb-40 relative"
            style="transform: rotate(-1.5deg)"
          >
            <div class="absolute top-0 left-0 w-full h-6 rounded-t-2xl"></div>

            <div class="mt-6">
              <div class="flex gap-1 text-yellow-400 mb-2 text-lg">
                <span>★</span><span>★</span><span>★</span><span>★</span
                ><span>★</span>
              </div>
              <p class="text-sm leading-snug mb-6">
                It tastes good and the price is friendly, suitable for eating
                together. awesome 🙌👌
              </p>

              <div class="flex items-center gap-3">
                <img
                  src="https://i.pravatar.cc/40?img=32"
                  alt="avatar"
                  class="w-8 h-8 rounded-full border-2 border-white"
                />
                <div>
                  <p class="text-sm font-semibold">Dinar Nugroes</p>
                  <p class="text-xs text-white/70">@Dinarnugroes2</p>
                </div>
              </div>
            </div>
          </div>

          <!-- CARD 4 -->
          <div
            class="bg-[#102F76] text-white rounded-2xl shadow-xl w-[280px] sm:w-[300px] p-6 pb-40 relative"
            style="transform: rotate(2deg)"
          >
            <div
              class="absolute top-0 left-0 w-full h-6 bg-[repeating-linear-gradient(90deg,#FFF8E5_0_18px,#0b2b89_18px_36px)] rounded-t-2xl"
            ></div>

            <div class="mt-6">
              <div class="flex gap-1 text-yellow-400 mb-2 text-lg">
                <span>★</span><span>★</span><span>★</span><span>★</span
                ><span>★</span>
              </div>
              <p class="text-sm leading-snug mb-6">
                The taste is different from other toast, with a variety of
                pickles that make you feel full. Delicious! 😋
              </p>

              <div class="flex items-center gap-3">
                <img
                  src="https://i.pravatar.cc/40?img=48"
                  alt="avatar"
                  class="w-8 h-8 rounded-full border-2 border-white"
                />
                <div>
                  <p class="text-sm font-semibold">Putri Islamiyah</p>
                  <p class="text-xs text-white/70">@Putriislamiyah99</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="py-20 no-copy" id="loc">
      <div class="checkered">
        <img
          src="Properties/location_checker.png"
          alt=""
          class="w-[900px] absolute z-1 opacity-[10%] right-0 md:mt-[10px] mt-[145px] mt-[340px]"
        />
      </div>
      <div
        class="max-w-7xl mx-auto px-6 md:px-10 grid md:grid-cols-2 items-center gap-10"
      >
        <!-- LEFT: MAP -->
        <div class="relative flex justify-center items-center">
          <div
            class="absolute w-[260px] md:w-[320px] top-5 left-5 rotate-[5deg] bg-[#d6b889] opacity-80 rounded-xl shadow-md"
          ></div>

          <!-- Embed Map utama -->
          <iframe
            class="relative w-[260px] md:w-[360px] h-[220px] md:h-[360px] shadow-lg rotate-[-3deg]"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1408.3264455559622!2d112.76116469305302!3d-7.2724297979295605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb004a5d9043%3A0xd71e162b4d0c0839!2zUm9vdOKAmXMgQmFy!5e1!3m2!1sen!2sid!4v1762404653474!5m2!1sen!2sid"
            loading="lazy"
            allowfullscreen
          >
          </iframe>
        </div>

        <!-- RIGHT: TEXT & BUTTON -->
        <div class="text-center">
          <div
            class="bg-[#f9dd3c] text-[#0a2458] title-font text-3xl md:text-4xl font-extrabold px-28 py-3 rounded-full inline-block shadow-md mb-5 inner-shadow relative whitespace-nowrap"
          >
            Find us at
          </div>

          <p
            class="text-[#0a2458] title-font font-semibold text-lg mb-6 relative"
          >
            Jl. Jojoran Gang 1 No. 20, Surabaya
          </p>

          <a
            href="https://maps.app.goo.gl/XXXX"
            target="_blank"
            class="bg-[#f9dd3c] text-[#CF1F22] title-font font-extrabold text-sm md:text-base px-6 py-2 rounded-full shadow-md hover:translate-y-[-2px] hover:bg-[#ffe041] transition-all duration-200 inline-block relative"
          >
            GET LOCATION
          </a>
        </div>
        <div class="checkered">
          <img
            src="Properties/footer_checker.png"
            alt="Checkerboard"
            class="w-[900px] absolute z-1 right-0 pt-[82px] opacity-[10%]"
          />
        </div>
      </div>
    </section>

    <footer class="bg-[#0b2b68] text-white pt-10 pb-6 no-copy">
      <div
        class="max-w-7xl mx-auto px-6 md:px-10 grid md:grid-cols-2 gap-10 items-start"
      >
        <!-- LEFT SIDE -->
        <div>
          <h3 class="title-font text-2xl font-extrabold mb-1">ROOT’S BAR</h3>
          <p class="text-white/80 text-sm mb-4">Roti Bakar Khas Bandung</p>

          <!-- Menu Links -->
          <div class="border-b-2 border-[#d13b3b] w-[400px] mb-4"></div>
          <ul class="flex flex-col md:flex-row gap-3 text-sm md:gap-6">
            <li>
              <a href="#home" class="hover:text-[#f9dd3c] transition">Home</a>
            </li>
            <li>
              <a href="#about" class="hover:text-[#f9dd3c] transition">About</a>
            </li>
            <li>
              <a href="#menu" class="hover:text-[#f9dd3c] transition">Menu</a>
            </li>
            <li>
              <a href="#maps" class="hover:text-[#f9dd3c] transition">Maps</a>
            </li>
          </ul>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex flex-col md:items-end mr-[40px] md:mr-0 gap-4">
          <!-- Address Bar -->
          <div
            class="bg-[#c62828] text-white font-semibold px-4 py-2 rounded-md inline-flex items-center gap-2 shadow-md relative whitespace-nowrap"
          >
            <i class="fa-solid fa-location-dot"></i>
            <span>Jl. Jojoran Gang 1 No. 20, Surabaya</span>
          </div>

          <!-- Social Section -->
          <div class="text-center">
            <p class="font-bold mb-2">Our Social</p>
            <div class="flex gap-4 text-xl justify-center">
              <a
                href="https://www.instagram.com/rootsbar._/"
                target="_blank"
                class="text-[#f9dd3c] hover:text-white transition icon-social"
              >
                <i class="fa-brands fa-instagram"></i>
              </a>
              <a
                href="https://www.tiktok.com/@rootsbarr"
                target="_blank"
                class="text-[#f9dd3c] hover:text-white transition icon-social"
              >
                <i class="fa-brands fa-tiktok"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="checkered">
        <img
          src="Properties/checker_3.png"
          alt="Checkerboard"
          class="w-[1600px] mt-[17px]"
        />
      </div>

      <!-- COPYRIGHT -->
      <div class="">
        <p class="text-center text-white/70 text-xs mt-4">
          Copyright © 2025 cocinar o ser cocinado
        </p>
      </div>
    </footer>

    
   <script>
    const menuData = <?php echo json_encode($menuData); ?>;
</script>

<script src="script.js"></script>
  </body>
</html>
