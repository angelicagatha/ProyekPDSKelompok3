<?php
    require_once "../user/koneksi.php";

    $idUser = $_GET['idUser'];
    $idBuku = $_GET['idBuku'];

    $sql = "DELETE FROM cart WHERE idUser = ? AND idBuku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUser, $idBuku);
    $stmt->execute();
    $result = $stmt->get_result();
?>
