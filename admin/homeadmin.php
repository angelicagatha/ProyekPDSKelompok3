<!-- <a href="riwayat.php">RIWAYAT, KLIK DISINI</a> -->
<!DOCTYPE html>
<html>
<head>
       <title>Home</title>
        <title>Riwayat</title>
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

        .modal {
          display: none; 
          position: fixed; 
          z-index: 1; 
          left: 0;
          top: 0;
          text-align: center;
          width: 100%; 
          height: 100%; 
          overflow: auto; 
          background-color: rgba(0, 0, 0, 0.4);
       }

       .modal-content {
          background-color: #fefefe;
          margin: 15% auto;
          padding: 20px;
          border: 1px solid #888;
          width: 50%; 
       }
      </style>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    </head>
    </style>
</head>
<body>
<ul>
<body>
        <ul>
        <li><a class="active" href="homeadmin.php">Buku</a></li>
      <li><a class="" href="riwayat.php">Riwayat</a></li>
      <li><a class="" href="daftarUser.php">User</a></li>
      <li><a href="logoutuser.php">Logout</a></li>
      <li class="active" style="float:right"><a href="#">Welcome, <?php echo $email_admin?>!</a></li>
        </ul>
</ul>

<a href="create.php" class="btn btn-primary" type="button">create</a>
        <br>
<?php
// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'perpustakaan'; // db regina, vira
// $database = 'library'; // db caca

// Buat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$koneksi) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}
session_start();

  if(!isset($_SESSION['email_admin'])){
    header("location: loginadmin.php");
    exit;
  }
  $email_admin = $_SESSION['email_admin'];
  $id_admin = $_SESSION['id_admin'];

  $sql = "SELECT * FROM riwayat WHERE id_user_pinjam = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $idUser);
  $stmt->execute();
  $riwayat = $stmt->get_result();


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
    echo '<table><tr><td><form action="update.php" method="post">
                    
                    <a href="update.php?id='.$row['id'].'" class="btn btn-primary" type="button">update</a>
                </form><td>';
                    echo '<td><a href="delete.php?id='.$row['id'].'" class="btn btn-primary" type="button" onClick="return confirm("Are you sure you want to delete?")">Delete</a></td></tr></table>';               
    echo '</div>';
}
echo '</div>';

// Menutup koneksi
$koneksi->close();
?>
</body>
</html>