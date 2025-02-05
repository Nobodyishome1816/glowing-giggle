<?php
$username = "may_24"; // not using root as that would create a security risk, in porduction environment there would be multiple users not one super user
$password = "Tlevel25!";
$servername = "localhost"; // not in a work environment which would be a different but is only on my device for now
$dbname = "may_24";

try {
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $username, $password); // sets perameters for connecting
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // tries to connect to database
    // echo "Connected successfully"; // if connected then shows it can
} catch(PDOException $e) { // catches any error message
    echo "Connection failed: " . $e->getMessage(); // gives basic message if it does fail to connect
    echo $e; // outputs the error if there is any
}
?>