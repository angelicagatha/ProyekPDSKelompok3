<?php
  require_once 'koneksi.php';

  session_start();

  if(!isset($_SESSION['email_admin'])){
    header("location: loginadmin.php");
    exit;
  }
  $email_admin = $_SESSION['email_admin'];
  $id_admin = $_SESSION['id_admin'];

  // $sql = "SELECT * FROM riwayat WHERE id_user_pinjam = ?";
  // $stmt = $conn->prepare($sql);
  // $stmt->bind_param("i", $idUser);
  // $stmt->execute();
  // $riwayat = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
    <head>
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
    <body>
        <ul>
            <li><a href="homeadmin.php">Home</a></li>
            <li><a class="active" href="riwayat.php">Riwayat</a></li>
            <li><a href="logoutadmin.php">Logout</a></li>
            <li class="active" style="float:right"><a href="#">Welcome, <?php echo $email_admin?>!</a></li>
        </ul>

        <!-- Header -->
        <div class="card" style="border-color: black;">
            <div class="card-header">
                <div class="form-check">
                    <div class="row">
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            Buku
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            Jumlah Peminjaman
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            Daftar Peminjam
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $sql2 = "SELECT * FROM books
                      LEFT JOIN riwayat ON riwayat.id_buku_pinjam = books.id
                      LEFT JOIN user ON user.id_user = riwayat.id_user_pinjam";
            $result2 = $conn->query($sql2);
            while($row = $result2->fetch_assoc()) {
        ?>

        <div class="card" style="border-color: black;">
          <div class="card-body">
            <div class="form-check">
              <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5">
                  <img src="../img/<?php echo $row['file_name'] ?>" style="width: 80px">
                  <?php
                      echo $row['nama_buku'];
                  ?>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                  <?php
                      echo $row['jumlah_peminjaman'];
                  ?>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                <button style="display: block;text-align: center;padding: 10px;background-color: #333;color: #fff;
                  text-decoration: none; transition: background-color 0.3s ease;" onclick="openModal(<?php echo $row['id'];?>)">Lihat Disini</button>
                <div id="<?php echo $row['id'];?>" class="modal">
                  <div class="modal-content">
                      <h2><b>Daftar Peminjam Buku <?php echo $row['nama_buku'];?></b></h2>
                      <p style="text-align:justify;">
                        <div class="card" style="border-color: black;">
                          <div class="card-header">
                            <div class="form-check">
                              <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Id User
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Nama User
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                    Jumlah Pinjam
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Tanggal Pinjam
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Tanggal Kembali
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- di looping dari riwayat -->
                        <div class="card" style="border-color: black;">
                          <div class="card-body">
                            <div class="form-check">
                              <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                  <?php echo $row['id_user_pinjam']?>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                <?php echo $row['nama_user']?>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                  <?php echo $row['jumlah_peminjaman']?>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                <?php echo $row['tanggal_pinjam']?>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                  <form method="post" action="button_kembali.php">
                                    <button type="submit" name="button_kembali" style="color: red;">Klik untuk Kembalikan</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </p>
                      <button onclick="closeModal(<?php echo $row['id'];?>)">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <script src="main.js"></script>
      <script>
          function openModal(id) {
            document.getElementById(id).style.display = "block";
          }

          function closeModal(id) {
            document.getElementById(id).style.display = "none";
          }
      </script>

      <!-- Bootstrap JS -->
      <script src="js/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.js"></script>
    </body>
</html>