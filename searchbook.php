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


// Fungsi untuk menambahkan buku ke Redis
function add_book($book_id, $book_data)
{
    global $redis;

    // Tambahkan ID buku ke Set 'books:set'
    $redis->sadd('books:set', $book_id);

    // Tambahkan data buku ke Hash 'books:hash:{book_id}'
    $redis->hmset('books:hash:' . $book_id, $book_data);
}

// Fungsi untuk mencari buku berdasarkan kata kunci
function search_book($keyword)
{
    global $redis;

    $matching_books = [];
    $book_ids = $redis->smembers('books:set');

    foreach ($book_ids as $book_id) {
        $book_data = $redis->hgetall('books:hash:' . $book_id);
        foreach ($book_data as $field => $value) {
            if (stripos($value, $keyword) !== false) {
                $matching_books[] = $book_data;
                break;
            }
        }
    }

    return $matching_books;
}

$book1_id = 'book:1';
$book1_data = [
    'judul' => 'Harry Potter and the Philosopher\'s Stone',
    'pengarang' => 'J.K. Rowling',
    'tahun' => '1997',
];

add_book($book1_id, $book1_data);

$book2_id = 'book:2';
$book2_data = [
    'judul' => 'The Lord of the Rings',
    'pengarang' => 'J.R.R. Tolkien',
    'tahun' => '1954',
];

add_book($book2_id, $book2_data);

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
            echo "<p>Judul: " . $book['judul'] . "</p>";
            echo "<p>Pengarang: " . $book['pengarang'] . "</p>";
            echo "<p>Tahun: " . $book['tahun'] . "</p>";
            echo "<hr>";
        }
    } elseif (isset($_GET['keyword'])) {
        echo "<p>Tidak ditemukan buku yang sesuai dengan keyword tersebut.</p>";
    }
    ?>

    <!-- <h2>Tambah Buku</h2>
    <form action="" method="POST">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required><br>

        <label for="pengarang">Pengarang:</label>
        <input type="text" name="pengarang" id="pengarang" required><br>

        <label for="tahun">Tahun:</label>
        <input type="text" name="tahun" id="tahun" required><br>

        <button type="submit">Tambah</button>
    </form> -->
</body>
</html


