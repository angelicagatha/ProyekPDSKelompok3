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
    require_once "connection.php";
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
     
            <br>
            <form  action="uploadingBooks.php" method="post" enctype="multipart/form-data">
                <!-- insert nama buku -->
                <label for="namaBuku">Nama Buku : </label>
                <input type="text" name="namaBuku">
                <br>
                <!--insert cover buku-->
                <label for="coverBuku">Cover : </label>
                <input type="file" name="file">
                <br>
                <!--insert deskripsi buku-->
                <label for="descBuku">Deskripsi Buku : </label>
                <br>
                <textarea name="descBuku" cols="51" rows="5"></textarea>
                <br> 

                <!--insert penulis buku-->
                 <label for="penulisBuku">Penulis : </label>
                <input type="text" class="form-control" name="penulisBuku">
                <br> 

                <!-- insert penerbit buku--> 
                <label for="penerbitBuku">Penerbit : </label>
                <input type="text" class="form-control" name="penerbitBuku">
                <br>
                
                <!--insert tanggal terbit-->
                <label for="tanggalTerbit">Tanggal Terbit:</label>
                <input type="date" class="form-control" name="tanggal_terbit" id="tanggalTerbit">
                <br>
                <!--insert kategori-->
                <label for="kategoriBuku">Kategori :</label>
                <select name="select_box" class="form-select" id="select_box">
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
                <br>
                <!-- insert status--> 
                <label for="statusBuku">Status :</label>
                <select name="select_box2" class="form-select" id="select_box2">
                    <option value="">Pilih Status</option> 
                    <option value="0">Tersedia</option>
                    <option value="1">Tidak Tersedia</option> 
                </select> 
                <br> 

                <br>
                <input class="btn btn-primary" name="submit" type="submit" value="Add">
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
