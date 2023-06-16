<?php
    require_once "../user/koneksi.php";

    $idUser = $_GET['idUser'];
    $idBuku = $_GET['idBuku'];
    $quantity = $_GET['quantity'];

    $sql = "SELECT * FROM cart WHERE idUser = ? AND idBuku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUser, $idBuku);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result) > 0){
        while($row = $result->fetch_assoc()){
            $updateQuery = "UPDATE cart SET quantity = quantity + ".$quantity." WHERE idUser = ".$row['idUser']." AND idBuku = ".$row['idBuku'];
            $stmt1 = $conn-> prepare($updateQuery);
            $stmt1->execute();
        }        
    }else{
        $insertQuery = "INSERT INTO cart(idUser, idBuku, quantity) VALUES (?,?,?)";
        $stmt2 = $conn->prepare($insertQuery);
        $qty = 1;
        $stmt2->bind_param("iii", $idUser,$idBuku, $qty);
        $stmt2->execute();
    }
?>
