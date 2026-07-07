// ===============================
// REGISTER USER
// ===============================

const form = document.querySelector("form");

const nama = document.querySelector('input[placeholder="Masukkan nama lengkap"]');
const username = document.querySelector('input[placeholder="Masukkan username"]');
const email = document.querySelector('input[type="email"]');
const hp = document.querySelector('input[placeholder="08xxxxxxxxxx"]');

const password = document.querySelectorAll('input[type="password"]')[0];
const konfirmasi = document.querySelectorAll('input[type="password"]')[1];

const role = document.querySelectorAll("select")[0];
const status = document.querySelectorAll("select")[1];

const cek = document.getElementById("cek");

// ===============================
// SHOW / HIDE PASSWORD
// ===============================

const tombolMata = document.querySelectorAll(".input-group-text");

tombolMata.forEach(function(btn, index){

    btn.style.cursor = "pointer";

    btn.addEventListener("click", function(){

        const input = index === 0 ? password : konfirmasi;
        const icon = btn.querySelector("i");

        if(input.type === "password"){

            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");

        }else{

            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");

        }

    });

});

// ===============================
// VALIDASI REGISTER
// ===============================

form.addEventListener("submit", function(e){

    e.preventDefault();

    if(nama.value.trim() === ""){
        alert("Nama lengkap harus diisi.");
        nama.focus();
        return;
    }

    if(username.value.trim() === ""){
        alert("Username harus diisi.");
        username.focus();
        return;
    }

    if(email.value.trim() === ""){
        alert("Email harus diisi.");
        email.focus();
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!emailRegex.test(email.value)){
        alert("Format email tidak valid.");
        email.focus();
        return;
    }

    if(hp.value.trim() === ""){
        alert("Nomor HP harus diisi.");
        hp.focus();
        return;
    }

    const hpRegex = /^08[0-9]{8,11}$/;

    if(!hpRegex.test(hp.value)){
        alert("Nomor HP tidak valid.");
        hp.focus();
        return;
    }

    if(password.value === ""){
        alert("Password harus diisi.");
        password.focus();
        return;
    }

    if(password.value.length < 6){
        alert("Password minimal 6 karakter.");
        password.focus();
        return;
    }

    if(konfirmasi.value === ""){
        alert("Konfirmasi password harus diisi.");
        konfirmasi.focus();
        return;
    }

    if(password.value !== konfirmasi.value){
        alert("Password dan konfirmasi password tidak sama.");
        konfirmasi.focus();
        return;
    }

    if(role.selectedIndex === 0){
        alert("Silakan pilih role user.");
        role.focus();
        return;
    }

    if(!cek.checked){
        alert("Silakan centang pernyataan terlebih dahulu.");
        return;
    }

    alert("Registrasi berhasil!");

    form.reset();

});

// ===============================
// RESET PASSWORD
// ===============================

form.addEventListener("reset", function(){

    setTimeout(function(){

        password.type = "password";
        konfirmasi.type = "password";

        tombolMata.forEach(function(btn){

            const icon = btn.querySelector("i");

            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");

        });

    },10);

});
// ==========================================
// 1. LOGIKA JAM & TANGGAL OTOMATIS
// ==========================================
function updateJam() {
    const sekarang = new Date();
    const jamElement = document.getElementById("jam");
    const tanggalElement = document.getElementById("tanggal");

    if (jamElement) {
        jamElement.innerHTML = sekarang.toLocaleTimeString("id-ID");
    }

    if (tanggalElement) {
        tanggalElement.innerHTML = sekarang.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric"
        });
    }
}
updateJam();
setInterval(updateJam, 1000);

// ==========================================
// 2. LOGIKA SIMPAN DATA KE LOCALSTORAGE
// ==========================================
const form = document.getElementById('formPendaftaran');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Menghentikan browser agar tidak reload halaman

        // Mengambil seluruh data dari input form
        const formData = new FormData(this);
        const dataPesertaBaru = {};
        
        formData.forEach((value, key) => {
            if (key === 'foto') {
                dataPesertaBaru[key] = value.name || 'default.png';
            } else {
                dataPesertaBaru[key] = value;
            }
        });

        // Ambil data lama atau buat array baru jika kosong
        let listPeserta = JSON.parse(localStorage.getItem('databasePeserta')) || [];

        // Masukkan data baru ke array
        listPeserta.push(dataPesertaBaru);

        // Simpan kembali ke localStorage
        localStorage.setItem('databasePeserta', JSON.stringify(listPeserta));

        // Notifikasi & Redirect halaman
        alert('Sukses! Data pendaftaran berhasil disimpan.');
        window.location.href = 'data-peserta.html';
    });
}
