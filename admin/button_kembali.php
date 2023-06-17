<?php
    require_once 'koneksi.php';

    $tanggal_kembali = '';

    if (isset($_POST['button_kembali'])){
        $timestamp = date('Y-m-d');

        $query = "INSERT INTO riwayat (tanggal_kembali) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $timestamp);
    }

    $menampilkan = "SELECT tanggal_kembali FROM riwayat";
    $result = $conn->query($menampilkan);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $tanggal_kembali = $row['tanggal_kembali'];
    }

    header("location: riwayat.php");
?>