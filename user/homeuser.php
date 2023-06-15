<?php
  require_once 'koneksi.php';

  session_start();

  if(!isset($_SESSION['nama_user'])){
    header("location: loginuser.php");
    exit;
  }

  $username = $_SESSION['nama_user'];
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

      <script>
        function addToCart(idBuku) {
            var xmlhttp = new XMLHttpRequest();
            var quantity = 1;
            var idUser = <?php echo $_SESSION['user'];?>;

            xmlhttp.open("GET", "ajax/addToCart.php?idUser=" + idUser + "&quantity=" + quantity + "&idBuku=" + idBuku, true);
            xmlhttp.send();

            alert("Added to Cart SUCCESSFULY");
        }
      </script>
  </head>

  <body>
    <ul>
      <li><a class="active" href="homeuser.php">Home</a></li>
      <li><a href="cart.php?idUser=<?php echo $_SESSION['user'] ?>">Cart</a></li>
      <li><a href="logoutuser.php">Logout</a></li>
      <li class="active" style="float:right"><a href="#">Welcome, <?php echo $_SESSION['nama_user'];?>!</a></li>
    </ul>
    
    <h1 style="text-align: center;">List Buku Perpustakaan</h1>
    <?php include '../searchbook.php'; ?> 

    <div class="book-container">
      <h2 style="text-align: center;">Buku Terlaris</h2>
      <?php
        require_once "koneksi.php";

        $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status_buku, idKategoriBuku, nama_kategori, jumlah_peminjaman
                  FROM books
                  INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                  INNER JOIN status ON status.id_status = books.status
                  ORDER BY jumlah_peminjaman DESC
                  LIMIT 5";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
          echo '<div class="book-list">';
          while ($row = $result->fetch_assoc()) {
            echo '<div class="book-card">';
            echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
            echo '<img src="../img/' . $row['file_name'] . '" alt="Cover Buku" class="book-cover">';
            echo '<h3 class="book-title">' . $row['nama_buku'] . '</h3>';
            echo '<p class="book-author">' . $row['penulis'] . '</p>';

            if ($row['status_buku'] == 1) {
              echo '<p class="book-status" style="text-align: right; color: green;">Status: [Tersedia]</p>';
            } else {
              echo '<p class="book-status" style="text-align: right; color: red;">Status: [Tidak Tersedia]</p>';
            }

            echo '<div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="" class="btn btn-sm text-dark p-0" onclick="addToCart(' . $row['id'] . ')">
                      <i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart
                    </a>
                  </div>';
            echo '</div>';
          }
          echo '</div>';
        } else {
          echo '<p>Tidak ada buku yang tersedia.</p>';
        }
      ?>
    </div>
    
    <div class="book-container">
      <h2 style="text-align: center;">Buku yang Tersedia</h2>
      <?php
        require_once "koneksi.php";

        $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status.keterangan_status, kategori.nama_kategori
                  FROM books
                  INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                  INNER JOIN status ON status.id_status = books.status_buku
                  WHERE status_buku = '1'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          echo '<div class="book-list">';
          while ($row = $result->fetch_assoc()) {
              echo '<div class="book-card">';
                echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
                echo '<img src="../img/' . $row['file_name'] . '" alt="Cover Buku" class="book-cover">';
                echo '<h3 class="book-title">' . $row['nama_buku'] . '</h3>';
                echo '<p class="book-author">' . $row['penulis'] . '</p>';
                echo '<p class="book-status" style="text-align: right; color: green;">Status: [Tersedia]</p>';
              echo '</div>';
          }
          echo '</div>';
        } else {
            echo '<p>Tidak ada buku yang tersedia.</p>';
        }
      ?>
    </div>

    <div class="book-container">
      <h2 style="text-align: center;">Buku sedang Dipinjam</h2>
      <?php
        $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status.keterangan_status, kategori.nama_kategori
                  FROM books
                  INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                  INNER JOIN status ON status.id_status = books.status_buku
                  WHERE status_buku = '0'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          echo '<div class="book-list">';
          while ($row = $result->fetch_assoc()) {
            echo '<div class="book-card">';
              echo '<p>Kategori: ' . $row['nama_kategori'] . '</p>';
              echo '<img src="../img/' . $row['file_name'] . '" alt="Cover Buku" class="book-cover">';
              echo '<h3 style="text-align: center;">' . $row['nama_buku'] . '</h3>';
              echo '<p style="text-align: center;">' . $row['penulis'] . '</p>';
              echo '<p class="book-status" style="text-align: right; color: red;">Status: [Tidak Tersedia]</p>';
            echo '</div>';
          }
          echo '</div>';
        }
      ?>
    </div>
  </body>
</html>