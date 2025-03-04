<?php

session_start();

require_once('db_connect.php');
require_once('common_functions.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
        // Retrieve form data
        $ticket_type = $_POST['ticket_type'];  // Ticket type
        $no_of_tickets = $_POST['no_of_tickets'];  // Number of tickets

        // Convert the ticket date to epoch time (Unix timestamp)
        $ticket_date = $_POST['ticket_date'];  // Date selected by the user
        $ticket_epoch_time = strtotime($ticket_date);  // Convert the date to epoch time

        $date_booked = time();
        // Prepare and execute the SQL query
        $conn = db_connect();
        $sql = "INSERT INTO ticket_booking (ticket_type, no_of_tickets, date_booked, ticket_date) VALUES (?, ?, ?, ?)";  // Prepare SQL query to insert
        $stmt = $conn->prepare($sql);  // Prepare statement

        // Bind parameters for security
        $stmt->bindParam(1, $ticket_type);
        $stmt->bindParam(2, $no_of_tickets);
        $stmt->bindParam(3, $date_booked);
        $stmt->bindParam(4, $ticket_epoch_time);  // Bind the epoch time to the query

        // Execute the query
        $stmt->execute();
        $conn = null;  // Close the connection

        $_SESSION['message'] = "Ticket Registration Successful!";
        header("Location: add_ticket.php");  // Redirect to another page after successful registration
        exit; // Stop further execution
    }  catch (PDOException $e) {
        // Handle database errors
        error_log("Ticket Reg Database error: " . $e->getMessage());  // Log the error
        throw new Exception("Ticket Reg Database error: " . $e->getMessage());  // Throw exception for calling script to handle
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Ticket Registration error: " . $e->getMessage());  // Log the error
        throw new Exception("Ticket Registration error: " . $e->getMessage());  // Throw exception for calling script to handle
    }
}

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title>Ticket Type Registration</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

require_once 'title.php';
require_once 'common_functions.php';
require_once 'nav.php';

echo "<div id='content'>";
echo "<h4>Ticket Type Registration</h4><br>";

echo usr_error($_SESSION);

echo "<form method='post' action='ticket_booking.php'>";
echo "<input type='text' name='ticket_type' placeholder='Ticket Type' required><br>";
echo "<input type='date' name='ticket_date' placeholder='Start Date' required><br>";
echo "<input type='text' name='no_of_tickets' placeholder='Number of Tickets' required><br>";
echo "<input type='submit' name='submit' value='Register'><br><br>";
echo "</form>";

echo "</div>";  // Close content div
echo "</div>";  // Close container div

echo "</body>";
echo "</html>";
?>
