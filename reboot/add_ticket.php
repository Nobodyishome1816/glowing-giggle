<?php

session_start();

require_once('db_connect.php');
require_once('common_functions.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        $conn = db_connect();
        $sql = "INSERT INTO ticket (ticket_type, no_of_tickets, price) VALUES (?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        //bind parameters for security
        $stmt->bindParam(1, $_POST['ticket']);
        $stmt->bindParam(2, $_POST['no_of_tickets']);
        $stmt->bindParam(3, $_POST['price']);

        $stmt->execute();  //run the query to insert
        $conn = null;  // closes the connection so cant be abused.
        $_SESSION['message'] = "You are now Registered";
        header("Location: add_ticket.php");
    }  catch (PDOException $e) {
        // Handle database errors
        error_log("Ticket Reg Database error: " . $e->getMessage()); // Log the error
        throw new Exception("Ticket Reg Database error". $e); //Throw exception for calling script to handle.
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Ticket Registration error: " . $e->getMessage()); //Log the error
        throw new Exception("Ticket Registration error: " . $e->getMessage()); //Throw exception for calling script to handle.
    }
}


echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title>Ticket Type Registration </title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

require_once 'title.php';

require_once 'common_functions.php';

require_once 'nav.php';

echo "<div id='content'>";

echo "<h4> Ticket Type Registration</h4>";

echo "<br>";

echo usr_error($_SESSION);

echo "<form method='post' action='add_ticket.php'>";

echo "<input type='text' name='ticket' placeholder='Ticket Type' required><br>";

echo "<input type='text' name='price' placeholder='Ticket Price' required><br>";

echo "<input type='text' name='no_of_tickets' placeholder='Number of Tickets' required><br>";

echo "<input type='submit' name='submit' value='Register'>";

echo "<br><br>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";
?>