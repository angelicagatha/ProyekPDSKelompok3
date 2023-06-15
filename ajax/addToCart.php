<?php
    require_once "../user/koneksi.php";

    $idUser = $_GET['id_user'];
    $idBuku = $_GET['idBuku'];
    $quantity = $_GET['quantity'];

    $sql = "SELECT *
            FROM cart
            WHERE idUser = ".$idUser." AND idBuku = ".$idBuku;
    $stmt = $conn->query($sql);

    if ($stmt->num_rows < 1) {
        $sql = "INSERT INTO cart(idUser, idBuku, quantity)
                VALUES (". $idUser .",". $idBuku .",". 0 .")";
        $stmt = $conn->query($sql);
    }

    $sql = "UPDATE cart
            SET quantity = quantity + ".$quantity." WHERE idUser = ".$idUser." AND idBuku = ".$idBuku;
    $conn-> query($sql);

    $link = null;
?>
