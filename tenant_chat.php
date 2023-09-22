<?php
// Include the database connection and session management
include('dbcon.php');
session_start();

// Check if the tenant is logged in
if (!isset($_SESSION['tenantID'])) {
    header('location: tenant_login.php');
    exit();
}

// Handle sending a message
if (isset($_POST['send_message'])) {
    $message = $_POST['message'];
    $receiverID = $_POST['receiver_id']; // Owner's ID

    // Insert the message into the database
    $query = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iis', $_SESSION['tenantID'], $receiverID, $message);
    $stmt->execute();
    $stmt->close();
}

// Retrieve chat history with the owner
$ownerID = 1; // Replace with the actual owner's ID
$query = "SELECT * FROM chat_messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC";
$stmt = $con->prepare($query);
$stmt->bind_param('iiii', $_SESSION['tenantID'], $ownerID, $ownerID, $_SESSION['tenantID']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tenant Chat</title>
    <!-- Add the following code to the <head> section of your HTML -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to load and display messages
        function loadMessages() {
            $.ajax({
                url: 'load_messages.php', // Create this file to load messages
                method: 'POST',
                data: { receiver_id: <?php echo $ownerID; ?> },
                success: function (response) {
                    $('#chat-container').html(response);
                }
            });
        }

        // Load messages when the page loads
        loadMessages();

        // Submit a new message
        $('#message-form').submit(function (e) {
            e.preventDefault();
            var message = $('#message').val();

            $.ajax({
                url: 'send_message.php', // Create this file to send messages
                method: 'POST',
                data: { receiver_id: <?php echo $ownerID; ?>, message: message },
                success: function () {
                    loadMessages();
                    $('#message').val('');
                }
            });
        });
    });
</script>
<!-- End of added code in the <head> section -->

<!-- Modify your chat container and form as follows -->
<div id="chat-container">
    <!-- Messages will be loaded here -->
</div>
<form id="message-form" method="post">
    <input type="text" id="message" name="message" placeholder="Type your message">
    <button type="submit" name="send_message">Send</button>
</form>

</head>
<body>
    <h1>Tenant Chat</h1>
    <div id="chat-container">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="message">
                <strong><?php echo $row['sender_id'] == $_SESSION['tenantID'] ? 'You' : 'Owner'; ?>:</strong>
                <?php echo $row['message']; ?>
            </div>
        <?php endwhile; ?>
    </div>
    <form method="post">
        <input type="text" name="message" placeholder="Type your message">
        <input type="hidden" name="receiver_id" value="<?php echo $ownerID; ?>">
        <button type="submit" name="send_message">Send</button>
    </form>
</body>
</html>
