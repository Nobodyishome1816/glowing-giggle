<?php

session_start();  //

if(isset($_SESSION['username'])){
    $_SESSION['message'] = "You are already logged in.";
    header("Location: index.php");
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'dbconnect.php';
    if($_POST['password'] == $_POST['cpassword']){
        try {
            $signup_date = time();
            // Prepare and execute the SQL query
            $sql = "INSERT INTO user (email, password, signup_date, ) VALUES (?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            $stmt->bindParam(1, $_POST['username']);  //bind parameters for security
            $stmt->bindParam(2, $_POST['email']);
            // Hash the password
            $hpswd = password_hash($_POST['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(3, $hpswd);
            $stmt->bindParam(4, $signup_date);
            $stmt->bindParam(5, );

            $stmt->execute();  //run the query to insert
            $conn = null;  // closes the connection so cant be abused.
            $_SESSION['message'] = "You are now Registered";
            header("Location: index.php");
        }  catch (PDOException $e) {
            // Handle database errors
            error_log("User Reg Database error: " . $e->getMessage()); // Log the error
            throw new Exception("User Reg Database error". $e); //Throw exception for calling script to handle.
        } catch (Exception $e) {
            // Handle validation or other errors
            error_log("User Registration error: " . $e->getMessage()); //Log the error
            throw new Exception("User Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
        }
    }
}


echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title> User Registration</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

require_once 'title.php';

require_once 'nav.php';

echo "<div id='content'>";

echo "<h4> User Registration</h4>";

echo "<br>";

echo usr_error($_SESSION);

echo "<br>";

echo "<br>";


echo "<form method='post' action='user_reg.php'>";

echo "<input type='text' name='username' placeholder='Username' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

echo "<input type='text' name='fname' placeholder='First Name' required><br>";

echo "<input type='text' name='sname' placeholder='Surname' required><br>";

echo "<input type='email' name='email' placeholder='E-mail' required><br>";

echo "<input type='submit' name='submit' value='Register'>";

echo "<br><br>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";