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
        $sql = "INSERT INTO ticket_booking (date_booked, ticket_date) VALUES (?, ?)";  // Prepare SQL query to insert
        $stmt = $conn->prepare($sql);  // Prepare statement

        // Bind parameters for security
        $stmt->bindParam(1, $date_booked);
        $stmt->bindParam(2, $ticket_epoch_time);  // Bind the epoch time to the query

        // Execute the query
        $stmt->execute();
        $conn = null;  // Close the connection

        $_SESSION['message'] = "Ticket booking Successful!";
        header("Location: ticket_booking.php");  // Redirect to another page after successful registration
        exit; // Stop further execution
    }  catch (PDOException $e) {
        // Handle database errors
        error_log("Ticket booking Database error: " . $e->getMessage());  // Log the error
        throw new Exception("Ticket booking Database error: " . $e->getMessage());  // Throw exception for calling script to handle
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Ticket booking error: " . $e->getMessage());  // Log the error
        throw new Exception("Ticket booking error: " . $e->getMessage());  // Throw exception for calling script to handle
    }
}

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";

echo "<link rel='stylesheet' href='styles.css'>";

echo "<title>Ticket booking</title>";

echo "</head>";

echo "<body>";

echo "<div id='container'>";

require_once 'title.php';

require_once 'common_functions.php';

require_once 'nav.php';

echo "<div id='content'>";

echo "<h4>Ticket booking</h4><br>";

echo usr_error($_SESSION);

echo "<form method='post' action='ticket_booking.php'>";

echo "<select name='ticket_type'><br>";
$ticket_type = get_ticket_types(db_connect());

foreach ($ticket_type as $type) {
    echo "<option value=" . $type['ticketid'] . "'>" . $type['ticket_type'] . "</option>";
}

echo "</select>";

echo "<input type='date' name='ticket_date' placeholder='Start Date' required><br>";

echo "<input type='text' name='no_of_tickets' placeholder='Number of Tickets' required><br>";

echo "<input type='submit' name='submit' value='Register'><br><br>";

echo "</form>";

echo "</div>";  // Close content div

echo "</div>";  // Close container div

echo "</body>";

echo "</html>";
?>
