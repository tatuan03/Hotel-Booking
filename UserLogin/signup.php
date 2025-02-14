<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./style/login.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
            include("config.php");
            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password= $_POST['password'];

                $verify_query = mysqli_query($con,"SELECT email FROM users WHERE email='$email'");
                if (mysqli_num_rows($verify_query)!=0){
                    echo "  <div class='message'>
                        <p> This email is used. Try another email, please !</p>
                            </div> <br>";
                    echo "<a href ='javascript:self.history.back()'> <button class='btn'> Go back</button>";
                }
                else{
                    mysqli_query($con,"INSERT INTO users(username,email,password) VALUES ('$username','$email','$password')") or die("Error Occured");
                    echo "  <div class='message2'>
                    <p> Sign up successfully !</p>
                        </div> <br>";
                echo "<a href ='login.php'> <button class='btn'> Login now</button>";
                }
            } else{

        
            ?>

            <header>Sign Up</header>
            <form action="" method="post" >
                <div class="field input">
                    <label for="username"> Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email"> Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password"> Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign Up" required>
                    <div class="link">
                        Already have account ? <a href="login.php"> Login</a>
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