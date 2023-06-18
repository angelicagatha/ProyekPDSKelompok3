<?php
    require_once 'koneksi.php';

    $idPinjam = $_POST['idPinjam'];
    $idBuku = $_POST['idBuku'];
    $tanggal_kembali = date('Y-m-d');

    $query = "UPDATE riwayat
    SET tanggal_kembali = ?
    WHERE id_pinjam = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $tanggal_kembali, $idPinjam);
    $stmt->execute();

    $query2 = "UPDATE books SET status_buku = 1 WHERE id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $idBuku);
    $stmt2->execute();

    header("location: riwayat.php");
?>