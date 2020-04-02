<?php
    include('includes/config.php');

    if(isset($_POST['login'])){
        $em = $_POST['email'];
        $fn = $_POST['firstName'];
        $ln = $_POST['lastName'];
        $pw = md5($_POST['password']);
        $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$em'");

        if(mysqli_num_rows($query) == 1) {
            echo "<p class='error'>Account with this email already exists</p>";

        }
        else{
            $encryptedPw = md5($pw);
			$date = date("M j, y | g:i");

            $result = mysqli_query($con, "INSERT INTO users (firstName, lastName, email, password, joinDate) VALUES ('$fn', '$ln', '$em', '$encryptedPw', '$date')");

            $query = mysqli_query($con, "SELECT * FROM users WHERE email = '$em'");

            while($row = mysqli_fetch_array($query)) {
                $id = $row['id'];
                $fname = $row['firstName'];
                $lname = $row['lastName'];
                $name = $fname ." ". $lname;
            }

            $result = mysqli_query($con, "INSERT INTO education (userID) VALUES ('$id')");
            $result = mysqli_query($con, "INSERT INTO certificates (userID) VALUES ('$id')");
            $result = mysqli_query($con, "INSERT INTO experience (userID) VALUES ('$id')");
            $result = mysqli_query($con, "INSERT INTO resumeinfo (userID, name, email) VALUES ('$id', '$name', '$em')");


		    $_SESSION['userLoggedIn'] = $em;
		    $_SESSION['id'] = $id;

            
            header("location: index.php");
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
        <form action="signup.php" method="post">
            <h2>Welcome!</h2>
            <input type="firstName" name="firstName" id="firstName" placeholder="First Name">
            <input type="lastName" name="lastName" id="lastName" placeholder="Last Name">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="password" name="password" placeholder="********" id="password">
            <input type="submit" id="login" name="login" value="Log In">
        </form>
        <p class="signupText">Have an account? <a class="signupText" href="login.php">Login</a></p>
    </div>

    
</body>
</html>