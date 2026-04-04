<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT Pulse - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/images/logo.png">
</head>

<body>
    <div class="login-container">
        <div class="row g-0">

            <div class="col-lg-5">
                <div class="left-section">

                    <div class="logo">
                        <img src="assets/images/logo.png" alt="INSAT Pulse Logo">
                    </div>
                    <h1 class="login-text">Login your account</h1>
                    <form class="login-form"  action="actions/do-login.php" method="post">

                        <div class="frame-4">

                            <div class="frame-2">
                                <label class="form-label">Email</label>
                                <div class="rectangle-2">
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="frame-3">
                                <label class="form-label">Password</label>
                                <div class="rectangle-3">
                                    <input type="password" class="form-control" type="password" name="password" required>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['login_error'])): ?>
                                <small style="color: red;">
                                    <?= $_SESSION['login_error']; ?>
                                </small>
                                <?php 
                                    unset($_SESSION['login_error']); 
                                ?>
                            <?php endif; ?>

                            <div class="frame-1">
                                <a href="#" class="forgot-password-link">Forgot password?</a>
                                <button type="submit" class="login-button">Login</button>
                            </div>

                        </div>
                    </form>

                    <div class="register">
                        <p>Don't have an account? <a href="#" class="register-link">Register now</a></p>
                    </div>
                    
                </div>
            </div>


            <div class="col-lg-7">

                <div class="frame-6">
                    <h1 class="hero-text">WHERE TODAY'S IDEAS TURN INTO TOMORROW'S REALITY</h1>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
