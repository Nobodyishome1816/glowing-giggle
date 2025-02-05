<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>signup</title>
</head>
<body>
    <h1>
        Sign up!
    </h1>

    <p>
        Welcome to the sign up page
    </p>
 <form method="post" action="" class="textinput"> <!-- creates a form for the user to be able to sign up easily -->
     <input type="text" name="email" placeholder="Please Enter your email"><br><br>
     <input type="text" name="password" placeholder="Please Enter your password"><br>
     <select>
         <option value="consumer">Consumer</option>
         <option value="commercial">Commercial</option>
         <option value="education">Education</option>
     </select><br><br>
     <input type="submit" value="Sign Up">
 </form>
</body>
</html>

<?php

    include 'db_connect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($email)) {  // Fixed parentheses
        $nameErr = "Email is required";
        header("refresh:2; url=signin.php");
        echo $nameErr;
    } elseif (empty($password)) {  // Fixed parentheses
        $nameErr = "Password is required";
        header("refresh:2; url=signin.php");
        echo $nameErr;
    }
}

?>