<?php
// session_start();

// if (isset($_SESSION['masuk'])) {
//     header("location: homeuser.php");
// }

require '../../../../vendor/Predis/Predis/Autoload.php';

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
        $keyword = mysqli_real_escape_string($koneksi, $keyword);

        $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status_buku, idKategoriBuku, nama_kategori
        FROM books
        INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
        INNER JOIN status ON status.id_status = books.status
        WHERE status = '1' AND (nama_buku LIKE '%$keyword%' OR penulis LIKE '%$keyword%')";

        $result = mysqli_query($koneksi, $query);
        $matching_books = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Simpan hasil pencarian ke cache Redis
        $redis->set($cache_key, json_encode($matching_books));
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
            echo "<h3>Hasil pencarian untuk keyword '{$keyword}':</h3>";
            foreach ($results as $book) {
                echo '<div class="book-card">';
                    echo '<p>Kategori: ' . $book['nama_kategori'] . '</p>';
                    echo '<img src="../img/' . $book['file_name'] . '" alt="Cover Buku" class="book-cover">';
                    echo '<h3 style="text-align: center;">' . $book['nama_buku'] . '</h3>';
                    echo '<p style="text-align: center;">' . $book['penulis'] . '</p>';

                    if ($book['status_buku'] == "Tersedia") {
                        echo '<p style="text-align: right; color: green;">Status: [' . $book['status_buku'] . ']</p>';
                    } else {
                        echo '<p style="text-align: right; color: red;">Status: [' . $book['status_buku'] . ']</p>';
                    }    
                echo '</div>';
            }
        } else {
            echo "<h3>Tidak ditemukan buku</h3>";
        }
    ?>
            
    </body>
</html>