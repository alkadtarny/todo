<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                include("koneksi.php");
                if(isset($_POST['submit'])){
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);

                    $result = mysqli_query($con, "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'") or die("Select error");
                    $row = mysqli_fetch_assoc($result);
                    if(is_array($row) && ! empty($row)){
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['id'] = $row['Id'];
                    } else{
                        echo "<div class='message'>
                        <p>Email atau Password salah!</p>
                        </div> <br>";
                        echo "<a href='login.php'><button class='btn'>Kembali</button></a>";
                    }
                    if(isset($_SESSION['valid'])){
                        header("Location: index.php");
                    }
                    }else{
                
                ?>

            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Tidak Punya Akun? <a href="register.php">Registrasi Sekarang</a>
                </div>
                    </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>