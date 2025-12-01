<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tailwind Animation Config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          keyframes: {
            pop: {
              "0%": { opacity: "0", transform: "scale(0.8)" },
              "100%": { opacity: "1", transform: "scale(1)" }
            }
          },
          animation: {
            pop: "pop 0.4s ease-out"
          }
        }
      }
    }
  </script>

</head>
<body class="bg-[#0A2A78] mt-[160px] flex items-center justify-center">

  <div class="text-center">

    <!-- Title -->
    <h1 class="text-yellow-300 text-2xl font-extrabold mb-8 tracking-wide">
      Choose Payment Method
      <div class="w-[280px] mx-auto h-[2px] bg-red-600 mt-1"></div>
    </h1>

    <!-- QRIS Card -->
    <a href="payment.php">
    <div 
      class="bg-[#F1E9D4] w-64 h-64 rounded-3xl flex items-center justify-center cursor-pointer
             shadow-xl transition-transform duration-300 hover:scale-105 animate-pop mx-auto items-center justify-center">

      <img src="Properties/Payment/qris.png" alt="QRIS" class="w-32">
      <!-- ganti your-qris-icon.png dengan path gambar lu -->

    </div></a>

  </div>

</body>
</html>
