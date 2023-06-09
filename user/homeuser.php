<?php
  require_once 'koneksi.php';

  session_start();

  if(!isset($_SESSION['nama_user'])){

    header("location: loginuser.php");
    exit;
  }
  $username = $_SESSION['nama_user'];
  $id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html>
  <head>
      <title>Home</title>
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
      <li><a class="active" href="homeuser.php">Home</a></li>
      <li><a href="cart.php?idUser=<?php echo $id_user ?>">Cart</a></li>
      <li><a href="logoutuser.php">Logout</a></li>
      <li class="active" style="float:right"><a href="#">Welcome, <?php echo $username?>!</a></li>
    </ul>
    
    <h1 style="text-align: center;">List Buku Perpustakaan</h1>
    <?php include '../searchbook.php'; ?> 

    <?php
      // buku terlaris
      $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status_buku, kategori.nama_kategori, jumlah_peminjaman
                FROM books
                INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                INNER JOIN status ON status.id_status = books.status
                ORDER BY jumlah_peminjaman DESC
                LIMIT 5";
      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) {
        $rows = array();
        while($row = $result->fetch_assoc()){
          $rows[] = $row;
        }
      }

      echo '<div class="book-container">
              <h2 style="text-align: center;">Buku Terlaris</h2>
                <div class="book-list">';

      for ($i = 0; $i < count($rows); $i++) {
        $currentRow = $rows[$i];

        echo '<div class="book-card">';
        echo '<p>Kategori: ' . $currentRow['nama_kategori'] . '</p>';
        echo '<img src="../img/' . $currentRow['file_name'] . '" alt="Cover Buku" class="book-cover">';
        echo '<h3 class="book-title">' . $currentRow['nama_buku'] . '</h3>';
        echo '<p class="book-author">' . $currentRow['penulis'] . '</p>';

        if ($currentRow['status_buku'] == 1) {
          echo '<p class="book-status" style="text-align: right; color: green;">Status: [Tersedia]</p>
                  <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="" class="btn btn-sm text-dark p-0" onclick="addToCart(' . $currentRow['id'] . ')">
                      <i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart
                    </a>
                  </div>';
        } else {
          echo '<p class="book-status" style="text-align: right; color: red;">Status: [Tidak Tersedia]</p>';
        }
        echo '</div>';
      }
      echo '</div>';

      // buku yang tersedia
      $query = "SELECT books.id, file_name, uploaded_on, status, nama_buku, deskripsi, penulis, tanggal_terbit, penerbit, status_buku, kategori.nama_kategori, jumlah_peminjaman
                FROM books
                INNER JOIN kategori ON kategori.id_kategori = books.idKategoriBuku
                INNER JOIN status ON status.id_status = books.status";
      $result = $conn->query($query);

      if ($result && $result->num_rows > 0) { // melakukan pengecekan di database, ada isinya atau tidak
        $rows = array();
        while($row = $result->fetch_assoc()){
          $rows[] = $row;
        }
      }

      echo '<div class="book-container">
          <h2 style="text-align: center;">Buku yang Tersedia</h2>
          <div class="book-list">';

      for ($i = 0; $i < count($rows); $i++) {
        $currentRow = $rows[$i];
        if ($currentRow['status_buku'] == 1) {
          echo '<div class="book-card">';
          echo '<p>Kategori: ' . $currentRow['nama_kategori'] . '</p>';
          echo '<img src="../img/' . $currentRow['file_name'] . '" alt="Cover Buku" class="book-cover">';
          echo '<h3 class="book-title">' . $currentRow['nama_buku'] . '</h3>';
          echo '<p class="book-author">' . $currentRow['penulis'] . '</p>';
          echo '<p class="book-status" style="text-align: right; color: green;">Status: [Tersedia]</p>';
          echo '<div class="card-footer d-flex justify-content-between bg-light border">
                  <a href="" class="btn btn-sm text-dark p-0" onclick="addToCart(' . $currentRow['id'] . ')">
                    <i class="fas fa-shopping-cart text-primary mr-1"></i> Add To Cart
                  </a>
                </div>';
          echo '</div>';
        }
      }
      echo '</div>';

      // buku sedang dipinjam
      echo '<div class="book-container">
              <h2 style="text-align: center;">Buku sedang Dipinjam</h2>
                <div class="book-list">';

      for ($i = 0; $i < count($rows); $i++) {
        $currentRow = $rows[$i];
        if ($currentRow['status_buku'] == 0) {
          echo '<div class="book-card">';
          echo '<p>Kategori: ' . $currentRow['nama_kategori'] . '</p>';
          echo '<img src="../img/' . $currentRow['file_name'] . '" alt="Cover Buku" class="book-cover">';
          echo '<h3 class="book-title">' . $currentRow['nama_buku'] . '</h3>';
          echo '<p class="book-author">' . $currentRow['penulis'] . '</p>';
          echo '<p class="book-status" style="text-align: right; color: red;">Status: [Tidak Tersedia]</p>';
          echo '</div>';
        }
      }
      echo '</div>';
    ?>

    <script>
        function addToCart(idBuku) {
            var quantity = 1;
            var idUser = <?php echo $_SESSION['id_user'];?>;
            var url = "http://localhost/PDS/ProyekPDSKelompok3/ajax/addToCart.php?idUser=" + idUser + "&quantity=" + quantity + "&idBuku=" + idBuku;

            window.location.href = url;

            alert("Added to Cart SUCCESSFULY");
        }
      </script>
  </body>
</html>