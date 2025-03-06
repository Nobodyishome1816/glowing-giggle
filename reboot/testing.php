<?php
session_start();

require_once('db_connect.php');
require_once('common_functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data

        $ticket_id = $_POST['ticket_type'];  // Selected ticket ID
        $no_of_tickets = (int) $_POST['no_of_tickets'];  // Number of tickets
        $ticket_date = $_POST['ticket_date'];  // Date selected
        $ticket_epoch_time = strtotime($ticket_date);  // Convert date to epoch time
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

        $conn = db_connect();
        $conn->beginTransaction(); // Start transaction

        // **Check ticket availability**
        $sql = "SELECT no_of_tickets FROM ticket WHERE ticket_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ticket_id]);
        $ticket_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ticket_data) {
            throw new Exception("Invalid ticket selection.");
        }

        $available_tickets = (int) $ticket_data['no_of_tickets'];

        if ($available_tickets < $no_of_tickets) {
            throw new Exception("Not enough tickets available.");
        }

        // **Insert into ticket_booking table**
        $date_booked = time(); // Current time in epoch
        $sql = "INSERT INTO ticket_booking (ticket_id, user_id, date_booked, ticket_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ticket_id, $user_id, $date_booked, $ticket_epoch_time]);

        // **Update the ticket count in the ticket table**
        $sql = "UPDATE ticket SET no_of_tickets = no_of_tickets - ? WHERE ticket_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$no_of_tickets, $ticket_id]);

        $conn->commit(); // Commit transaction

        $_SESSION['message'] = "Ticket booking successful!";
        header("Location: ticket_booking.php");
        exit;
    } catch (PDOException $e) {
        $conn->rollBack(); // Rollback if error
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "Database error occurred.";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

// **HTML FORM AND DISPLAY CODE**

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
echo "<input type='hidden' name='user_id' value='$_SESSION[user_id]'>";
echo "<select name='ticket_type' required>";
echo "<option value='' disabled selected>Select a Ticket</option>"; // Default option

$ticket_types = get_ticket_types(db_connect());  // Fetch ticket types

foreach ($ticket_types as $type) {
    echo "<option value='" . $type['ticket_id'] . "'>" . $type['ticket_type'] . " (Available: " . $type['no_of_tickets'] . ")</option>";
}

echo "</select><br>";
echo "<input type='date' name='ticket_date' required><br>";
echo "<input type='number' name='no_of_tickets' min='1' placeholder='Number of Tickets' required><br>";
echo "<input type='submit' name='submit' value='Register'><br><br>";
echo "</form>";

echo "</div>";  // Close content div
echo "</div>";  // Close container div
echo "</body>";
echo "</html>";
?>
