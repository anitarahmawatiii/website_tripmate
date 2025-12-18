document.addEventListener("DOMContentLoaded", () => {

  /* ================= LOGIN ================= */
  const loginBtn = document.getElementById("loginBtn");

  if (loginBtn) {
    loginBtn.addEventListener("click", () => {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      const errorMessage = document.getElementById("error-message");

      if (!username || !password) {
        errorMessage.textContent = "Username dan password harus diisi!";
        errorMessage.style.color = "red";
        return;
      }

      if (username === "admin" && password === "123") {
        localStorage.setItem("isLoggedIn", "true");
        errorMessage.textContent = "Login berhasil! ✅";
        errorMessage.style.color = "green";

        setTimeout(() => {
          window.location.href = "index.php";
        }, 1000);
      } else {
        errorMessage.textContent = "Username atau password salah!";
        errorMessage.style.color = "red";
      }
    });
  }

 /* ================= DARK MODE ================= */
const toggle = document.getElementById("darkToggle");

if (toggle) {
  // cek mode tersimpan
  const savedTheme = localStorage.getItem("theme");

  if (savedTheme === "dark") {
    document.body.classList.add("dark-mode");
    toggle.textContent = "🌙"; // GELAP → BULAN
  } else {
    toggle.textContent = "☀️"; // TERANG → MATAHARI
  }

  toggle.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
      toggle.textContent = "🌙";        // GELAP → BULAN
      localStorage.setItem("theme", "dark");
    } else {
      toggle.textContent = "☀️";        // TERANG → MATAHARI
      localStorage.setItem("theme", "light");
    }
  });
}

  /* ================= PENCARIAN WISATA ================= */
  const searchInput = document.getElementById("searchInput");
  const hasilContainer = document.getElementById("hasilPencarian");
  const unggulanSection = document.getElementById("unggulanSection");

  const wisataList = [
    "Pantai Mutun",
    "Pantai Sari Ringgung",
    "Pulau Pahawang",
    "Gunung Krakatau",
    "Taman Nasional Way Kambas",
    "Pantai Gigi Hiu",
    "Air Terjun Putri Malu",
    "Pantai Klara",
    "Lembah Hijau Bandar Lampung",
    "Bukit Sakura",
    "Wisata Murah Pesisir Lampung",
    "Pantai Sebalang",
    "Teluk Kiluan"
  ];

  if (searchInput) {
    searchInput.addEventListener("input", () => {
      const input = searchInput.value.toLowerCase();
      hasilContainer.innerHTML = "";

      if (input === "") {
        unggulanSection.style.display = "block";
        return;
      }

      unggulanSection.style.display = "none";

      const hasil = wisataList.filter(w =>
        w.toLowerCase().includes(input)
      );

      if (hasil.length === 0) {
        hasilContainer.innerHTML = "<p>Tidak ditemukan hasil.</p>";
      } else {
        hasil.forEach(nama => {
          hasilContainer.innerHTML += `
            <div class="card">
              <img src="https://source.unsplash.com/400x250/?${encodeURIComponent(nama)}">
              <h3>${nama}</h3>
            </div>
          `;
        });
      }
    });
  }

  /* ================= POPUP ================= */
  const popup = document.getElementById("popup");
  const closePopup = document.getElementById("closePopup");

  if (popup) {
    popup.classList.add("show");
  }

  if (closePopup) {
    closePopup.addEventListener("click", () => {
      popup.classList.remove("show");
    });
  }

});
