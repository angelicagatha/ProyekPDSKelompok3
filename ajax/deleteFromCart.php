<?php
    require_once "../user/koneksi.php";

    $idUser = $_GET['idUser'];
    $idBarang = $_GET['idBuku'];

    $sql = "DELETE FROM cart 
            WHERE idUser = ".$idUser." AND idBuku = ".$idBuku;
    $conn->query($sql);
    
    $link = null;
?>
