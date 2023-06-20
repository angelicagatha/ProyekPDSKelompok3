<?php
  require_once 'koneksi.php';

  session_start();

  if(!isset($_SESSION['email_admin'])){
    header("location: loginadmin.php");
    exit;
  }

  $email_admin = $_SESSION['email_admin'];
?>

<!DOCTYPE html>
<html>
  <head>
      <title>User Perpustakaan</title>
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
        table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
      </style>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">

<?php $query = "SELECT nama_user,id_user_pinjam,tanggal_pinjam, COUNT(*)
      FROM riwayat r JOIN user u ON r.id_user_pinjam = u.id_user Group by id_user_pinjam order by count(*) desc";
              $result = $conn->query($query);?>
  <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	axisY: {
		title: "JUMLAH BUKU"
	},
	axisX: {
		title: "NAMA USER "
	},
	data: [{
		type: "column",
		// yValueFormatString: "#,##0.0#\"%\"",
		dataPoints: [
      <?php $count = 0;
        foreach ($result as $data) { 
          if ($count!=0) {
            echo ", ";
          }
			echo '{ label: "'.$data['nama_user'].'", y: '.$data['COUNT(*)'].' }';
      $count++; 
      } ?>	
		]
	}]
});
chart.render();
}

    </script>
  </head>

  <body>
    <ul>
      <li><a class="" href="homeadmin.php">Buku</a></li>
      <li><a class="" href="riwayat.php">Riwayat</a></li>
      <li><a class="active" href="daftarUser.php">User</a></li>
      <li><a href="logoutuser.php">Logout</a></li>
      <li class="active" style="float:right"><a href="#">Welcome, <?php echo $email_admin?>!</a></li>
    </ul>
    
    <h1 style="text-align: center;">User Teraktif</h1>

      <div class="book-container">
          <?php
              require_once "koneksi.php";

              $query = "SELECT id_user_pinjam,COUNT(*)
                        FROM riwayat Group by id_user_pinjam order by count(*) desc";
              $result = $conn->query($query);
              echo '<div id="chartContainer" style="height: 370px; width: 100%;"></div>';
              echo '<table id="myTable">
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Jumlah Pinjam</th>
                    <th>Detail Peminjaman</th>';
              if ($result->num_rows>0) {
                echo '<div class="user-list">';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr><div class="user-card">';
                    $idUser = $row['id_user_pinjam'];
                    $query2 = "SELECT nama_user,email from user where id_user = $idUser";
                    $result2 = $conn->query($query2);
                    $user=$result2->fetch_assoc();
                    echo '<td><p>' . $user['nama_user'] . '</p></td>';
                    echo '<td><p>' . $user['email'] . '</p></td>';
                    echo '<td><p>' .  $row['COUNT(*)'] . '</p></td>';
                    echo '<td> <button style="display: block;text-align: center;padding: 10px;background-color: #333;color: #fff;
                    text-decoration: none; transition: background-color 0.3s ease;" onclick="openModal('.$row['id_user_pinjam'].')">Lihat Disini</button>
                  </td>
                  <div id="'. $row['id_user_pinjam'].'" class="modal">
                  <div class="modal-content">
                  <h3> Buku yang Dipinjam '.$user['nama_user'].'</h3>';?>
                  <p style="text-align:justify;">
                        <div class="card" style="border-color: black;">
                          <div class="card-header">
                            <div class="form-check">
                              <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Nama Buku
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Penulis
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    Penerbit
                                </div>
                                <!-- <div class="col-sm-3 col-md-3 col-lg-3">
                                    Tanggal Kembali
                                </div> -->
                              </div>
                            </div>
                          </div>
                        </div>
                  <?php
                  $query3 = "SELECT id_buku_pinjam from riwayat where id_user_pinjam=$idUser";
                  $result3 = $conn->query(($query3));
              
                  if ($result3->num_rows>0) {
                    while ($row3 = $result3->fetch_assoc()) {
                      $buku = $row3['id_buku_pinjam'];
                      $query4 = "SELECT * from books where id=$buku";
                      $result4 = $conn->query(($query4));
                      $book=$result4->fetch_assoc();
                      echo '<div class="card" style="border-color: black;">
                      <div class="card-body">
                        <div class="form-check">
                          <div class="row">
                            <div class="col-sm-3 col-md-3 col-lg-3">';
                              echo $book['nama_buku'];
                            echo '</div>
                            <div class="col-sm-3 col-md-3 col-lg-3">';
                            echo $book['penulis'];
                            echo '</div>
                            <div class="col-sm-3 col-md-3 col-lg-3">';
                              echo $book['penerbit'];
                            echo '</div>
                            </div>
                        </div>
                      </div>
                    </div>';
                    }
                    }
                  ?> 
                      </p>
                      <button onclick="closeModal(<?php echo $row['id_user_pinjam'] ?>)">Close</button>
                  
                  </div></div>
                  <?php
                    echo '</div></tr>';
                }
                echo '</div></table>';
              }
              
          ?>
      </div>
      <script src="main.js"></script>
      <script>
          function openModal(id) {
            document.getElementById(id).style.display = "block";
          }

          function closeModal(id) {
            console.log(id);
            document.getElementById(id).style.display = "none";
          }
      </script>
      
      <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

  </body>
</html>
