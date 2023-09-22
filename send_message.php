<?php
// Include the database connection
include('dbcon.php');
session_start();

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $receiverID = $_POST['receiver_id'];

    // Insert the message into the database
    $query = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iis', $_SESSION['tenantID'], $receiverID, $message);
    $stmt->execute();
    $stmt->close();
}
?>
