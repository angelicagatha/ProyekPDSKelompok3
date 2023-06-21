<?php
  require_once 'koneksi.php';

  session_start();

  if(!isset($_SESSION['email_admin'])){

    header("location: homeadmin.php");
    exit;
  }
  $email_admin = $_SESSION['email_admin'];
?>

<!DOCTYPE html>
<html>
  <head>
      <title>List Buku Perpustakaan</title>
      <style>
         
        .book-card {
          width: 300px;
          border: 1px solid #ccc;
          border-radius: 5px;
          padding: 20px;
          margin: 10px;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          height: auto;
        }

        .book-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-description {
            font-size: 14px;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            height: 60px; /* Atur tinggi sesuai kebutuhan */
        }

        .book-cover {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .book-list {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          grid-gap: 20px;
        }

        ul {
          list-style-type: none;
          margin: 0;
          padding: 0;
          overflow: hidden;
          background-color: #333;
        }

        li {
          float: left;
        }

        li a {
          display: block;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
        }

        li a:hover:not(.active) {
          background-color: #111;
        }

        .active {
          background-color: #04AA6D;
        }
      </style>
  </head>

  <body>
  <ul>
        <li><a class="active" href="homeadmin.php">Buku</a></li>
      <li><a class="" href="riwayat.php">Riwayat</a></li>
      <li><a class="" href="daftarUser.php">User</a></li>
      <li><a href="logoutadmin.php">Logout</a></li>
      <li class="active" style="float:right"><a href="#">Welcome, <?php echo $email_admin?>!</a></li>
        </ul>
        <a href="create.php" class="btn btn-submit" style="" type="button">create</a>
        <br>

        <title>Pencarian Buku</title>
</head>

<body>
    
    <h1 style="text-align: center;">List Buku Perpustakaan</h1>
    <h1>Pencarian Buku</h1>
    <form action="" method="GET">
        <input type="text" name="keyword" placeholder="Masukkan kata kunci">
        <button type="submit">Cari</button>
    </form>
    <br>
    
    <!-- <?php
      include '../searchbook.php';

    ?>  -->
      <div class="book-container">
          <?php
            require_once "koneksi.php";
      
            if (!empty($keyword)) {
                if ($results) {
                    echo "<h3>Hasil pencarian untuk keyword '{$keyword}':</h3>";
                    echo '<div class="book-container">';
                    foreach ($results as $book) {
                        echo '<div class="book-card">';
                        echo '<p>Kategori: ' . $book['nama_kategori'] . '</p>';
                        echo '<img src="../img/' . $book['file_name'] . '" alt="Cover Buku">';
                        echo '<h3>' . $book['nama_buku'] . '</h3>';
                        echo '<p>' . $book['penulis'] . '</p>';
                        echo '<p>Deskripsi: ' . $book['deskripsi'] . '</p>';
                        echo '<p>Tanggal Terbit: ' . $book['tanggal_terbit'] . '</p>';
                        echo '<p>Penerbit: ' . $book['penerbit'] . '</p>';
        
                        if ($book['status_buku'] == 1) {
                            echo '<p style="color: green;">Status: [Tersedia]</p>';
                            // echo '<div class="card-footer">
                            //         // <a href="" class="btn btn-sm text-dark p-0" onclick="addToCart(' . $book['id'] . ')">
                            //         //     <i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart
                            //         // </a>
                            //         </div>';
                        } else {
                            echo '<p style="color: red;">Status: [Tidak Tersedia]</p>';
                        }
                        echo '<table><tr><td>
    <form action="update.php" method="post">
                    
                    <a href="update.php?id='.$book['id'].'" class="btn btn-submit" type="button">update</a>
                </form><td>';
                    echo '<td><a href="delete.php?id='.$book['id'].'" class="btn btn-submit" type="button" onClick="return confirm("Are you sure you want to delete?")">Delete</a></td></tr></table>';
                        echo '</div>';
                    }
                    echo '</div>';
                              
                } else {
                    echo "<h3>Tidak ditemukan buku untuk keyword '{$keyword}'</h3>";
                }
            }
        
              // Query untuk mendapatkan buku terlaris
$query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status_buku, kategori.nama_kategori, jumlah_peminjaman,
FIND_IN_SET(jumlah_peminjaman, (SELECT GROUP_CONCAT(jumlah_peminjaman ORDER BY jumlah_peminjaman DESC) FROM books)) AS peringkat
FROM books
INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
INNER JOIN status ON status.id_status = books.status
ORDER BY jumlah_peminjaman DESC
LIMIT 5";
$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
$rows = array();
while ($row = $result->fetch_assoc()) {
$rows[] = $row;
}
}

echo '<div class="book-container">
<h2 style="text-align: center;">Buku Terlaris</h2>
<div class="book-list">';

for ($i = 0; $i < count($rows); $i++) {
$currentRow = $rows[$i];

echo '<div class="book-card">';
echo '<p class="book-peminjaman"><b>Peringkat: ' . ($i + 1) . '</b></p>';
echo '<p>Kategori: ' . $currentRow['nama_kategori'] . '</p>';
echo '<img src="../img/' . $currentRow['file_name'] . '" alt="Cover Buku" class="book-cover">';
echo '<h3 class="book-title">' . $currentRow['nama_buku'] . '</h3>';
echo '<p class="book-author">' . $currentRow['penulis'] . '</p>';
echo '<p class="book-peminjaman">Jumlah Peminjaman: ' . $currentRow['jumlah_peminjaman'] . '</p>';

if ($currentRow['status_buku'] == 1) {
echo '<p class="book-status" style="text-align: right; color: green;">Status: [Tersedia]</p>';
} else {
echo '<p class="book-status" style="text-align: right; color: red;">Status: [Tidak Tersedia]</p>';
}
echo '<table><tr><td>
<form action="update.php" method="post">
          
          <a href="update.php?id='.$currentRow['id'].'" class="btn btn-submit" type="button">update</a>
      </form><td>';
          echo '<td><a href="delete.php?id='.$currentRow['id'].'" class="btn btn-submit" type="button" onClick="return confirm("Are you sure you want to delete?")">Delete</a></td></tr></table>';               
echo '</div>';
}
echo '</div>';

echo '<div class="book-container">
<h2 style="text-align: center;">Kumpulan Buku dan Statusnya</h2>
<div class="book-list">';
              $query = "SELECT id, file_name, nama_buku, penulis, penerbit, deskripsi, tanggal_terbit, status.keterangan_status, kategori.nama_kategori
                        FROM books
                        INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                        INNER JOIN status ON status.id_status = books.status_buku";
              $result = $conn->query($query);

              if ($result->num_rows>0) {
                echo '<div class="book-list">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="book-card">';
                    echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
                    echo '<img src="../img/' . $row['file_name'] . '" alt="Cover Buku" class="book-cover">';
                    echo '<h3 style="text-align: center;">' . $row['nama_buku'] . '</h3>';
                    echo '<p style="text-align: center;">' . $row['penulis'] . '</p>';

                    if ($row['keterangan_status'] == "Tersedia") {
                      echo '<p style="text-align: right; color: green;">Status: [' . $row['keterangan_status'] . ']</p>';
                    } else {
                      echo '<p style="text-align: right; color: red;">Status: [' . $row['keterangan_status'] . ']</p>';
                    }
                    echo '<table><tr><td>
                    <form action="update.php" method="post">
                                    
                                    <a href="update.php?id='.$row['id'].'" class="btn btn-submit" type="button">update</a>
                                </form><td>';
                                    echo '<td><a href="delete.php?id='.$row['id'].'" class="btn btn-submit" type="button" onClick="return confirm("Are you sure you want to delete?")">Delete</a></td></tr></table>';
                    
                    echo '</div>';
                }
                echo '</div>';
              }
          ?>
      </div>
  </body>
</html>
