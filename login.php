<?php
    include('includes/config.php');

    if(isset($_POST['login'])){
        $em = $_POST['email'];
        $pw = md5($_POST['password']);
        $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$em' AND password = '$pw'");

        if(mysqli_num_rows($query) == 1) {
		    $_SESSION['userLoggedIn'] = $em;
            while($row = mysqli_fetch_array($query)) {
                $_SESSION['id'] = $row['id'];
            } 
		    header("location: index.php");
        }
        else{
            echo "<p class='error'>Incorrect login info</p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>

    <div class="accountForm">
        <form action="login.php" method="post">
            <h2>Welcome Back!</h2>
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="password" name="password" placeholder="********" id="password">
            <input type="submit" id="login" name="login" value="Log In">
        </form>
        <p class="signupText">Need an account? <a class="signupText" href="signup.php">Sign Up</a></p>
    </div>

    
</body>
</html>