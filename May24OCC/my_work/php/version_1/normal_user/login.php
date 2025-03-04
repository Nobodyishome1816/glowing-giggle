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
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Checks when the form is submitted
    // Only access $_POST after the form has been submitted
    $email = $_POST['email'] ?? '';  // Default to an empty string if 'email' is not set
    $password = $_POST['password'] ?? '';  // Default to an empty string if 'password' is not set

    // Check if email is empty
    if (empty($email)) {
        $nameErr = "Email is required";
        echo $nameErr;
        header("refresh:2; url=signup.php");
        exit();
    }
    // Check if email is a valid format
    elseif (strpos($email, '@') === false || strpos($email, '.') === false) {
        $nameErr = "Invalid email format";
        echo $nameErr;
        header("refresh:2; url=signup.php");
        exit();
    }
    // Check if password is empty
    elseif (empty($password)) {
        $nameErr = "Password is required";
        echo $nameErr;
        header("refresh:2; url=signup.php");
        exit();
    }
    // Check password length and strength using regex
    elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}$/', $password)) {
        $nameErr = "Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, and one special character.";
        echo $nameErr;
        header("refresh:2; url=signup.php");
        exit();
    }

    try {
        // Prepare SQL statement to fetch the user from the database
        $sql = "SELECT * FROM `user` WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch user data

        // If user exists and password matches
        if ($user && password_verify($password, $user['password'])) {
            // Store user information in session variables
            $_SESSION['admin_user_id'] = $user['admin_user_id'];  // Store user ID
            $_SESSION['email'] = $user['email'];  // Store user email
            $_SESSION['f_name'] = $user['f_name'];  // Store first name
            $_SESSION['s_name'] = $user['s_name'];  // Store surname
            $_SESSION['privl'] = $user['privl'];  // Store privilege level

            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            // If credentials are incorrect
            $nameErr = "Invalid email or password.";
            echo $nameErr;
            header("refresh:2; url=login.php");  // Redirect back to login page
            exit();
        }
    } catch (PDOException $e) {
        // If there is an error in the database connection or query
        echo "Error: " . $e->getMessage();
    }
}
?>
