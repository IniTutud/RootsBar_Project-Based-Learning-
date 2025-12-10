     
/// =============================================
// INITIAL RATING STATE
// =============================================
let ratingCounts = [0, 0, 0, 0, 0];

// =============================================
// SETUP CHART (KOSONG DULU)
// =============================================
const ctx = document.getElementById("ratingChart").getContext("2d");

const ratingChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["★", "★★", "★★★", "★★★★", "★★★★★"],
        datasets: [
            {
                label: "Jumlah Rating",
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
                    stepSize: 1,
                    beginAtZero: true,
                },
            },
        },
        plugins: { legend: { display: false } },
    },
});

// =============================================
// FETCH GRAPH DATA FROM DB
// =============================================
function loadRatingGraph() {
    fetch("get_rating_stats.php")
        .then((r) => r.json())
        .then((data) => {
            ratingCounts = data;
            updateChart();
            updateAverage();
        })
        .catch((err) => console.error("Graph ERR:", err));
}

// Panggil pertama kali
loadRatingGraph();

// =============================================
// Update Chart
// =============================================
function updateChart() {
    ratingChart.data.datasets[0].data = ratingCounts;
    ratingChart.update();
}


// =============================
// FETCH REVIEW CARDS
// =============================
fetch("get_reviews.php")
    .then(r => r.json())
    .then(reviews => renderReviewCards(reviews));

function renderReviewCards(reviews) {
    const container = document.querySelector(".flex.flex-wrap.justify-center.gap-1");
    container.innerHTML = "";

    if (!reviews || reviews.length === 0) return;

    // Acak urutan review
    reviews.sort(() => Math.random() - 0.5);

    // Ambil 4 teratas (random hasil shuffle)
    const limited = reviews.slice(0, 4);

    limited.forEach(r => {
        // Random rotate untuk card aesthetic
        const rotate = (Math.random() * 8 - 4).toFixed(1); // -4° sampai +4°
        const offsetY = (Math.random() * 10 - 5).toFixed(1); // naik turun 5px

        container.innerHTML += `
        <div
            class="bg-[url('Properties/Menu_Section/paper.png')] bg-cover bg-no-repeat text-black rounded-2xl shadow-xl w-[280px] sm:w-[300px] p-6 pb-40 relative transition-transform duration-300 hover:scale-[1.04] hover:-translate-y-1 hover:rotate-0"
            style="transform: rotate(${rotate}deg) translateY(${offsetY}px); "
        >

        <img src="Properties/Menu_Section/clip.png"
             class="w-[80px] absolute top-[-20px] left- transform -translate-x-1/2 pointer-events-none"/>
            <div class="mt-[40px] ml-[30px]">
              <div class="flex gap-1 text-yellow-400 mb-2 text-lg">
                ${"★".repeat(r.stars)}
              </div>

              <p class="text-sm leading-snug mb-6 pt-[7px]">${r.review}</p>

              <div class="flex items-center gap-3 pt-[5px]">
                <img src="https://i.pravatar.cc/40?u=${r.id}"
                     class="w-8 h-8 rounded-full border-2 border-white">
                <div>
                  <p class="text-sm font-semibold">User #${r.id}</p>
                  <p class="text-xs text-black/70">@anonymous</p>
                </div>
              </div>
            </div>
        </div>
        `;
    });
}


// =============================
// STAR RATING SELECTOR
// =============================
const stars = document.querySelectorAll("#starContainer i");

stars.forEach(star => {
    star.addEventListener("mouseover", () => highlightStars(star.dataset.value));
    star.addEventListener("mouseleave", () => highlightStars(selectedStars));
    star.addEventListener("click", () => {
        selectedStars = parseInt(star.dataset.value);
        highlightStars(selectedStars);
    });
});

function highlightStars(count) {
    stars.forEach((s, i) => {
        if (i < count) {
            s.classList.remove("fa-regular");
            s.classList.add("fa-solid", "text-yellow-400");
        } else {
            s.classList.remove("fa-solid", "text-yellow-400");
            s.classList.add("fa-regular");
        }
    });
}

// =============================
// SUBMIT REVIEW
// =============================
document.getElementById("submitReview").addEventListener("click", () => {

    const review = document.getElementById("reviewText").value.trim();

    if (selectedStars === 0)
        return alert("Please select your star rating!");

    if (review === "")
        return alert("Please write a review!");

    const formData = new FormData();
    formData.append("stars", selectedStars);
    formData.append("review", review);

    fetch("add_review.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.status === "success") {

            // Refresh stats
            fetch("get_rating_stats.php")
                .then(r => r.json())
                .then(data => {
                    ratingCounts = data;
                    updateChart();
                    updateAverage();
                });

            // Refresh review cards
            fetch("get_reviews.php")
                .then(r => r.json())
                .then(reviews => renderReviewCards(reviews));

            alert("Thank you for your review!");

            selectedStars = 0;
            highlightStars(0);
            document.getElementById("reviewText").value = "";
        } else {
            alert("Error: " + res.msg);
        }
    });
});

// =============================
// UPDATE GRAPH + AVERAGE
// =============================
function updateChart() {
    ratingChart.data.datasets[0].data = ratingCounts;
    ratingChart.update();
}

function updateAverage() {
    const totalReviews = ratingCounts.reduce((a, b) => a + b, 0);
    const totalStars   = ratingCounts.reduce((sum, count, i) => sum + count * (i+1), 0);

    const avg = totalStars / totalReviews || 0;

    document.getElementById("avgScore").textContent = avg.toFixed(1);
    document.getElementById("reviewCount").textContent = `${totalReviews} Reviews`;

    const starContainer = document.getElementById("avgStars");
    starContainer.innerHTML = "";

    for (let i = 1; i <= 5; i++) {
        starContainer.innerHTML += `
            <span class="${i <= Math.round(avg) ? "text-yellow-400" : "text-gray-400"} text-xl">★</span>
        `;
    }
}




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




// =======================
// RENDER MENU ITEMS
// =======================
const buttons = document.querySelectorAll(".variant-btn");

buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");

        const category = btn.getAttribute("data-category");
        renderMenu(category);
    });
});


function renderMenu(category) {
    fetch("get_products.php?category=" + encodeURIComponent(category))
        .then(res => res.json())
        .then(data => {

            const container = document.getElementById("menuList");
            container.innerHTML = "";

            data.forEach(item => {

                const card = `
                <div 
                    class="menu-card relative w-[330px] cursor-pointer hover:scale-105 transition duration-300"
                    onclick='toggleMenuPopup(true, ${JSON.stringify(item)})'
                >
                    <!-- FRAME -->
                    <img src="Properties/Menu_Section/paper.png"
                        class="w-[310px] h-[310px] pointer-events-none"/>

                    <!-- PRODUK IMG -->
                    <img src="${item.img}"
                        class="absolute top-[2px] w-[282px] rounded-[20px] object-cover pointer-events-none rotate-[-9deg]"/>

                    <!-- CLIP -->
                    <img src="Properties/Menu_Section/clip.png"
                        class="absolute top-[-40px] right-16 w-[70px] pointer-events-none"/>

                    <!-- TEXT LABEL -->
                    <div class="absolute bottom-4 right-4 text-[#0A2458] font-bold flex flex-col items-center pointer-events-none">
                        <span class="text-[23px] leading-none bg-[#F6D932] px-4 py-2 rounded-[20px] shadow-md">
                            ${item.name}
                        </span>

                        <span class="text-[23px] leading-none bg-[#F6D932] px-4 py-2 rounded-[20px] shadow-md mt-1">
                            ${Math.round(item.price / 1000)}K
                        </span>
                    </div>
                </div>
                `;

                container.innerHTML += card;
            });
        });
}


// =======================
// BUTTON LOGIC
// =======================


// Render default saat masuk halaman
document.addEventListener("DOMContentLoaded", () => {
    renderMenu("ASINAN");
});





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
            ingContainer.innerHTML = item.ingredients
  .map(
    src => `
      <div class="ingredient-item">
        <img src="${src}" style="width:100px !important; height:100px !important; object-fit:contain;">
      </div>
    `
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
    const productId = popup.dataset.productId;

    const tbody = document.querySelector("#cartPopup tbody");

    const existingRow = Array.from(tbody.querySelectorAll("tr")).find(
      (row) => row.querySelector("label").textContent.trim() === name
    );

    if (existingRow) {
        const qtyCell = existingRow.querySelector(".jumlah");
        const newQty = parseInt(qtyCell.textContent) + 1;

        qtyCell.textContent = newQty;
        const cb = existingRow.querySelector(".item-check");
        cb.dataset.qty = newQty;
        cb.dataset.productId = productId;
    } else {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>
              <label class="custom-checkbox">
                <input type="checkbox" class="item-check" 
                    data-price="${price}" 
                    data-qty="1"
                    data-product-id="${productId}"
                    checked>
                <span class="checkmark"></span>
                ${name}
              </label>
            </td>
            <td class="price">Rp.${price.toLocaleString("id-ID")}</td>
            <td class="jumlah" style="text-align:center">1</td>
            <td class="subtotal" style="text-align:right">Rp.${price.toLocaleString("id-ID")}</td>
            <td class="remove"><span class="remove-item">×</span></td>
        `;
        tbody.appendChild(row);
    }

    calculateTotal();
    updateSelectAllStatus();
    attachEvents();
    saveCartToLocalStorage();

    const count = document.querySelectorAll(".item-check").length;
    document.querySelector(".small-grey").textContent = `(${count})`;

    toggleMenuPopup();
    showCartNotif(name);
}

      

      function saveCartToLocalStorage() {
    const items = [];

    document.querySelectorAll("#cartPopup tbody tr").forEach(row => {
        const cb = row.querySelector(".item-check");
        if (!cb) return;

        items.push({
            product_id: cb.dataset.productId || 0,
            name: row.querySelector("label").textContent.trim(),
            price: parseInt(cb.dataset.price),
            qty: parseInt(cb.dataset.qty)
        });
    });

    localStorage.setItem("cartData", JSON.stringify(items));
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