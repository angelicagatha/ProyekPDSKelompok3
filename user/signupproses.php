<?php
  require_once 'koneksi.php';

  session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <?php
            $email = $_POST['email'];
            $nama_user = $_POST['nama_user'];
            $password = $_POST['password'];
            
            if ($email == '' || $nama_user == '' || $password == ''){
                echo '<i class="fas fa-times-circle fa-7x" style="color: red"></i>';
                echo '<h3 style="margin-top: 1%;">Post gagal direquest!</h3>';

                if ($email == '') {
                    echo 'email invalid <br>';
                }

                if ($nama_user == '') {
                    echo 'nama_user invalid <br>';
                }
                
                if ($password == '') {
                    echo 'password invalid <br>';
                }
            } else {
                $query = "INSERT INTO user (email, nama_user, password)
                            VALUES ('". $email."', '". $nama_user."', '". $password."')";
                $conn->query($query);
            }
        ?>

        <script>
            alert('Selamat, Data berhasil diupload!');
            <?php
                header('Location: loginuser.php');
                exit;
            ?>
        </script>
    </body>
</html>