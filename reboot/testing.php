<?php

session_start();

require_once('db_connect.php');
require_once('common_functions.php');

// Step 1: Display available tickets in the dropdown
function getAvailableTickets() {
    $conn = db_connect();
    $sql = "SELECT ticket_id, ticket_type, no_of_tickets FROM ticket WHERE no_of_tickets > 0"; // Only tickets with available stock
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $tickets;
}

// Step 2: Process the booking when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data
        $ticket_id = $_POST['ticket_id'];  // Ticket ID from dropdown
        $no_of_tickets = $_POST['no_of_tickets'];  // Number of tickets to book
        $ticket_date = $_POST['ticket_date'];  // Date selected by the user
        $ticket_epoch_time = strtotime($ticket_date);  // Convert the date to epoch time
        $date_booked = time();  // Current timestamp for when the ticket is booked

        // Step 3: Check if there are enough tickets available
        $conn = db_connect();
        $sql = "SELECT no_of_tickets FROM ticket WHERE ticket_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $ticket_id);
        $stmt->execute();
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ticket && $ticket['no_of_tickets'] >= $no_of_tickets) {
            // Step 4: Insert booking into ticket_booking table
            $sql = "INSERT INTO ticket_booking (ticket_id, no_of_tickets, date_booked, ticket_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $ticket_id);
            $stmt->bindParam(2, $no_of_tickets);
            $stmt->bindParam(3, $date_booked);
            $stmt->bindParam(4, $ticket_epoch_time);
            $stmt->execute();

            // Step 5: Reduce the number of available tickets in the ticket table
            $new_no_of_tickets = $ticket['no_of_tickets'] - $no_of_tickets;
            $sql = "UPDATE ticket SET no_of_tickets = ? WHERE ticket_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $new_no_of_tickets);
            $stmt->bindParam(2, $ticket_id);
            $stmt->execute();

            $_SESSION['message'] = "Ticket Booking Successful!";
            header("Location: testing.php");  // Redirect to another page after successful booking
            exit;
        } else {
            $_SESSION['message'] = "Not enough tickets available.";
        }

        $conn = null;  // Close the connection
    } catch (PDOException $e) {
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
echo "<title>Ticket Booking</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

require_once 'title.php';
require_once 'common_functions.php';
require_once 'nav.php';

echo "<div id='content'>";
echo "<h4>Ticket Booking</h4><br>";

echo usr_error($_SESSION);

echo "<form method='post' action='testing.php'>";
echo "<label for='ticket_id'>Select Ticket:</label>";
echo "<select name='ticket_id' required>";
$availableTickets = getAvailableTickets();
foreach ($availableTickets as $ticket) {
    echo "<option value='" . $ticket['ticket_id'] . "'>" . $ticket['ticket_type'] . " - " . $ticket['no_of_tickets'] . " tickets available</option>";
}
echo "</select><br>";

echo "<input type='date' name='ticket_date' required placeholder='select a date you want to attend'><br>";

echo "<input type='text' name='no_of_tickets' required min='1' max='100' placeholder='number of tickets'><br>";

echo "<input type='submit' name='submit' value='Book Tickets'><br><br>";

echo "</form>";

echo "</div>";  // Close content div
echo "</div>";  // Close container div

echo "</body>";
echo "</html>";
?>
