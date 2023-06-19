<?php
// Include the database connection file
require_once("koneksi.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
    $targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$name = $_POST["name"];
$desc = $_POST["desc"];
$penulis = $_POST["author"];
$penerbit = $_POST["publisher"];
$tgl = $_POST["tanggal"];
$kategori=$_POST["select_box"];
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
$id = $_POST['id'];
	
	// Check for empty fields
	if(isset($_POST["update"]) && !empty($_FILES["file"]["name"] && !empty($_POST["name"])&& !empty($_POST["desc"]) && !empty($_POST["author"]) && !empty($_POST["publisher"])&& !empty($_POST["tanggal"]))){
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf','JPG','PNG');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert 

                $update = $conn->query ("UPDATE books SET nama_buku='$name', deskripsi='$desc',penulis='$penulis',penerbit='$penerbit',tanggal_terbit='$tgl',idKategoriBuku='$kategori',file_name='$fileName' where id='$id'");
                echo $fileName;
                if($update){
                    // $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                    header("Location:homehomean.php");
                }else{
                    $statusMsg = "File upload failed, please try again.";
                } 
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    }else{
        // $statusMsg = 'Please enter all information.';
        echo '<script type="text/javascript">
    
        function AlertIt() {
            var answer = confirm ("Please click on OK to continue.")
            if (answer)
            window.location="create.php";
            }
        
    </script>
    <a href="javascript:AlertIt();">please insert all information</a>';
    
    }
    // if (empty($name) || empty($desc) || empty($penulis)|| empty($penerbit) || empty($tgl) || empty($kategori)) {
	// 	if (empty($name)) {
	// 		echo "<font color='red'>Mohon mengisi nama buku.</font><br/>";
	// 	}
		
	// 	if (empty($desc)) {
	// 		echo "<font color='red'>Mohon mengisi deskripsi buku.</font><br/>";
	// 	}
		
	// 	if (empty($penulis)) {
	// 		echo "<font color='red'>Mohon mengisi nama penulis.</font><br/>";
	// 	}
    //     if (empty($penerbit)) {
	// 		echo "<font color='red'>Mohon mengisi nama penerbit.</font><br/>";
	// 	}
		
	// 	if (empty($tgl)) {
	// 		echo "<font color='red'>Mohon mengisi tanggal terbit.</font><br/>";
	// 	}
		
	// 	if (empty($kategori)) {
	// 		echo "<font color='red'>Mohon mengisi kategori buku.</font><br/>";
	// 	}
	// } else {
	// 	// Update the database table
	// 	$result = mysqli_query($conn, "UPDATE books SET `nama_buku` = '$name', `deskripsi` = '$desc', `penulis` = '$penulis',`tanggal_terbit` = '$tgl' WHERE `id` = $id");
		
	// 	// Display success message
	// 	echo "<p><font color='green'>Data updated successfully!</p>";
	// 	echo "<a href='homehomean.php'>View Result</a>";
	// }
}