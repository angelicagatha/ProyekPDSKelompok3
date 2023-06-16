<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
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
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Reset Password</h4>
                                                <form method="post" action="forgotproses.php">
                                                    <div class="form-group" for="email">
                                                        <input type="email" name="email" class="form-style" placeholder="Your Email" id="email" >
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>	
                                                    <div class="form-group" for="old_password">
                                                        <input type="password" name="old_password" class="form-style" placeholder="Old Password" id="old_password" >
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>	
                                                    <div class="form-group mt-2" for="new_password">
                                                        <input type="password" name="new_password" class="form-style" placeholder="New Password" id="new_password">
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <div class="form-group mt-2" for="confirm_new_password">
                                                        <input type="password" name="confirm_new_password" class="form-style" placeholder="Confirm New Password" id="confirm_new_password">
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