<?php
$username = "hag_may23";
$password = "Tlevel25!";
$servername = "localhost";
$dbname = "hag_may23";

try {
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo $e;
}
?>