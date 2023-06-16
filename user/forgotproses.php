<?php
    require 'koneksi.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $query = "SELECT * FROM user WHERE email='$email'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (md5($old_password) === $hashed_password) {    
                if($new_password == $confirm_new_password){
                    $hashed_password = md5($new_password);

                    $query = "UPDATE user SET password = '$hashed_password' WHERE email='$email'";
                    $conn->query($query);
                    
                    header('location: loginuser.php');
                    exit;
                } else {
                    echo 'New Password dan Confirm New Password tidak cocok';
                }
            } else {
                echo 'Password lama yang dimasukkan salah';
            }
        } else {
            echo 'Email tidak terdaftar';
        }
    }
?>