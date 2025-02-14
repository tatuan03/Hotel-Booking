<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                include("config.php");
                if(isset($_POST['submit'])){
                    $email =mysqli_real_escape_string($con,$_POST['email']);
                    $password =mysqli_real_escape_string($con,$_POST['password']);

                    $result =mysqli_query($con,"SELECT * FROM users WHERE email ='$email' AND password ='$password'") or die (" Error !!!");
                    $row = mysqli_fetch_assoc($result);

                    if(is_array($row) && !empty($row)){
                        $_SESSION['valid'] = $row['email'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['id'] = $row['id'];

                    } else{
                        echo "  <div class='message'>
                        <p> Wrong email or password ! </p>
                            </div> <br>";
                    echo "<a href ='login.php'> <button class='btn'> Go back</button>";
                    }
                    if(isset($_SESSION['valid'])){
                        header("Location: ../Home-User/index.html");
                    }
                } else{

            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email"> Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password"> Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                    <div class="link">
                        Don't have account ? <a href="signup.php"> Sign Up</a>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    
<script language='javascript' type='text/javascript'>
    function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
</body>
</html>