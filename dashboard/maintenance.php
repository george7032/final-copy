<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: ../owner_login.php"); // Redirect to the login page if not logged in
    exit();
}

include("../dbcon.php"); // Adjust the path as needed

// Fetch owner-specific data from the database
$ownerID = $_SESSION["id"];
// Query the database to retrieve owner-specific information
// Replace 'owners' with your actual owner table name and columns
$query = "SELECT * FROM owners WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $ownerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $ownerData = $result->fetch_assoc();
} else {
    // Handle the case where owner data is not found (should not happen if session is valid)
    header("location: ../owner_login.php");
    exit();
}

// Include any necessary CSS or JavaScript files
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <header>
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <a href="dashboard/owner_dashboard.php">Dashboard</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </header>

    <section class="container">
        <h2>Maintenance</h2>
        <!-- Implement a chat space for communication with tenants -->
        <div class="chat-container">
            <!-- Display chat messages here -->
        </div>
        <form id="chat-form">
            <input type="text" id="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </section>

    <!-- Include your JavaScript for handling chat functionality -->
</body>
</html>
