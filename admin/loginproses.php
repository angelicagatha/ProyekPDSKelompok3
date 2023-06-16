<?php
    require_once 'koneksi.php';

    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = hash("md5", $password);

    $query = "SELECT * FROM admin WHERE email_admin = '$email' AND password_admin = '$hashed_password'";
    $result = $conn->query($query);

    foreach ($result as $hasil) {
        $username = $hasil['email_admin'];
        $id_user = $hasil['id_admin'];
    }

    if($result->num_rows>0){
        $_SESSION['email_admin'] = $username;
        $_SESSION['id_admin'] = $id_user;
        header("location: homeadmin.php");
    } else {
        echo "Username atau password salah";
    }

    $conn->close();
?>