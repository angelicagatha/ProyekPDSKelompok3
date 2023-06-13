<?php
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

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'perpustakaan';

    $koneksi = mysqli_connect($host, $username, $password, $database);

    if (!$koneksi) {
        die("Gagal terhubung ke database: " . mysqli_connect_error());
    }

    function search_book($keyword){
        global $koneksi, $redis;

        $cache_key = 'search:' . $keyword;
        $cached_results = $redis->get($cache_key);

        if ($cached_results !== null) {
            $query = "SELECT id_buku, cover_buku, nama_buku, penulis, penerbit, deskripsi, tanggal_terbit, status.keterangan_status, kategori.nama_kategori
            FROM buku
            INNER JOIN kategori ON kategori.id_kategori = buku.kategori
            INNER JOIN status ON status.id_status = buku.status
            WHERE nama_buku
            LIKE '%$keyword%'";

            $result = mysqli_query($koneksi, $query);

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
            $redis->set($cache_key, json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC)));
        }
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
        if (isset($_GET['keyword'])) {
            echo "<p>Tidak ditemukan buku yang sesuai dengan keyword tersebut.</p>";
        }
    ?>
</body>
</html>