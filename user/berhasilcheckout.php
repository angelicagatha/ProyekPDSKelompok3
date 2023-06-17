<?php
    require_once 'koneksi.php';

    session_start();

    if(!isset($_SESSION['nama_user'])){
        header('location: loginuser.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Peminjaman Berhasil</title>
        <style>
            .book-card {
                width: 300px;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 20px;
                margin: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                height: auto;
            }

            .book-title {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .book-author {
                font-size: 14px;
                color: #555;
                margin-bottom: 10px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .book-description {
                font-size: 14px;
                margin-bottom: 10px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                height: 60px; /* Atur tinggi sesuai kebutuhan */
            }

            .book-cover {
                width: 100%;
                height: auto;
                margin-bottom: 10px;
            }

            .book-list {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-gap: 20px;
            }

            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #333;
            }

            li {
                float: left;
            }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            li a:hover:not(.active) {
                background-color: #111;
            }

            .active {
                background-color: #04AA6D;
            }
        </style>
        <link rel="stylesheet" href="fa_icons/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    </head>
    <body>
        <ul>
            <li><a href="homeuser.php">Home</a></li>
            <li><a class="active" href="cart.php?idUser=<?php echo $id_user ?>">Cart</a></li>
            <li><a href="logoutuser.php">Logout</a></li>
            <li class="active" style="float:right"><a href="#">Welcome, <?php echo $_SESSION['nama_user'];?>!</a></li>
        </ul>

        <div class="container" style="text-align: center; margin-top: 3%;">
            <i class="fas fa-check-circle fa-7x" style="color: green;"></i>
            <h3 style="margin-top: 1%;">Pembayaran Sukses</h3>
            <a href="homeuser.php"><h6>Back to Home</h6></a>
        </div>
    </body>
</html>