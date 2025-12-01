<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Animation config -->
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

<body class="bg-[#0A2A78]  flex items-center justify-center px-4 md:overflow-hidden">

  <div class="flex flex-col items-center gap-10">

    <!-- SCAN — HERE -->
    <div class="flex items-center justify-center gap-10 text-center">
      
      <div class="relative text-yellow-300 font-extrabold md:text-[100px] text-4xl tracking-wide md:top-[350px] md:right-[200px] pt-4 drop-shadow-[5px_5px_0px_#102F76]">
        SCAN
        <div class="relative h-[4px] bg-red-600 w-full top-[30px]"></div>
      </div>

      <div class="relative text-yellow-300 font-extrabold md:text-[100px] text-4xl tracking-wide md:top-[350px] md:left-[200px] pt-4 drop-shadow-[5px_5px_0px_#102F76]">
        HERE
        <div class="relative h-[4px] bg-red-600 w-full top-[30px]"></div>
      </div>

    </div>

    <!-- QR CARD -->
    <div 
      class="bg-[#F1E9D4] p-6 md:px-[150px] rounded-3xl shadow-xl animate-pop
             w-[340px] md:w-[670px] flex justify-center">

      <!-- Ganti src dengan QR asli -->
      <img src="Properties/Payment/qris_qr.png" 
           class=" shadow-md w-full" alt="QRIS">

    </div>

  </div>

</body>
</html>
