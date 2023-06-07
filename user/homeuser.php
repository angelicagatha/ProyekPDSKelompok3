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
      <li><a class="active" href="homeuser.php">Home</a></li>
      <li style="text-align: right;"><a href="logoutuser.php">Logout</a></li>
    </ul>
    <h1 style="text-align: center;">List Buku Perpustakaan</h1>
    <?php
      include '../searchbook.php';
    ?> 
      <div class="book-container">
          <?php
              require_once "koneksi.php";

              $query = "SELECT id_buku, cover_buku, nama_buku, penulis, penerbit, deskripsi, tanggal_terbit, status.keterangan_status, kategori.nama_kategori
                        FROM buku
                        INNER JOIN kategori ON kategori.id_kategori = buku.kategori
                        INNER JOIN status ON status.id_status = buku.status";
              $result = $conn->query($query);

              if ($result->num_rows>0) {
                echo '<div class="book-list">';
                while ($row = $result->fetch_assoc()) {
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
          ?>
      </div>
  </body>
</html>
