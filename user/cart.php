<?php
    require_once "../user/koneksi.php";
    
    session_start();

    if (!isset($_SESSION['id_user'])) {
        header("location: loginuser.php");
    }

    $sql = "SELECT * FROM cart WHERE idUser=" . $_GET['idUser'];
    $result = $conn->query($sql);
    $items = $result->fetch_all(MYSQLI_ASSOC);
?>

<html>
    <head>
        <!-- Font Awesome Icon Library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">

        <!-- js -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

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

        <title>View Cart</title>
    </head>

    <body>
        <?php
            $sql1 = "SELECT *
                    FROM user
                    WHERE id_user=" . $_SESSION['id_user'];
            $result1 = $conn->query($sql1);
            $result = $result1->fetch_assoc();
        ?>

        <ul>
        <li><a href="homeuser.php">Home</a></li>
        <li><a class="active" href="cart.php?idUser=<?php echo $id_user ?>">Cart</a></li>
        <li><a href="logoutuser.php">Logout</a></li>
        <li class="active" style="float:right"><a href="#">Welcome, <?php echo $_SESSION['nama_user'];?>!</a></li>
        </ul>

        <br>
        <!-- Header -->
        <div class="card" style="border-color: black;">
            <div class="card-header">
                <div class="form-check">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            Product
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            Quantity
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            Total Buku
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Per item nya -->
        <?php
            $totalBuku = 0;
            $totalQuantity = 0;
            foreach ($items as $it) {
            $sql2 = "SELECT * FROM books WHERE id=" . $it['idBuku'];
            $result2 = $conn->query($sql2);
            $barang = $result2->fetch_assoc();
        ?>

        <br>
            <div class="card" style="border-color: black;">
                <div class="card-body">
                    <div class="form-check">
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <img src="<?php echo $barang['file_name'] ?>" style="width: 80px">
                                <?php echo $barang['nama_buku'] ?>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <?php
                                    echo $it['quantity'];
                                    $totalQuantity += $it['quantity'];
                                ?>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <?php
                                    echo $it['quantity'];
                                    $totalQuantity += $it['quantity'];
                                ?>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <button class="btn btn-danger" onclick="deleteACart(<?php echo $it['idBuku']; ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <br>
        <div class="card" style="border-color: black; text-align: center;">
            <div class="card-footer">
                <p>Total (<?php echo $totalQuantity; ?> Buku):
                    <h5><?php echo $totalBuku ?> Buku
                        <button class="btn btn-info" onclick="location.href = '#'">Checkout</button>
                    </h5>
                </p>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="js/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
        <script src="js/bootstrap.js"></script>

        <script>
            function deleteACart(idBarang) {
                var xmlhttp = new XMLHttpRequest();
                var idUser = <?php echo $_SESSION['user']; ?>;

                xmlhttp.open("GET", "ajax/deleteFromCart.php?idUser=" + idUser + "&idBarang=" + idBarang, true);
                xmlhttp.send();

                alert("Deleted from Cart SUCCESSFULY");
                location.reload()
            }
        </script>
    </body>
</html>
