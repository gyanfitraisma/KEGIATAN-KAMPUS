<?php
// Memulai atau mengaktifkan kembali sesi yang sedang berjalan di server agar bisa dimanipulasi
session_start();

// JIKA ADMIN MEMILIH "YA, LOGOUT" (Mengklik tombol konfirmasi)
if (isset($_GET['action']) && $_GET['action'] === 'confirm') {
    // Menghancurkan dan menghapus seluruh data sesi yang terdaftar untuk pengguna saat ini dari memori server
    session_destroy();

    // Mengarahkan (redireksi) browser pengguna secara otomatis kembali ke halaman login utama (index.php)
    header("Location: index.php");
    // Menghentikan seluruh proses eksekusi skrip PHP selanjutnya secara instan demi keamanan sistem
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout - Sistem Kampus</title>
    <!-- CSS Bootstrap bawaan proyek kalian -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Memanggil library SweetAlert2 lewat CDN alternatif yang lebih cepat & stabil -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* Menggunakan transparan penuh di awal agar tidak abu-abu kosong jika loading lambat */
        body {
            background-color: transparent;
            height: 100vh;
            margin: 0;
        }
        /* Efek blur & gelap halus yang hanya aktif pada elemen backdrop bawaan SweetAlert */
        .swal2-backdrop-show {
            backdrop-filter: blur(4px) !important;
            background: rgba(0, 0, 0, 0.5) !important;
        }
    </style>
</head>
<body>

    <script>
        // Memastikan SweetAlert2 sudah ter-load dengan sempurna sebelum dijalankan
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin logout dari Sistem Pendaftaran Kegiatan Kampus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545', // Tombol merah untuk logout
                    cancelButtonColor: '#6c757d',  // Tombol abu-abu untuk batal
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal',
                    reverseButtons: true, // Menaruh Batal di kiri, Ya di kanan
                    allowOutsideClick: false, // Mencegah klik luar untuk menutup
                    customClass: {
                        popup: 'rounded-4 shadow-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'logout.php?action=confirm';
                    } else {
                        window.location.href = 'dashboard.php';
                    }
                });
            } else {
                // FALLBACK CADANGAN: Jika CDN internet mendadak down/terblokir, pakai konfirmasi bawaan browser agar tidak error
                if (confirm("Apakah Anda yakin ingin logout dari Sistem Pendaftaran Kegiatan Kampus?")) {
                    window.location.href = 'logout.php?action=confirm';
                } else {
                    window.location.href = 'dashboard.php';
                }
            }
        });
    </script>

</body>
</html>