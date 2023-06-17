<?php
    require_once "../user/koneksi.php";

    session_start();

    $idUser = $_GET['idUser'];
    $tanggal_pinjam = date('Y-m-d');

    $sql = "SELECT * FROM cart right JOIN books ON books.id = cart.idBuku WHERE idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();

    while(($row = $result->fetch_assoc())){
        $inserRiwayat = "INSERT INTO riwayat (id_buku_pinjam, id_user_pinjam, tanggal_pinjam) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($inserRiwayat);
        $stmt2->bind_param("iis", $row['idBuku'], $idUser, $tanggal_pinjam);

        if($stmt2->execute()){
            $sql3 = "DELETE FROM cart WHERE idUser = ?";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bind_param("i", $idUser);
            $stmt3->execute();

            $jumlah_peminjaman = $row['jumlah_peminjaman'] + 1;

            $sql4 = "UPDATE books SET status_buku = 0, jumlah_peminjaman = ? WHERE id = ?";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("ii", $jumlah_peminjaman, $row['idBuku']);
            $stmt4->execute();
            
            echo "berhasil menambahkan";
        }else{
            echo "Error: ". $stmt2->error;
        }
    };

    $halaman_baru = "http://localhost/PDS/ProyekPDSKelompok3/user/berhasilcheckout.php";
    header("Location: " . $halaman_baru);
?>