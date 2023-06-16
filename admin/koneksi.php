<?php

// pny reg dan vir
// $conn = mysqli_connect("localhost", "root", "", "perpustakaan");

// pny caca
$conn = mysqli_connect("localhost", "root", "", "library");

if (!$conn) { // jika tidak terkoneksi maka menampilkan pesan error
    die("Gagal terhubung ke database : " . mysqli_connect_errno());
}