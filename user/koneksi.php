<?php

$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

if (!$conn) { // jika tidak terkoneksi maka menampilkan pesan error
    die("Gagal terhubung ke database : " . mysqli_connect_errno());
}