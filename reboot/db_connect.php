<?php

function db_connect()
{
    $username = "may_24"; // username for password
    $password = "Tlevel25!"; // password for database user
    $servername = "localhost"; // sets servername
    $dbname = "may_24"; // database name

    try { // attemps this block of code, catching an error
        $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $username, $password); // sets perameters for connecting
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // tries to connect to database
         return $conn; // if connected then shows it can
    } catch (PDOException $e) { // catches any error message
        error_log("database error om super_checker: " . $e->getMessage()); // gives basic message if it does fail to connect
        throw $e; // outputs the error if there is any
    }
}
?>