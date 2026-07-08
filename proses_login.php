<?php
session_start();
include "koneksi.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    // Mengubah $conn menjadi $koneksi biar sama dengan file koneksi.php kamu
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM user_login
        WHERE username='$username'
        AND password='$password'
        AND status='aktif'");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");
        exit();

    } else {

        header("Location: index.php?error=1");
        exit();

    }

} else {

    header("Location: index.php");
    exit();

}
?>