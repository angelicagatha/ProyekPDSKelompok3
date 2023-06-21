<!DOCTYPE html>
<html>

<head>
    <title>Backend | Edit Books </title>
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
    // Get id from URL parameter
    $id = $_GET['id'];
        // Querry dari tabel books
        $result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
        // Fetch the next row of a result set as an associative array
        $bukuEdit = mysqli_fetch_assoc($result);
        $name = $bukuEdit['nama_buku'];
        $author = $bukuEdit['penulis'];
        $publisher = $bukuEdit['penerbit'];
        $date = $bukuEdit['tanggal_terbit'];
        $sinopsis = $bukuEdit['deskripsi'];
        $category = $bukuEdit['idKategoriBuku'];
 ?>


    <!-- Content -->
    <div class="section">
    <div class="container mt-5">
        <div class="row justify">
            <div class="col-md-6">
            <div class="card">

            <div class="card-header text-center">
                EDIT BUKU
            </div>

            <div class="card-body">
     
            <br>
            <form  action="updatingBooks.php" method="post" enctype="multipart/form-data">
            <table border="0">
                <tr>
                    <!-- <td><label for="id">ID Buku</label></td> -->
                <td><input type="hidden" name="idBuku" value=<?php echo $id; ?>></td>
                </tr>
			<tr> 
				<td>Cover Buku</td>
				<td><input type="file" name="file"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
            <tr> 
				<td>Nama Buku</td>
				<td><input type="text" name="name" value="<?php echo $name; ?>"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
			<tr> 
				<td>Penulis</td>
				<td><input type="text" name="author" value="<?php echo $author; ?>"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
			<tr> 
				<td>Penerbit</td>
				<td><input type="text" name="publisher" value="<?php echo $publisher; ?>"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
            <tr> 
				<td>Deskripsi Buku</td>
				<td><input type="text" size="50" name="desc" value="<?php echo $sinopsis; ?>"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
			<tr> 
				<td>Tanggal Terbit</td>
				<td><input type="date" name="tanggal" value="<?php echo $date; ?>"></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
			<tr> 
				<td>Kategori</td>
				<td>
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
                </select></td>
			</tr>
            <tr><td></td></tr>
            <tr></tr>
            <tr></tr>
			<tr>
			<td><input type="submit" class="btn btn-submit" name="update" value="Update"></td>	
				
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
