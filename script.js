      // ===== INITIAL RATING DATA =====
      let ratingCounts = [1, 2, 3, 4, 57]; // ★ → ★★★★★★
      let totalReviews = ratingCounts.reduce((a, b) => a + b, 0);
      let totalStars = ratingCounts.reduce(
        (sum, count, i) => sum + count * (i + 1),
        0
      );

      // ===== CHART SETUP =====
      const ctx = document.getElementById("ratingChart").getContext("2d");
      const ratingChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["★", "★★", "★★★", "★★★★", "★★★★★"],
          datasets: [
            {
              data: ratingCounts,
              backgroundColor: "#ffffff",
              borderRadius: 8,
              barPercentage: 0.6,
            },
          ],
        },
        options: {
          scales: {
            x: {
              grid: { display: false },
              ticks: {
                color: "#FFD700",
                font: { size: 14, weight: "bold" },
              },
            },
            y: {
              grid: { color: "rgba(255,255,255,0.2)" },
              ticks: {
                color: "#ffffff",
                stepSize: 4,
              },
            },
          },
          plugins: { legend: { display: false } },
        },
      });

      // ===== UPDATE AVERAGE DISPLAY =====
      function updateAverage() {
        totalReviews = ratingCounts.reduce((a, b) => a + b, 0);
        totalStars = ratingCounts.reduce(
          (sum, count, i) => sum + count * (i + 1),
          0
        );
        const avg = totalStars / totalReviews;
        document.getElementById("avgScore").textContent = avg.toFixed(1);
        document.getElementById("reviewCount").textContent =
          totalReviews + " Reviews";

        // update stars
        const starContainer = document.getElementById("avgStars");
        starContainer.innerHTML = "";
        for (let i = 1; i <= 5; i++) {
          const star = document.createElement("span");
          star.textContent = "★";
          star.classList.add(
            i <= Math.round(avg) ? "text-yellow-400" : "text-gray-400",
            "text-xl"
          );
          starContainer.appendChild(star);
        }
      }

      updateAverage();

      // ===== STAR RATING FORM =====
      const stars = document.querySelectorAll("#starContainer i");
      let selectedStars = 0;

      stars.forEach((star) => {
        star.addEventListener("mouseover", () => {
          const val = parseInt(star.dataset.value);
          highlightStars(val);
        });
        star.addEventListener("mouseleave", () => {
          highlightStars(selectedStars);
        });
        star.addEventListener("click", () => {
          selectedStars = parseInt(star.dataset.value);
          highlightStars(selectedStars);
        });
      });

      function highlightStars(count) {
        stars.forEach((s, i) => {
          if (i < count) {
            s.classList.remove("fa-regular", "text-gray-400");
            s.classList.add("fa-solid", "text-yellow-400");
          } else {
            s.classList.remove("fa-solid", "text-yellow-400");
            s.classList.add("fa-regular", "text-gray-400");
          }
        });
      }

      // ===== SUBMIT BUTTON =====
      document.getElementById("submitReview").addEventListener("click", () => {
        const review = document.getElementById("reviewText").value.trim();
        if (selectedStars === 0)
          return alert("Please select your star rating!");
        if (review === "") return alert("Please write a review first!");

        // increase chart data
        ratingCounts[selectedStars - 1]++;
        ratingChart.data.datasets[0].data = ratingCounts;
        ratingChart.update();

        // update average rating & count
        updateAverage();

        // reset form
        selectedStars = 0;
        highlightStars(0);
        document.getElementById("reviewText").value = "";

        alert("Thank you for your feedback!");
      });

      //Tambahan (feel free to edit/delete dhil)
      // OKE SUWON
      function toggleCart() {
        const cart = document.getElementById("cartPopup");
        cart.style.display = cart.style.display === "flex" ? "none" : "flex";
      }

      const selectAllCheckbox = document.getElementById("select-all");
      const totalElement = document.querySelector(".footer-cart strong");

      function formatRp(value) {
        return "Rp." + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function calculateTotal() {
        const itemCheckboxes = document.querySelectorAll(".item-check");
        let total = 0;

        itemCheckboxes.forEach((cb) => {
          const price = parseInt(cb.dataset.price);
          const qty = parseInt(cb.dataset.qty);
          const row = cb.closest("tr");
          if (cb.checked) {
            const subtotal = price * qty;
            total += subtotal;
            row.querySelector(".subtotal").textContent = formatRp(subtotal);
          } else {
            row.querySelector(".subtotal").textContent = "Rp.0";
          }
        });

        totalElement.textContent = formatRp(total);
      }

      function updateSelectAllStatus() {
        const itemCheckboxes = document.querySelectorAll(".item-check");
        const allChecked =
          itemCheckboxes.length > 0 &&
          Array.from(itemCheckboxes).every((cb) => cb.checked);
        selectAllCheckbox.checked = allChecked;
      }

      function attachEvents() {
        const itemCheckboxes = document.querySelectorAll(".item-check");

        itemCheckboxes.forEach((cb) => {
          cb.addEventListener("change", () => {
            calculateTotal();
            updateSelectAllStatus();
          });
        });

        document.querySelectorAll(".remove-item").forEach((btn) => {
          btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            row.classList.add("fade-out");
            setTimeout(() => {
              row.remove();
              calculateTotal();
              updateSelectAllStatus();

              const count = document.querySelectorAll(".item-check").length;
              document.querySelector(".small-grey").textContent = `(${count})`;
            }, 300);
          });
        });
      }

      selectAllCheckbox.addEventListener("change", () => {
        const checked = selectAllCheckbox.checked;
        document
          .querySelectorAll(".item-check")
          .forEach((cb) => (cb.checked = checked));
        calculateTotal();
      });

      // =======================
// DATA PRODUK (DUMMY)
// Bisa diganti kapanpun
// =======================
const menuData = {
        ASINAN: [
          {
            img: "Properties/Menu_Section/beef_ham_card.png",
            popupImg: "Properties/Menu_Section/beef_ham_popup.png",
            name: "Beef Ham",
            price: 15000,
            description:
              "Roti Bakar Beef Ham adalah roti bakar premium yang diisi dengan irisan daging sapi asap (beef ham), keju leleh, dan saus spesial. Untuk menciptakan rasa yang lezat dan khas, Roti Bakar Beef Ham dibuat dari bahan-bahan pilihan berkualitas tinggi.",
            ingredients: [
              "Properties/Ingredients/bread.png",
              "Properties/Ingredients/ham.png",
              "Properties/Ingredients/lettuce.png",
            ],
          },

          {
            img: "Properties/Menu_Section/beef_patties_card.png",
            popupImg: "Properties/Menu_Section/beef_patties_popup.png",
            name: "Beef + Pattis",
            price: 21000,
            description:
              "Rasa Beef + Patties adalah roti panggang gurih berisi daging beef lembut dan patties yang padat. Kamu mendapatkan perpaduan keju leleh dan saus yang menambah rasa. Isian dagingnya memberi pengalaman makan yang mantap dan cocok untuk kamu yang ingin pilihan roti panggang yang lebih mengenyangkan.",
            ingredients: [
              "Properties/Ingredients/bread.png",
              "Properties/Ingredients/ham.png",
              "Properties/Ingredients/lettuce.png",
              "Properties/Ingredients/beef.png",
            ],
          },
        ],

        MANISAN: [
          {
            img: "Properties/Menu_Section/choco_choco_card.png",
            popupImg: "Properties/Menu_Section/choco_choco_popup.png",
            name: "Choco + Choco",
            price: 20000,
            description:
              "Rasa Choco + Choco adalah roti panggang manis dengan olesan cokelat lembut dan tambahan cokelat tebal yang membuat rasanya kaya. Kamu merasakan roti yang hangat dengan tekstur renyah dan aroma cokelat yang kuat. Roti ini cocok untuk kamu yang ingin sajian manis dengan cita rasa cokelat ganda.",
            ingredients: [
              "Properties/Ingredients/bread.png",
              "Properties/Ingredients/choco.png",
              "Properties/Ingredients/chocos.png",
            ],
          },
        ],

        "GOLDEN FIL": [
          {
            img: "Properties/Menu_Section/beef_patties_card.png",
            popupImg: "Properties/Menu_Section/beef_patties_popup.png",
            name: "Beef Sausage",
            price: "27000",
            description:
              "Rasa Beef + Patties adalah roti panggang gurih berisi daging beef lembut dan patties yang padat. Kamu mendapatkan perpaduan keju leleh dan saus yang menambah rasa. Isian dagingnya memberi pengalaman makan yang mantap dan cocok untuk kamu yang ingin pilihan roti panggang yang lebih mengenyangkan.",
            ingredients: [
              "Properties/Ingredients/bread.png",
              "Properties/Ingredients/lettuce.png",
              "Properties/Ingredients/ham.png",
              "Properties/Ingredients/beef.png",
            ],
          },
        ],
      };



// =======================
// RENDER MENU ITEMS
// =======================
const menuList = document.getElementById("menuList");

function renderMenu(category) {
  const items = menuData[category];

  menuList.innerHTML = items
    .map(
      (item) => `
      <div 
        class="menu-card relative w-[330px] cursor-pointer hover:scale-105 transition duration-300"
        onclick='toggleMenuPopup(true, ${JSON.stringify(item)})'
      >
        <!-- FRAME -->
        <img src="Properties/Menu_Section/paper.png"
             class="w-[310px] h-[310px] pointer-events-none"/>

        <!-- IMG PRODUK -->
        <img src="${item.img}"
             class="absolute top-[2px] w-[282px] rounded-[20px] object-cover pointer-events-none rotate-[-9deg]"/>

        <!-- CLIP -->
        <img src="Properties/Menu_Section/clip.png"
             class="absolute top-[-40px] right-16 w-[70px] pointer-events-none"/>

        <!-- TEXT LABEL -->
        <div class="absolute bottom-4 right-4 text-[#0A2458] font-bold flex flex-col items-center pointer-events-none">
          <span class="text-[23px] leading-none bg-[#F6D932] px-4 py-2 rounded-[20px] shadow-md"
          >${item.name}</span>
          <span  class="text-[23px] leading-none bg-[#F6D932] px-4 py-2 rounded-[20px] shadow-md transform -translate-y- -translate-x-[-50px]"
          >${item.price / 1000}K</span>
        </div>

      </div>
    `
    )
    .join("");
}


// =======================
// BUTTON LOGIC
// =======================
const buttons = document.querySelectorAll(".variant-btn");

buttons.forEach((btn) => {
  btn.addEventListener("click", () => {

    // Remove active class dari semuanya
    buttons.forEach(b => b.classList.remove("active"));

    // Tambah active ke tombol yang dipencet
    btn.classList.add("active");

    // Ambil kategori dari attribute data-category
    const category = btn.dataset.category;

    // Render ulang
    renderMenu(category);
  });
});


// Render default saat masuk halaman
renderMenu("ASINAN");




      function toggleMenuPopup(show = false, item = null) {
        const popup = document.getElementById("menuPopup");

        if (show && item) {
          let price = item.price;
          if (typeof price === "string" && price.includes("K")) {
            price = parseInt(price.replace("K", "")) * 1000;
          }

          document.getElementById("popupImg").src = item.popupImg || item.img;
          document.getElementById("popupTitle").textContent = item.name;
          document.getElementById("popupDesc").textContent = item.description;

          const popupBox = document.getElementById("menuPopup");
          popupBox.dataset.name = item.name;
          popupBox.dataset.price = price;

          const ingContainer = document.getElementById("popupIngredients");
          ingContainer.innerHTML = item.ingredients
            .map(
              (src) => `<div class="ingredient-item"><img src="${src}"></div>`
            )
            .join("");

          setTimeout(() => {
            const title = document.getElementById("popupTitle");
            const h = title.offsetHeight;

            const starone = document.querySelector(".star-1");
            const startwo = document.querySelector(".star-2");

            starone.style.top = h - 75 + "px";
            startwo.style.top = h - 130 + "px";
          }, 30);

          popup.style.display = "flex";
        } else {
          popup.style.display = "none";
        }
      }

      function addToCart() {
        const popup = document.getElementById("menuPopup");
        const name = popup.dataset.name;
        const price = parseInt(popup.dataset.price);

        const tbody = document.querySelector("#cartPopup tbody");

        const existingRow = Array.from(tbody.querySelectorAll("tr")).find(
          (row) => row.querySelector("label").textContent.trim() === name
        );

        if (existingRow) {
          const qtyCell = existingRow.querySelector(".jumlah");
          const newQty = parseInt(qtyCell.textContent) + 1;
          qtyCell.textContent = newQty;
          existingRow.querySelector(".item-check").dataset.qty = newQty;
        } else {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>
              <label class="custom-checkbox">
                <input type="checkbox" class="item-check" data-price="${price}" data-qty="1" checked>
                <span class="checkmark"></span>
                ${name}
              </label>
            </td>
            <td class="price">Rp.${price.toLocaleString("id-ID")}</td>
            <td class="jumlah" style="text-align:center">1</td>
            <td class="subtotal" style="text-align:right">Rp.${price.toLocaleString(
              "id-ID"
            )}</td>
            <td class="remove"><span class="remove-item">×</span></td>
          `;
          tbody.appendChild(row);
        }

        calculateTotal();
        updateSelectAllStatus();
        attachEvents();

        const count = document.querySelectorAll(".item-check").length;
        document.querySelector(".small-grey").textContent = `(${count})`;

        toggleMenuPopup();
        showCartNotif(name);
      }

      renderMenu("ASINAN");

      function showCartNotif(name) {
        const n = document.getElementById("cartNotif");

        const text = n.querySelector(".notification-text");
        text.textContent = name + " added to cart.";

        n.style.display = "flex";

        requestAnimationFrame(() => {
          n.classList.add("show");
        });

        setTimeout(() => {
          n.classList.remove("show");

          setTimeout(() => {
            n.style.display = "none";
          }, 300);
        }, 2000);
      }

      attachEvents();
      calculateTotal();
      updateSelectAllStatus();
      document.querySelector(".small-grey").textContent = "(0)";

      const scrollBox = document.getElementById("variant-scroll");
      const scrollBtn = document.getElementById("scroll-right");

      scrollBtn.addEventListener("click", () => {
        scrollBox.scrollBy({
          left: 150,
          behavior: "smooth",
        });
      });

      const hamburgerBtn = document.getElementById("hamburgerBtn");
const hamburgerIcon = document.getElementById("hamburgerIcon");
const mobileMenu = document.getElementById("mobileMenu");

hamburgerBtn.addEventListener("click", () => {
  const opened = mobileMenu.style.right === "0px";

  if (opened) {
    mobileMenu.style.right = "-100%";
    hamburgerIcon.classList.replace("fa-times", "fa-bars");
  } else {
    mobileMenu.style.right = "0";
    hamburgerIcon.classList.replace("fa-bars", "fa-times");
  }
});