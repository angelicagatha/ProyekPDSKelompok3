<?php
// Include the database configuration file
include 'connection.php';
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$nama = $_POST["namaBuku"];
$desc = $_POST["descBuku"];
$penulis = $_POST["penulisBuku"];
$penerbit = $_POST["penerbitBuku"];
$tgl = $_POST["tanggal_terbit"];
$kategori=$_POST["select_box"];
$status=$_POST["select_box2"];
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"] && !empty($_POST["namaBuku"])&& !empty($_POST["descBuku"]) && !empty($_POST["penulisBuku"]) && !empty($_POST["penerbitBuku"])&& !empty($_POST["tanggal_terbit"]))){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf','JPG','PNG');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $conn->query("INSERT into books (nama_buku,deskripsi,penulis,penerbit,tanggal_terbit,idKategoriBuku,status_buku,file_name,uploaded_on) VALUES ('".$nama."','".$desc."','".$penulis."','".$penerbit."','".$tgl."','".$kategori."','".$status."','".$fileName."', NOW())");
            echo $fileName;
            if($insert){
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

// Display status message
echo $statusMsg;
?>