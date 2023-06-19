<!DOCTYPE html>
<html>

<head>
    <title>Backend | Create Books </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
        <style type="text/css">
        .section {
     margin: 30px;
     max-width: 500px;
     /* text-align: center; */
}
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif; font-size: 20px;">
    <?php
    require_once "koneksi.php";
    ?>


    <!-- Content -->
    <div class="section">
    <div class="container mt-5">
        <div class="row justify">
            <div class="col-md-6">
            <div class="card">

            <div class="card-header text-center">
                ADD BUKU
            </div>

            <div class="card-body">
     
            <form  action="uploadingBooks.php" method="post" enctype="multipart/form-data">
                <table>
                <tr>
                <!-- insert nama buku -->
                <td><label for="namaBuku">Nama Buku : </label></td>
                <td><input type="text" name="namaBuku"></td>
               
                </tr>
                <tr>
                <!--insert cover buku-->
                <td><label for="coverBuku">Cover : </label></td>
                <td><input type="file" name="file"></td>
                
                </tr>
                <tr>
                <!--insert deskripsi buku-->
                <td><label for="descBuku">Deskripsi Buku : </label></td>
            
                <td><textarea name="descBuku" cols="51" rows="5"></textarea></td>
                 
                </tr>
                <tr>
                <!--insert penulis buku-->
                <td><label for="penulisBuku">Penulis : </label></td>
                <td><input type="text" class="form-control" name="penulisBuku"></td>
                
                </tr>
                <!-- insert penerbit buku--> 
                <tr>
                <td><label for="penerbitBuku">Penerbit : </label></td>
                <td><input type="text" class="form-control" name="penerbitBuku"></td>
                
                </tr>
                <tr>
                <!--insert tanggal terbit-->
                <td><label for="tanggalTerbit">Tanggal Terbit:</label></td>
                <td><input type="date" class="form-control" name="tanggal_terbit" id="tanggalTerbit">
                </td> 
                </tr>
                <tr>
                <!--insert kategori-->
                <td><label for="kategoriBuku">Kategori :</label></td>
                <td><select name="select_box" class="form-select" id="select_box">
                <option value="">Pilih Kategori</option>
                    <?php
                    $simpanKategori = "SELECT * FROM kategori";
                    $hasilKategori = $conn->query($simpanKategori);
                    while ($row = $hasilKategori->fetch_assoc()) {
                        $id = $row['id_kategori'];
                        $kategori = "SELECT * FROM kategori WHERE id_kategori=$id";
                        $simpan = mysqli_query($conn, $kategori);
                        $hasil1 = $simpan->fetch_assoc();
                        $hasil = $hasil1['nama_kategori'];
                        echo "<option name='pilihan' value='" . $id . "'>" . $row['nama_kategori'] ."</option>";
                    }
                    mysqli_close($conn); 
                    ?>
                </select>
                </td>
                </tr>
                
                <tr>
                <!-- insert status--> 
                <td><label for="statusBuku">Status :</label></td>
                <td><select name="select_box2" class="form-select" id="select_box2">
                    <option value="">Pilih Status</option> 
                    <option value="0">Tidak Tersedia</option>
                    <option value="1">Tersedia</option> 
                </select> 
                </td>
                </tr>
                <tr>
                <td><input class="btn btn-primary" name="submit" type="submit" value="Add"></td>
                </tr>
            </table>
            </form>
            
        </div>
            </div>
            </div>
    </div>
    </div>

    <script>
    </script>
</body>

</html>
