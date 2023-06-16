<?php
    require_once 'koneksi.php';

    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = hash("md5", $password);

    $query = "SELECT * FROM user WHERE email = '$email' AND password = '$hashed_password'";
    $result = $conn->query($query);

    foreach ($result as $hasil) {
        $username = $hasil['nama_user'];
        $id_user = $hasil['id_user'];
    }

    if($result->num_rows>0){
        $_SESSION['nama_user'] = $username;
        $_SESSION['id_user'] = $id_user;
        header("location: homeuser.php");
    } else {
        echo '<script>
                alert("Username atau password salah");
                window.location.href = "loginuser.php";
            </script>';
    }
    
    $conn->close();
?>