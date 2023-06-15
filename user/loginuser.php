<?php
    require_once "koneksi.php";

    if (isset($_SESSION['user'])) {
      header("location: homeuser.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style type="text/css">
            .section {
                margin: auto;
                max-width: 500px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <a href="https://front.codes/" class="logo" target="_blank">
            <img src="https://assets.codepen.io/1462889/fcy.png" alt="">
        </a>

        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                            <h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
                            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">

                                    <!-- LOG IN -->
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Log In</h4>
                                                <form method="post" action="loginproses.php">
                                                    <div class="form-group" for="email">
                                                        <input type="email" name="email" class="form-style" placeholder="Your Email" id="email" >
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>	
                                                    <div class="form-group mt-2" for="password">
                                                        <input type="password" name="password" class="form-style" placeholder="Your Password" id="password">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button class="btn mt-4" type="submit">SUBMIT</button>
                                                    <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SIGN UP -->
                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Sign Up</h4>
                                                <form method="post" action="signupproses.php">
                                                    <div class="form-group" for="nama_user">
                                                        <input type="text" name="nama_user" class="form-style" placeholder="Your Full Name" id="nama_user">
                                                        <i class="input-icon uil uil-user"></i>
                                                    </div>	
                                                    <div class="form-group mt-2" for="email">
                                                        <input type="email" name="email" class="form-style" placeholder="Your Email" id="email" >
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>	
                                                    <div class="form-group mt-2" for="password">
                                                        <input type="password" name="password" class="form-style" placeholder="Your Password" id="password" >
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button class="btn mt-4" type="submit">SUBMIT</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
