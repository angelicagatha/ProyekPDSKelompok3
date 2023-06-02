<?php

session_start();

if (isset($_SESSION['masuk'])) {
    header("location: homeuser.php");
}

require '../../../vendor/Predis/Predis/Autoload.php';

use Predis\Client;

$redis_host = 'localhost';
$redis_port = 6379;
$redis_password = null;

$redis = new Client([
    'scheme' => 'tcp',
    'host' => $redis_host,
    'port' => $redis_port,
    'password' => $redis_password,
]);

// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'perpustakaan';

// Buat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// function add_book($book_id, $book_data)
// {
//     global $koneksi;

//     $judul = $book_data['judul'];
//     $pengarang = $book_data['pengarang'];
//     $tahun = $book_data['tahun'];

//     $query = "INSERT INTO buku (id_buku, nama_buku, penulis, penerbit, deskripsi, tanggal_terbit, status) VALUES ('$book_id', '$judul', '$pengarang', '$penerbit', '$deskripsi', '$tahun', '$status')";

//     if (mysqli_query($koneksi, $query)) {
//         echo "Buku berhasil ditambahkan ke database.";
//     } else {
//         echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
//     }
// }

function search_book($keyword)
{
    global $koneksi, $redis;

    $cache_key = 'search:' . $keyword;

    // Cek apakah data buku sudah ada di cache Redis
    $cached_results = $redis->get($cache_key);

    if ($cached_results !== null) {
        // Jika data buku ditemukan di cache, kembalikan hasil pencarian dari cache
        $matching_books = json_decode($cached_results, true);
    } else {
        // Jika data buku tidak ada di cache, lakukan pencarian ke database
        $query = "SELECT id_buku, cover_buku, nama_buku, penulis, penerbit, deskripsi, tanggal_terbit, status.keterangan_status, kategori.nama_kategori
        FROM buku
        INNER JOIN kategori ON kategori.id_kategori = buku.kategori
        INNER JOIN status ON status.id_status = buku.status WHERE nama_buku LIKE '%$keyword%'";

        $result = mysqli_query($koneksi, $query);

        // $matching_books = [];

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="book-list">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="book-card">';
                    echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
                    echo '<img src="../img/' . $row['cover_buku'] . '" alt="Cover Buku" class="book-cover">';
                    echo '<h3 style="text-align: center;">' . $row['nama_buku'] . '</h3>';
                    echo '<p style="text-align: center;">' . $row['penulis'] . '</p>';

                    if ($row['keterangan_status'] == "Tersedia") {
                      echo '<p style="text-align: right; color: green;">Status: [' . $row['keterangan_status'] . ']</p>';
                    } else {
                      echo '<p style="text-align: right; color: red;">Status: [' . $row['keterangan_status'] . ']</p>';
                    }
                    
                    echo '</div>';
            }
            echo '</div>';
        }

        // Simpan hasil pencarian ke cache Redis
        $redis->set($cache_key, json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC)));
    }

    return $matching_books;
}

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $results = search_book($keyword);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Pencarian Buku</title>
</head>

<body>
    <h1>Pencarian Buku</h1>
    <form action="" method="GET">
        <input type="text" name="keyword" placeholder="Masukkan kata kunci">
        <button type="submit">Cari</button>
    </form>
    <br>

    <?php
    if ($results) {
        echo "<h3>==== Buku ini tersedia ==== </h3> ";
        echo "<h3>Hasil pencarian untuk keyword '{$keyword}':</h3>";
        foreach ($results as $book) {
            echo "<p>Judul: " . $book['nama_buku'] . "</p>";
            echo "<p>Penulis: " . $book['penulis'] . "</p>";
            echo "<p>Penerbit: " . $book['penerbit'] . "</p>";
            echo "<p>Deskripsi: " . $book['deskripsi'] . "</p>";
            echo "<p>Tahun/Tanggal/Bulan Terbit: " . $book['tanggal_terbit'] . "</p>";
            echo "<p>Status: " . $book['status'] . "</p>";
            echo "<hr>";
        }
    } elseif (isset($_GET['keyword'])) {
        echo "<p>Tidak ditemukan buku yang sesuai dengan keyword tersebut.</p>";
    }
    ?>
    
</body>

</html>