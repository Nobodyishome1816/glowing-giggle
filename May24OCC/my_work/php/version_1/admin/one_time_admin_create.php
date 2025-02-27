<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<p>welcome to the one time use admin creator page</p>

<form method="post">
    <input type="text" name="fname" placeholder="enter your first name" required><br><br>
    <input type="text" name="sname" placeholder="enter your surname" required><br><br>
    <input type="text" name="email" placeholder="enter your email" required><br><br>
    <input type="text" name="password" placeholder="enter your password" required><br><br>
    <input type="hidden" name="priv" value="SUPER">
    <input type="submit" value="Sign up">
</form>
</body>
</html>

<?php

include '../db_connect.php';

try {
    // Check if super admin exists by looking for a user with "SUPER" privilege
    $sql = "SELECT admin_user_id FROM `admin_users` WHERE privl = 'SUPER' LIMIT 1";  // Correct column name used
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // If super admin already exists, redirect to another page or show a message
    if ($result) {
        echo 'SUPER ADMIN user already exists';
        header("Location: admin_profile.php");  // Redirect to a page that informs the user signup is closed
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Only access $_POST after the form has been submitted
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $sname = $_POST['sname'] ?? '';
        $time = time();
        $privl = $_POST['priv'] ?? '';

        // Check if email is empty
        if (empty($email)) {
            $nameErr = "Email is required";
            header("refresh:2; url=signup.php");
            echo $nameErr;
        }
        // Check if email is a valid format
        elseif (strpos($email,'@') === false || strpos($email,'.') === false) {
            $nameErr = "Invalid email format";
            header("refresh:2; url=signup.php");
            echo $nameErr;
        }
        // Check if password is empty
        elseif (empty($password)) {
            $nameErr = "Password is required";
            header("refresh:2; url=signup.php");
            echo $nameErr;
        }
        // Check password length and strength using regex
        elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}$/', $password)) {
            $nameErr = "Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, and one special character.";
            header("refresh:2; url=signup.php");
            echo $nameErr;
        }
        elseif (empty($fname)) {
            $nameErr = "First name is required";
            header("refresh:2; url=signup.php");
        }
        elseif (empty($sname)) {
            $nameErr = "Surname is required";
            header("refresh:2; url=signup.php");
        }
        else {
            echo "You have been registered successfully";
        }

        try {
            // Check if the email already exists in the database
            $sql = "SELECT email FROM `admin_users` WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                header("refresh:5; url=login.php");
                echo '<br>';
                echo "An Account with this email already exists. Try again!";
            } else {
                // Insert the new admin user as super admin
                $hpswd = password_hash($password, PASSWORD_DEFAULT);
                $epoch = time();

                $sql = "INSERT INTO `admin_users` (email, password, f_name, s_name, signup_date, privl) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $email);
                $stmt->bindParam(2, $hpswd);
                $stmt->bindParam(3, $fname);
                $stmt->bindParam(4, $sname);
                $stmt->bindParam(5, $time);
                $stmt->bindParam(6, $privl);

                $stmt->execute();

                // Redirect to profile page after registration
                header("Location: admin_profile.php");
                exit();  // Stop further script execution
            }
        } catch (PDOException $e) {
            // Handle any errors that occur within the database queries
            echo "Error during database operation: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    // Handle connection or other exceptions
    echo "Error: " . $e->getMessage();
}
?>