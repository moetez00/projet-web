<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSAT PULSE - Register Student</title>
    <link rel="stylesheet" href="assets/css/registerStudent.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="form-container">
                <div class="logo">
                    <img src="assets/images/logo_cropped.png" alt="INSAT PULSE Logo" class="logo-img" height="600" width="800">
                </div>
                <h2 class="form-title">Create a student account</h2>
                

                

                

                <form class="resgistration-form"  action="actions/do-register-student.php" method="post">
                    <div class="form-group">
                        <label for="Full name">Full name</label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <?php if (isset($_SESSION['username_error'])): ?>
                        <small style="color: red;">
                            <?= $_SESSION['username_error']; ?>
                        </small>
                        <?php 
                            unset($_SESSION['username_error']); 
                        ?>
                    <?php endif; ?>
                    <br>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <?php if (isset($_SESSION['email_error'])): ?>
                        <small style="color: red;">
                            <?= $_SESSION['email_error']; ?>
                        </small>
                        <?php 
                            unset($_SESSION['email_error']); 
                        ?>
                    <?php endif; ?>
                    <br>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                        <p id="password-weak" style="color:red;display:none">Password must have at least 8 characters.</p>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="password">Repeat password</label> 
                        <input id="repeat-password" name="repeat-password" type="password" required>
                        <p id="password-mismatch" style="color:red;display:none">Verify your password.</p>
                    </div>
                    <?php if (isset($_SESSION['password_error'])): ?>
                        <small style="color: red;">
                            <?= $_SESSION['password_error']; ?>
                        </small>
                        <?php 
                            unset($_SESSION['password_error']); 
                        ?>
                    <?php endif; ?>
                    <br>
                    <button type="submit" class="submit-btn">Create</button>
                </form>
            </div>
        </div>
        <div class="right-section">
            <div class="overlay">
                <h1 class="overlay-text">WHERE TODAY'S IDEAS TURN<br>INTO TOMORROW'S REALITY</h1>
            </div>
        </div>
    </div>
        <script>
        let submit=false;
        document.querySelector("button[type=submit]").addEventListener("click",function(event){
            if(!submit){
            event.preventDefault();
            }
        });
        document.querySelector("input[id=repeat-password]").addEventListener("input",function(){
            let repeat=this;
            let pass=document.querySelector("input[id=password]");
            if((!repeat.checked && !pass.checked) && repeat.value!=pass.value){
                document.querySelector("p[id=password-mismatch]").style.display="inline";
                submit=false;
            }
            else{
                document.querySelector("p[id=password-mismatch]").style.display="none";
                submit=true;
            }
    });

     document.querySelector("input[id=password]").addEventListener("input",function(){
            let pass=this;
            if(pass.value.length<8){
                console.log("dh3if");
                document.querySelector("p[id=password-weak]").style.display="inline";
                submit=false;
            }
            
            else{
                document.querySelector("p[id=password-weak]").style.display="none";
                submit=true;
            }
    });

    </script>
</body>
</html>   