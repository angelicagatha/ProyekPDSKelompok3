<?php
    require_once 'koneksi.php';

    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = hash("md5", $password);

    $query = "SELECT * FROM user WHERE email = '$email' AND password = '$hashed_password'";
    $result = $conn->query($query);

    if($result->num_rows>0){
        $_SESSION['email'] = $email;
        header("location: homeuser.php");
    } else {
        echo "Username atau password salah";
    }

    $conn->close();
?>