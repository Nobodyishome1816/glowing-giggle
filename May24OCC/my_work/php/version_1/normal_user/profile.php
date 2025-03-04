<?php

session_start();  // Start the session to access session variables

// Check if the user is logged in by checking if the session variable is set
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if user is not logged in
    exit();
}

// Get user data from session variables
$first_name = $_SESSION['f_name'];
$last_name = $_SESSION['s_name'];
$email = $_SESSION['email'];
$privilege = $_SESSION['privl'];


?>

<!DOCTYPE HTML>
<html lang="en">
<head>

</head>
<body>
<p>welcome to your profile page <?php echo htmlspecialchars($first_name)?></p>
</body>
</html>