<!DOCTYPE html>
<html>
<head>

</head>
<body>
<p> welcome to the login page </p>

<form method="post" action="" > <!-- creates a form for the user to be able to sign up easily -->
    <input type="text" name="email" placeholder="Please Enter your email"><br><br>
    <input type="text" name="password" placeholder="Please Enter your password"><br>
    <input type="submit" placeholder="login">
</form>
</body>
</html>
<?php
    include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //checks when anything is submitted from the form
    // Only access $_POST after the form has been submitted
    $email = $_POST['email'] ?? '';  // Default to an empty string if 'email' is not set
    $password = $_POST['password'] ?? '';  // Default to an empty string if 'password' is not set

    // Check if email is empty
    if (empty($email)) {
        $nameErr = "Email is required";
        header("refresh:2; url=signup.php");
        echo $nameErr;
    } // Check if email is a valid format
    elseif (strpos($email, '@') === false || strpos($email, '.') === false) { //strpos returns true or false when checking the email, if there is no @ or . then it returns false
        $nameErr = "Invalid email format";
        header("refresh:2; url=signup.php");
        echo $nameErr; // shows error if there is one
    } // Check if password is empty
    elseif (empty($password)) {
        $nameErr = "Password is required";
        header("refresh:2; url=signup.php");
        echo $nameErr; // shows error is there is one
    } // Check password length and strength using regex
    elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}$/', $password)) { // chosen to make sure the password has at least 1 Cap letter, 1 lower letter, 1 Special character and 8 or more characters for good security
        $nameErr = "Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, and one special character.";
        header("refresh:2; url=signup.php");
        echo $nameErr; // shows error if there is one
    } else {
        echo "You have been registered successfully";
    }
}
?>