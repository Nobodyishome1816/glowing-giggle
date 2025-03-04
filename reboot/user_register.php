<?php

session_start();  //

include_once 'common_functions.php';

if(isset($_SESSION['username'])){
    $_SESSION['message'] = "You are already logged in.";
    header("Location: index.php");
    exit; //stop further session
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once 'db_connect.php';
    if($_POST['password'] == $_POST['cpassword']){
        try {
            $utype_id = $_POST['utype_id']; // Get the user type ID from the form submission
            $signup_date = time();
            // Prepare and execute the SQL query
            $conn = db_connect();
            $sql = "INSERT INTO user (email, password, signup_date, utype_id) VALUES (?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            //bind parameters for security
            $stmt->bindParam(1, $_POST['email']);
            // Hash the password
            $hpswd = password_hash($_POST['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(2, $hpswd);
            $stmt->bindParam(3, $signup_date);
            $stmt->bindParam(4, $utype_id);

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

require_once 'common_functions.php';

require_once 'nav.php';

echo "<div id='content'>";

echo "<h4> User Registration</h4>";

echo "<br>";

echo usr_error($_SESSION);

echo "<form method='post' action='user_register.php'>";

echo "<input type='email' name='email' placeholder='E-mail' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

echo "<select name='utype_id' required>";

echo "<option value='1'>Consumer</option>";

echo "<option value='2'>Commercial</option>";

echo "<option value='3'>Education</option>";

echo "</select><br><br>";

echo "<input type='submit' name='submit' value='Register'>";

echo "<br><br>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";